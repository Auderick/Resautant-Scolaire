# Script de sauvegarde pour l'application de gestion de restaurant scolaire
$ErrorActionPreference = "Stop"

# Configuration
$projectRoot = (Get-Item $PSScriptRoot).Parent.FullName
$backupRoot = Join-Path $projectRoot "backups"
$databaseBackupDir = Join-Path $backupRoot "database"
$filesBackupDir = Join-Path $backupRoot "files"
$timestamp = Get-Date -Format "yyyy-MM-dd_HH-mm"
$databaseBackupFile = Join-Path $databaseBackupDir "backup_${timestamp}.sql"
$filesBackupFile = Join-Path $filesBackupDir "files_backup_${timestamp}.zip"

# Chemin vers mysqldump
$mysqldumpPath = Join-Path $projectRoot "gestion_restaurant_desktop" "resources" "mysql" "bin" "mysqldump.exe"
if (-not (Test-Path $mysqldumpPath)) {
    throw "mysqldump.exe non trouvé dans : $mysqldumpPath"
}

# Création des répertoires de sauvegarde si nécessaires
@($backupRoot, $databaseBackupDir, $filesBackupDir) | ForEach-Object {
    if (-not (Test-Path $_)) {
        New-Item -ItemType Directory -Path $_ -Force
    }
}

Write-Host "🔄 Démarrage de la sauvegarde..." -ForegroundColor Cyan

