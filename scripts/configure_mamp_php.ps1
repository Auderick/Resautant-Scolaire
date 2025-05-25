# Script PowerShell pour configurer MAMP et PHP
$mampPath = "C:\MAMP"
$phpPath = "$mampPath\bin\php\php8.2.14\php.ini"

Write-Host "Configuration de MAMP et PHP..."

# Activer error reporting dans php.ini
$phpIniContent = @"
[PHP]
error_reporting = E_ALL
display_errors = On
display_startup_errors = On
log_errors = On
error_log = "C:\MAMP\logs\php_error.log"
max_execution_time = 300
memory_limit = 256M
post_max_size = 128M
upload_max_filesize = 128M
extension_dir = "ext"

[Date]
date.timezone = "Europe/Paris"

[Session]
session.save_handler = files
session.save_path = "${mampPath}\tmp\php_sessions"
"@

# Créer les dossiers nécessaires s'ils n'existent pas
$sessionPath = "$mampPath\tmp\php_sessions"
New-Item -ItemType Directory -Force -Path $sessionPath | Out-Null
icacls $sessionPath /grant "EVERYONE:(OI)(CI)F" | Out-Null

$logsPath = "$mampPath\logs"
New-Item -ItemType Directory -Force -Path $logsPath | Out-Null
icacls $logsPath /grant "EVERYONE:(OI)(CI)F" | Out-Null

# Définir les permissions sur les dossiers
Write-Host "Configuration des permissions..."
icacls "$mampPath\htdocs" /grant "EVERYONE:(OI)(CI)F" | Out-Null

# Écrire la configuration PHP
$phpIniContent | Out-File -FilePath $phpPath -Encoding UTF8 -Force

Write-Host "Configuration terminée. Redémarrez MAMP pour appliquer les changements."
