# Script PowerShell de sauvegarde automatique pour l'application Restaurant Scolaire
# Auteur : WebTransform
# Date : 2025-05-18

# --- FONCTIONS UTILITAIRES ---
function Write-Log {
    param($Message)
    $logMessage = "$(Get-Date -Format 'yyyy-MM-dd HH:mm:ss'): $Message"
    Write-Output $logMessage
    if ($logFile) {
        Add-Content -Path $logFile -Value $logMessage
    }
}

function Test-Prerequisites {
    # Vérification de MAMP
    if (!(Test-Path $mampMysqlPath)) {
        Write-Log "[ERREUR] mysqldump.exe non trouvé dans MAMP"
        return $false
    }

    # Vérification des dossiers sources
    foreach ($folder in $foldersToBackup) {
        if (!(Test-Path $folder)) {
            Write-Log "[ATTENTION] Dossier non trouvé: $folder"
        }
    }

    # Création des dossiers de backup si nécessaire
    $foldersToCreate = @($backupRoot, "$backupRoot\database", "$backupRoot\files", "$backupRoot\logs")
    foreach ($folder in $foldersToCreate) {
        if (!(Test-Path $folder)) {
            New-Item -ItemType Directory -Path $folder -Force | Out-Null
            Write-Log "[INFO] Création du dossier: $folder"
        }
    }

    return $true
}

# --- CONFIGURATION ---
$backupRoot = "C:\MAMP\htdocs\compte_restaurant_scolaire\backups"
$dbUser = "root"
$dbPassword = "root"  # Mot de passe de MAMP par défaut
$dbName = "compte_restaurant_scolaire"
$mampMysqlPath = "C:\MAMP\bin\mysql\bin\mysqldump.exe"
$mampPort = "3306"

# Dossiers à sauvegarder
$foldersToBackup = @(
    "C:\MAMP\htdocs\compte_restaurant_scolaire\templates\haccp",
    "C:\MAMP\htdocs\compte_restaurant_scolaire\templates\haccp\documents",
    "C:\MAMP\htdocs\compte_restaurant_scolaire\templates\haccp\templates",
    "C:\MAMP\htdocs\compte_restaurant_scolaire\templates\haccp\archives",
    "C:\MAMP\htdocs\compte_restaurant_scolaire\templates\menus",
    "C:\MAMP\htdocs\compte_restaurant_scolaire\templates\commandes",
    "C:\MAMP\htdocs\compte_restaurant_scolaire\templates\stocks",
    "C:\MAMP\htdocs\compte_restaurant_scolaire\templates\syntheses",
    "C:\MAMP\htdocs\compte_restaurant_scolaire\templates\ventes",
    "C:\MAMP\htdocs\compte_restaurant_scolaire\templates\achats",
    "C:\MAMP\htdocs\compte_restaurant_scolaire\config",
    "C:\MAMP\htdocs\compte_restaurant_scolaire\public",
    "C:\MAMP\htdocs\compte_restaurant_scolaire\src\Models",
    "C:\MAMP\htdocs\compte_restaurant_scolaire\api",
    "C:\MAMP\htdocs\compte_restaurant_scolaire\includes"
)

$date = Get-Date -Format "yyyy-MM-dd_HH-mm"
$logFile = "$backupRoot\logs\backup_$date.log"

# --- VÉRIFICATION DES PRÉREQUIS ---
if (!(Test-Prerequisites)) {
    Write-Log "[ERREUR CRITIQUE] Conditions préalables non remplies, arrêt de la sauvegarde"
    exit 1
}

# --- SAUVEGARDE BASE DE DONNÉES ---
$dbBackupDir = "$backupRoot\database"
$dbBackupFile = "$dbBackupDir\backup_${date}.sql"

