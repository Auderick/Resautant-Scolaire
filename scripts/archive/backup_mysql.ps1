[CmdletBinding()]
param(
    [string]$projectRoot = (Resolve-Path (Join-Path $PSScriptRoot ".."))
)

Write-Host "Script démarré"
Write-Host "Dossier projet: $projectRoot"

# Configuration
$mysqlDir = Join-Path $projectRoot "gestion_restaurant_desktop\resources\mysql"
$backupDir = Join-Path $projectRoot "backups\mysql"
$timestamp = Get-Date -Format "yyyy-MM-dd_HH-mm-ss"
$backupPath = Join-Path $backupDir $timestamp
$maxBackups = 5
$logFile = Join-Path $projectRoot "logs\backup.log"

# Fonction de logging
function Write-Log {
    param([string]$Message)
    $logMessage = "$(Get-Date -Format 'yyyy-MM-dd HH:mm:ss'): $Message"
    Write-Host $logMessage
    Write-Debug "Log file: $logFile"
    try {
        Add-Content -Path $logFile -Value $logMessage -ErrorAction Stop
        Write-Debug "Message logged successfully"
    } catch {
        Write-Warning "Impossible d'écrire dans le fichier log: $_"
    }
}

# Créer les dossiers nécessaires
if (-not (Test-Path $backupDir)) {
    New-Item -ItemType Directory -Path $backupDir -Force | Out-Null
}

if (-not (Test-Path (Split-Path $logFile))) {
    New-Item -ItemType Directory -Path (Split-Path $logFile) -Force | Out-Null
}

Write-Log "🔄 Démarrage de la sauvegarde MySQL..."

# Vérifier que MySQL est installé
if (-not (Test-Path $mysqlDir)) {
    Write-Warning "Le dossier MySQL n'existe pas: $mysqlDir"
    exit 1
}

# Vérifier si MySQL est en cours d'exécution
$mysqld = Join-Path $mysqlDir "bin\mysqld.exe"
$mysqlProcesses = Get-Process | Where-Object { $_.Path -eq $mysqld }

if ($mysqlProcesses) {
    $mysqlProcess = $mysqlProcesses | Select-Object -First 1
    Write-Debug "MySQL trouvé avec PID: $($mysqlProcess.Id)"
} else {
    Write-Debug "Aucun processus MySQL trouvé"
}

if ($mysqlProcess) {
    Write-Log "🛑 Arrêt du serveur MySQL..."
    $mysqlProcess | Stop-Process -Force
    Start-Sleep -Seconds 5
}

try {
    # Créer le dossier de sauvegarde
    New-Item -ItemType Directory -Path $backupPath -Force | Out-Null
    
    # Copier les fichiers MySQL
    Write-Log "📂 Copie des fichiers MySQL..."
    Copy-Item -Path $mysqlDir -Destination $backupPath -Recurse
    
    # Vérifier l'intégrité de la sauvegarde
    Write-Log "✔️ Vérification de l'intégrité..."
    $sourceFiles = Get-ChildItem -Path $mysqlDir -Recurse | Measure-Object
    $backupFiles = Get-ChildItem -Path (Join-Path $backupPath "mysql") -Recurse | Measure-Object
    
    if ($sourceFiles.Count -ne $backupFiles.Count) {
        throw "Erreur d'intégrité: Le nombre de fichiers ne correspond pas"
    }
    
    # Nettoyer les anciennes sauvegardes
    Write-Log "🧹 Nettoyage des anciennes sauvegardes..."
    Get-ChildItem -Path $backupDir | 
        Sort-Object CreationTime -Descending | 
        Select-Object -Skip $maxBackups | 
        Remove-Item -Recurse -Force
    
    Write-Log "✅ Sauvegarde terminée avec succès: $backupPath"
}
catch {
    Write-Log "❌ Erreur lors de la sauvegarde: $_"
    throw
}
finally {
    if ($mysqlProcess) {
        Write-Log "🔄 Redémarrage du serveur MySQL..."
        $mysqld = Join-Path $mysqlDir "bin\mysqld.exe"
        $mysqlIni = Join-Path $mysqlDir "my.ini"
        Start-Process -FilePath $mysqld -ArgumentList "--defaults-file=$mysqlIni" -WindowStyle Hidden
    }
}
