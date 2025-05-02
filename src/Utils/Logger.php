<?php

class Logger
{
    private static $logFile = __DIR__ . '/../../logs/app.log';

    public static function log($message, $data = null)
    {
        if (!file_exists(dirname(self::$logFile))) {
            mkdir(dirname(self::$logFile), 0777, true);
        }

        $logMessage = date('Y-m-d H:i:s') . ' - ' . $message;
        if ($data !== null) {
            $logMessage .= ' - ' . json_encode($data);
        }
        $logMessage .= PHP_EOL;

        file_put_contents(self::$logFile, $logMessage, FILE_APPEND);
    }
}