Write-Log "[INFO] Début de la sauvegarde de la base de données..."
try {
    $result = & $mampMysqlPath --user=$dbUser --password=$dbPassword --port=$mampPort --host=localhost --databases $dbName --result-file=$dbBackupFile 2>&1
    if ($LASTEXITCODE -eq 0 -and (Test-Path $dbBackupFile)) {
        Write-Log "[OK] Base de données sauvegardée dans $dbBackupFile"
        
        # Compression du fichier SQL
        Compress-Archive -Path $dbBackupFile -DestinationPath "$dbBackupFile.zip" -Force
        if (Test-Path "$dbBackupFile.zip") {
            Remove-Item $dbBackupFile -Force
            Write-Log "[OK] Fichier SQL compressé avec succès"
        }
    } else {
        Write-Log "[ERREUR] Échec de la sauvegarde MySQL: $result"
        exit 1
    }
} catch {
    Write-Log "[ERREUR] Exception lors de la sauvegarde MySQL: $_"
    exit 1
}

# --- SAUVEGARDE DES FICHIERS ---
$filesBackupDir = "$backupRoot\files"
$filesBackupFile = "$filesBackupDir\files_backup_${date}.zip"
$tempDir = "$backupRoot\temp"

Write-Log "[INFO] Début de la sauvegarde des fichiers..."
try {
    # Création d'un dossier temporaire pour la copie
    if (Test-Path $tempDir) { Remove-Item $tempDir -Recurse -Force }
    New-Item -ItemType Directory -Path $tempDir -Force | Out-Null

    # Copie des fichiers avec leur structure
    foreach ($folder in $foldersToBackup) {
        if (Test-Path $folder) {
            $relativePath = $folder.Replace("C:\MAMP\htdocs\compte_restaurant_scolaire\", "")
            $destination = Join-Path $tempDir $relativePath
            
            # Création du dossier de destination
            New-Item -ItemType Directory -Path (Split-Path $destination) -Force | Out-Null
            
            # Copie des fichiers
            Copy-Item -Path $folder -Destination $destination -Recurse -Force
            Write-Log "[INFO] Copié: $relativePath"
        }
    }

    # Compression des fichiers
    Compress-Archive -Path "$tempDir\*" -DestinationPath $filesBackupFile -Force
    if (Test-Path $filesBackupFile) {
        Write-Log "[OK] Fichiers sauvegardés dans $filesBackupFile"
        Remove-Item $tempDir -Recurse -Force
    } else {
        Write-Log "[ERREUR] Échec de la compression des fichiers"
        exit 1
    }
} catch {
    Write-Log "[ERREUR] Exception lors de la sauvegarde des fichiers: $_"
    if (Test-Path $tempDir) { Remove-Item $tempDir -Recurse -Force }
    exit 1
}

# --- ROTATION DES SAUVEGARDES (30 jours) ---
Write-Log "[INFO] Nettoyage des anciennes sauvegardes..."
try {
    $oldFiles = @()
    $oldFiles += Get-ChildItem $dbBackupDir -File | Where-Object { $_.LastWriteTime -lt (Get-Date).AddDays(-30) }
    $oldFiles += Get-ChildItem $filesBackupDir -File | Where-Object { $_.LastWriteTime -lt (Get-Date).AddDays(-30) }
    
    foreach ($file in $oldFiles) {
        Remove-Item $file.FullName -Force
        Write-Log "[INFO] Supprimé: $($file.Name)"
    }

    # Vérification de l'espace disque
    $drive = (Get-Item $backupRoot).PSDrive
    $freeSpaceGB = [math]::Round($drive.Free / 1GB, 2)
    Write-Log "[INFO] Espace disque disponible: $freeSpaceGB GB"
    
    if ($freeSpaceGB -lt 5) {
        Write-Log "[ATTENTION] Espace disque faible (< 5 GB)"
    }
} catch {
    Write-Log "[ERREUR] Problème lors du nettoyage: $_"
}

Write-Log "----------------------------------------"
Write-Log "[INFO] Sauvegarde terminée avec succès"
Write-Log "----------------------------------------"