try {
    # Vérifier que mysqldump existe
    if (-not (Test-Path $mysqldumpPath)) {
        throw "mysqldump non trouvé à l'emplacement : $mysqldumpPath"
    }

    # Sauvegarde de la base de données
    Write-Host "📑 Sauvegarde de la base de données..." -ForegroundColor Yellow
    Write-Host "   Utilisation de mysqldump: $mysqldumpPath" -ForegroundColor Gray
    
    # Lecture des informations de connexion depuis le fichier de configuration
    $configPath = Join-Path $PSScriptRoot ".." "config" "database.php"
    $configContent = Get-Content $configPath -Raw
    if ($configContent -match "define\('DB_HOST',\s*'([^']+)'\);") { $dbHost = $matches[1] }
    if ($configContent -match "define\('DB_NAME',\s*'([^']+)'\);") { $dbName = $matches[1] }
    if ($configContent -match "define\('DB_USER',\s*'([^']+)'\);") { $dbUser = $matches[1] }
    if ($configContent -match "define\('DB_PASS',\s*'([^']+)'\);") { $dbPass = $matches[1] }

    # Exporter la base de données
    Write-Host "   Utilisation de la configuration locale MySQL embarquée..." -ForegroundColor Gray
    
    # Configuration MySQL locale depuis database.js
    $dbConfigPath = Join-Path $projectRoot "gestion_restaurant_desktop\config\database.js"
    $dbConfigContent = Get-Content $dbConfigPath -Raw
    
    # Vérifier si MySQL est en cours d'exécution
    $mysqldDir = Join-Path $projectRoot "gestion_restaurant_desktop\resources\mysql\data"
    Write-Host "   Vérification du service MySQL..." -ForegroundColor Gray
    
    # Copier directement les fichiers de la base de données
    Write-Host "   Copie directe des fichiers de la base de données..." -ForegroundColor Gray
    $dbFiles = @(
        "$mysqldDir\gestion_restaurant_scolaire",
        "$mysqldDir\mysql",
        "$mysqldDir\performance_schema"
    )
    
    # Créer un dossier temporaire pour la base de données
    $tempDbDir = Join-Path $env:TEMP "mysql_backup_temp"
    if (Test-Path $tempDbDir) {
        Remove-Item $tempDbDir -Recurse -Force
    }
    New-Item -ItemType Directory -Path $tempDbDir -Force | Out-Null
    
    # Copier les fichiers
    foreach ($dbFile in $dbFiles) {
        if (Test-Path $dbFile) {
            $destDir = Join-Path $tempDbDir (Split-Path $dbFile -Leaf)
            Copy-Item $dbFile $destDir -Recurse -Force
        }
    }
    
    # Créer l'archive de la base de données
    Compress-Archive -Path "$tempDbDir\*" -DestinationPath $databaseBackupFile -Force
    
    # Nettoyer
    Remove-Item $tempDbDir -Recurse -Force
    
    # Compresser le fichier SQL
    Compress-Archive -Path $databaseBackupFile -DestinationPath "$databaseBackupFile.zip" -Force
    Remove-Item $databaseBackupFile

    # Sauvegarde des fichiers du projet
    Write-Host "📂 Sauvegarde des fichiers..." -ForegroundColor Yellow    $excludeDirs = @(
        'backups', 
        'vendor', 
        'node_modules',
        '.git',
        'logs',
        'mysql\\data'
    )    # Créer un dossier temporaire pour la sauvegarde
    $tempDir = Join-Path $env:TEMP "gestion_resto_backup_temp"
    if (Test-Path $tempDir) {
        Remove-Item $tempDir -Recurse -Force
    }
    New-Item -ItemType Directory -Path $tempDir -Force | Out-Null

    Write-Host "   Copie des fichiers..." -ForegroundColor Gray

    # Liste des dossiers à exclure
    $excludeDirs = @(
        'backups', 
        'vendor', 
        'node_modules',
        '.git',
        'logs',
        'mysql'
    )

    # Copier les fichiers en excluant les dossiers non désirés
    Get-ChildItem -Path $projectRoot -Recurse |
        Where-Object { 
            $exclude = $false
            foreach ($dir in $excludeDirs) {
                if ($_.FullName -like "*\$dir\*") {
                    $exclude = $true
                    break
                }
            }
            -not $exclude
        } |
        ForEach-Object {
            if (-not $_.PSIsContainer) {
                $relativePath = $_.FullName.Substring($projectRoot.Length + 1)
                $targetPath = Join-Path $tempDir $relativePath
                $targetDir = Split-Path $targetPath -Parent
                
                if (!(Test-Path $targetDir)) {
                    New-Item -ItemType Directory -Path $targetDir -Force | Out-Null
                }
                
                Copy-Item $_.FullName -Destination $targetPath -Force
            }
        }

    Write-Host "   Création de l'archive..." -ForegroundColor Gray
    if (Test-Path "$tempDir\*") {
        Compress-Archive -Path "$tempDir\*" -DestinationPath $filesBackupFile -Force
    } else {
        Write-Warning "Aucun fichier trouvé pour la sauvegarde"
    }

    # Nettoyer le dossier temporaire
    Remove-Item $tempDir -Recurse -Force

    # Nettoyage des anciennes sauvegardes (garder les 5 plus récentes)
    Write-Host "🧹 Nettoyage des anciennes sauvegardes..." -ForegroundColor Yellow
    $keepCount = 5

    Get-ChildItem -Path $databaseBackupDir -Filter "backup_*.sql.zip" |
        Sort-Object CreationTime -Descending |
        Select-Object -Skip $keepCount |
        Remove-Item -Force

    Get-ChildItem -Path $filesBackupDir -Filter "files_backup_*.zip" |
        Sort-Object CreationTime -Descending |
        Select-Object -Skip $keepCount |
        Remove-Item -Force

    Write-Host "✅ Sauvegarde terminée avec succès!" -ForegroundColor Green
    Write-Host "📍 Fichiers de sauvegarde:"
    Write-Host "   - Base de données: $databaseBackupFile.zip" -ForegroundColor Cyan
    Write-Host "   - Fichiers: $filesBackupFile" -ForegroundColor Cyan
}
catch {
    Write-Host "❌ Erreur lors de la sauvegarde:" -ForegroundColor Red
    Write-Host $_.Exception.Message -ForegroundColor Red
    Write-Host "📋 Stack trace:" -ForegroundColor Red
    Write-Host $_.Exception.StackTrace -ForegroundColor Red
    exit 1
}
