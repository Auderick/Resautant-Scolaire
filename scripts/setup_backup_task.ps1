# Chemin vers le script de sauvegarde
$scriptPath = Join-Path $PSScriptRoot "backup_app.ps1"
$scriptPath = (Resolve-Path $scriptPath).Path

# Nom de la tâche
$taskName = "Sauvegarde_Restaurant_Scolaire"

# Création de l'action qui exécute le script
$action = New-ScheduledTaskAction -Execute "powershell.exe" -Argument "-NoProfile -ExecutionPolicy Bypass -File `"$scriptPath`""

# Définir le déclencheur (tous les jours à 23h)
$trigger = New-ScheduledTaskTrigger -Daily -At "23:00"

# Créer la tâche
Register-ScheduledTask -TaskName $taskName -Action $action -Trigger $trigger -RunLevel Highest -Force

Write-Host "✅ Tâche planifiée créée avec succès !"
Write-Host "   La sauvegarde s'exécutera automatiquement tous les jours à 23h"
