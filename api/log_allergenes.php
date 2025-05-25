<?php

// Définir les headers pour autoriser les requêtes AJAX
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

// Vérifier que c'est bien une requête POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    die(json_encode(['error' => 'Méthode non autorisée']));
}

// Récupérer les données
$logData = $_POST;
$logData['timestamp'] = date('Y-m-d H:i:s');

// Formatter le message de log
$logMessage = sprintf(
    "[%s] [%s]: %s\n",
    $logData['timestamp'],
    $logData['type'],
    $logData['message']
);

// Écrire dans le fichier de log
$logFile = __DIR__ . '/../logs/allergenes_debug.log';
file_put_contents($logFile, $logMessage, FILE_APPEND);

// Répondre avec succès
echo json_encode(['success' => true]);
