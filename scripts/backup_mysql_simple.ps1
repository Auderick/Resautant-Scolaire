# Script simplifié de sauvegarde MySQL
$ErrorActionPreference = "Stop"
Write-Host "🔄 Démarrage de la sauvegarde MySQL..." -ForegroundColor Cyan

# Configuration
$projectRoot = (Get-Item $PSScriptRoot).Parent.FullName
$mysqlDir = Join-Path $projectRoot "gestion_restaurant_desktop\resources\mysql"
$backupDir = Join-Path $projectRoot "backups\database"
$timestamp = Get-Date -Format "yyyy-MM-dd_HH-mm"
$backupFile = Join-Path $backupDir "mysql_${timestamp}.zip"

# Création du dossier de backup
if (-not (Test-Path $backupDir)) {
    New-Item -ItemType Directory -Path $backupDir -Force | Out-Null
}

try {
    # Vérifier que MySQL existe
    Write-Host "📂 Vérification de MySQL..." -ForegroundColor Yellow
    if (-not (Test-Path $mysqlDir)) {
        throw "MySQL n'est pas trouvé dans : $mysqlDir"
    }

    # Arrêter MySQL s'il est en cours d'exécution
    $mysqlProcess = Get-Process "mysqld" -ErrorAction SilentlyContinue
    if ($mysqlProcess) {
        Write-Host "🛑 Arrêt de MySQL..." -ForegroundColor Yellow
        $mysqlProcess | Stop-Process -Force
        Start-Sleep -Seconds 5
    }

    # Créer un dossier temporaire
    Write-Host "📂 Préparation de la sauvegarde..." -ForegroundColor Yellow
    $tempDir = Join-Path $env:TEMP "mysql_backup_temp"
    if (Test-Path $tempDir) {
        Remove-Item $tempDir -Recurse -Force
    }
    New-Item -ItemType Directory -Path $tempDir -Force | Out-Null

    # Copier les fichiers de la base de données
    Write-Host "📑 Copie des fichiers MySQL..." -ForegroundColor Yellow
    $dataDir = Join-Path $mysqlDir "data"
    if (Test-Path $dataDir) {
        Copy-Item -Path $dataDir -Destination $tempDir -Recurse
    } else {
        throw "Dossier data MySQL non trouvé dans : $dataDir"
    }

    # Créer l'archive
    Write-Host "📦 Création de l'archive..." -ForegroundColor Yellow
    Compress-Archive -Path "$tempDir\*" -DestinationPath $backupFile -Force

    # Nettoyage
    Remove-Item $tempDir -Recurse -Force    # Nettoyage des anciennes sauvegardes (garder les 5 plus récentes)
    Write-Host "🧹 Nettoyage des anciennes sauvegardes..." -ForegroundColor Yellow
    $keepCount = 5
    Get-ChildItem -Path $backupDir -Filter "mysql_*.zip" |
        Sort-Object CreationTime -Descending |
        Select-Object -Skip $keepCount |
        Remove-Item -Force
    
    Write-Host "✅ Sauvegarde terminée avec succès !" -ForegroundColor Green
    Write-Host "📍 Fichier de sauvegarde : $backupFile" -ForegroundColor Cyan
}
catch {
    Write-Host "❌ Erreur lors de la sauvegarde :" -ForegroundColor Red
    Write-Host $_.Exception.Message -ForegroundColor Red
    throw
}
finally {
    # Redémarrer MySQL si nécessaire
    if ($mysqlProcess) {
        Write-Host "🔄 Redémarrage de MySQL..." -ForegroundColor Yellow
        $mysqld = Join-Path $mysqlDir "bin\mysqld.exe"
        $mysqlIni = Join-Path $mysqlDir "my.ini"
        Start-Process -FilePath $mysqld -ArgumentList "--defaults-file=$mysqlIni" -WindowStyle Hidden
    }
}
