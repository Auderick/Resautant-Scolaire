<?php

class Logger
{
    private static $logFile = __DIR__ . '/../../logs/app.log';

    public static function log($message, $context = [])
    {
        $timestamp = date('Y-m-d H:i:s');
        $contextStr = !empty($context) ? ' ' . json_encode($context, JSON_UNESCAPED_UNICODE) : '';
        $logMessage = "[$timestamp] $message$contextStr" . PHP_EOL;

        // Création du dossier logs s'il n'existe pas
        $logDir = dirname(self::$logFile);
        if (!file_exists($logDir)) {
            mkdir($logDir, 0777, true);
        }

        // Écriture dans le fichier de log
        file_put_contents(self::$logFile, $logMessage, FILE_APPEND);

        // Log également dans error_log pour le debug
        error_log($logMessage);
    }
}
