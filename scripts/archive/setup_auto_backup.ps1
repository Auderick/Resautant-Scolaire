# Script de configuration des sauvegardes automatiques
$ErrorActionPreference = "Stop"

# Obtenir le chemin complet du script de sauvegarde
$scriptPath = Join-Path $PSScriptRoot "backup_app.ps1"
$scriptPath = [System.IO.Path]::GetFullPath($scriptPath)

# Vérifier que le script existe
if (-not (Test-Path $scriptPath)) {
    Write-Host "❌ Script de sauvegarde introuvable: $scriptPath" -ForegroundColor Red
    exit 1
}

try {
    # Créer une nouvelle tâche planifiée
    $taskName = "GestionRestaurantScolaire_Backup"
    $taskExists = Get-ScheduledTask -TaskName $taskName -ErrorAction SilentlyContinue

    if ($taskExists) {
        Write-Host "🔄 Mise à jour de la tâche planifiée existante..." -ForegroundColor Yellow
        Unregister-ScheduledTask -TaskName $taskName -Confirm:$false
    }
    else {
        Write-Host "📅 Création d'une nouvelle tâche planifiée..." -ForegroundColor Cyan
    }

    # Configurer le déclencheur (tous les jours à 20h00)
    $trigger = New-ScheduledTaskTrigger -Daily -At 8PM

    # Configurer l'action
    $action = New-ScheduledTaskAction -Execute "powershell.exe" -Argument "-NoProfile -ExecutionPolicy Bypass -File `"$scriptPath`""

    # Configurer les paramètres
    $settings = New-ScheduledTaskSettingsSet `
        -StartWhenAvailable `
        -DontStopOnIdleEnd `
        -RestartInterval (New-TimeSpan -Minutes 1) `
        -RestartCount 3

    # Créer la tâche
    Register-ScheduledTask `
        -TaskName $taskName `
        -Trigger $trigger `
        -Action $action `
        -Settings $settings `
        -Description "Sauvegarde automatique de l'application de gestion du restaurant scolaire" `
        -RunLevel Highest

    Write-Host "✅ Configuration de la sauvegarde automatique terminée!" -ForegroundColor Green
    Write-Host "📍 La sauvegarde s'exécutera automatiquement tous les jours à 20h00" -ForegroundColor Cyan
    Write-Host "💡 Vous pouvez modifier la planification dans le Planificateur de tâches Windows" -ForegroundColor Yellow
}
catch {
    Write-Host "❌ Erreur lors de la configuration:" -ForegroundColor Red
    Write-Host $_.Exception.Message -ForegroundColor Red
    exit 1
}
