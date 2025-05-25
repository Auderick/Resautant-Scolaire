<?php

header('Content-Type: application/json');

// Activer l'affichage des erreurs
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Récupérer les données JSON
$input = file_get_contents('php://input');
$data = json_decode($input, true);

if (!$data) {
    http_response_code(400);
    die(json_encode(['error' => 'Données invalides']));
}

// Formatter le message
$logMessage = sprintf(
    "[%s] [%s]: %s\n",
    date('Y-m-d H:i:s'),
    $data['type'] ?? 'info',
    $data['message'] ?? ''
);

// Chemin du fichier de log
$logFile = __DIR__ . '/../logs/allergenes_debug.log';

// Vérifier si le dossier logs existe, sinon le créer
$logsDir = dirname($logFile);
if (!is_dir($logsDir)) {
    mkdir($logsDir, 0777, true);
}

// S'assurer que le fichier est accessible en écriture
if (!is_file($logFile)) {
    touch($logFile);
    chmod($logFile, 0666);
}

// Écrire dans le fichier
if (file_put_contents($logFile, $logMessage, FILE_APPEND) === false) {
    http_response_code(500);
    die(json_encode([
        'error' => 'Échec de l\'écriture dans le fichier de log',
        'file' => $logFile,
        'isWritable' => is_writable($logFile),
        'permissions' => decoct(fileperms($logFile))
    ]));
}

echo json_encode(['success' => true]);
