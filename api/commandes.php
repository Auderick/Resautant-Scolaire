<?php

require_once __DIR__ . '/../src/Models/commande.php';

header('Content-Type: application/json');

// Vérifier si un ID est fourni
if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo json_encode(['error' => 'ID de commande non spécifié']);
    exit;
}

$commandeId = intval($_GET['id']);

// Initialiser le modèle
$commandeModel = new Commande();

try {
    // Récupérer les détails de la commande
    $commande = $commandeModel->getCommande($commandeId);
    if (!$commande) {
        echo json_encode(['error' => 'Commande introuvable']);
        exit;
    }

    // Récupérer les lignes de commande
    $lignesCommande = $commandeModel->getLignesCommande($commandeId);

    // Renvoyer les données au format JSON
    echo json_encode([
        'commande' => $commande,
        'lignes' => $lignesCommande
    ]);
} catch (Exception $e) {
    echo json_encode(['error' => 'Erreur lors de la récupération des données: ' . $e->getMessage()]);
}
