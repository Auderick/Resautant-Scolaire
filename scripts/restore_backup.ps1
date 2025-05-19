param(
    [Parameter(Mandatory=$true)]
    [string]$BackupDate
)

$ErrorActionPreference = "Stop"

function Write-Log {
    param($Message)
    $logMessage = "$(Get-Date -Format 'yyyy-MM-dd HH:mm:ss'): $Message"
    Write-Output $logMessage
}

# Chemins des fichiers
$backupRoot = "C:\MAMP\htdocs\compte_restaurant_scolaire\backups"
$dbBackup = Join-Path $backupRoot "database\backup_$BackupDate.sql.zip"
$filesBackup = Join-Path $backupRoot "files\files_backup_$BackupDate.zip"
$tempDir = Join-Path $backupRoot "temp"
$restoreDir = Join-Path $backupRoot "restore"

try {
    # 1. Vérification des fichiers de sauvegarde
    if (!(Test-Path $dbBackup) -or !(Test-Path $filesBackup)) {
        throw "Fichiers de sauvegarde non trouvés pour la date $BackupDate"
    }

    Write-Log "Début de la restauration des sauvegardes du $BackupDate"

    # 2. Création des dossiers temporaires
    @($tempDir, $restoreDir) | ForEach-Object {
        if (Test-Path $_) { Remove-Item $_ -Recurse -Force }
        New-Item -ItemType Directory -Path $_ -Force | Out-Null
    }

    # 3. Restauration de la base de données
    Write-Log "Décompression du fichier SQL..."
    Expand-Archive -Path $dbBackup -DestinationPath $tempDir

    $sqlFile = Get-ChildItem -Path $tempDir -Filter "*.sql" | Select-Object -First 1
    if (!$sqlFile) { throw "Fichier SQL non trouvé dans l'archive" }

    Write-Log "Recréation de la base de données..."
    & "C:\MAMP\bin\mysql\bin\mysql.exe" -u root -proot -e "DROP DATABASE IF EXISTS compte_restaurant_scolaire; CREATE DATABASE compte_restaurant_scolaire CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"

    Write-Log "Importation des données..."
    Get-Content $sqlFile.FullName | & "C:\MAMP\bin\mysql\bin\mysql.exe" -u root -proot compte_restaurant_scolaire

    # 4. Restauration des fichiers
    Write-Log "Restauration des fichiers..."
    Expand-Archive -Path $filesBackup -DestinationPath $restoreDir

    Write-Log "Copie des fichiers vers leur destination..."
    $targetDirs = @("templates", "config", "public", "src", "api", "includes")
    foreach ($dir in $targetDirs) {
        $source = Join-Path $restoreDir $dir
        $destination = "C:\MAMP\htdocs\compte_restaurant_scolaire\$dir"
        if (Test-Path $source) {
            if (Test-Path $destination) { Remove-Item $destination -Recurse -Force }
            Copy-Item -Path $source -Destination $destination -Recurse -Force
            Write-Log "Restauré: $dir"
        }
    }

    # 5. Nettoyage
    Write-Log "Nettoyage des fichiers temporaires..."
    Remove-Item $tempDir -Recurse -Force
    Remove-Item $restoreDir -Recurse -Force

    Write-Log "Restauration terminée avec succès"
} catch {
    Write-Log "ERREUR: $_"
    if (Test-Path $tempDir) { Remove-Item $tempDir -Recurse -Force }
    if (Test-Path $restoreDir) { Remove-Item $restoreDir -Recurse -Force }
    exit 1
}
