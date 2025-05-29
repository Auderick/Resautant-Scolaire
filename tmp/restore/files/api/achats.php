<?php

require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../src/Models/achat.php';
require_once __DIR__ . '/../auth/auth_functions.php';

// Vérifier que l'utilisateur est connecté
session_start();
if (!isLoggedIn()) {
    header('HTTP/1.1 403 Forbidden');
    echo json_encode(['error' => 'Vous devez être connecté pour accéder à cette ressource']);
    exit;
}

// Définir le type de contenu en JSON
header('Content-Type: application/json');

// Créer une instance de la classe Achat
$achat = new Achat();

// Traiter la requête GET pour obtenir un achat par ID
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = intval($_GET['id']);
    $data = $achat->getById($id);

    if ($data) {
        // S'assurer que tous les champs nécessaires sont présents
        // Si certains champs sont NULL, les initialiser avec des valeurs par défaut
        $data['quantite'] = $data['quantite'] ?? 0;
        $data['unite'] = $data['unite'] ?? '';
        $data['prix_unitaire'] = $data['prix_unitaire'] ?? 0;
        $data['montant_total'] = $data['montant_total'] ?? 0;

        echo json_encode($data);
    } else {
        header('HTTP/1.1 404 Not Found');
        echo json_encode(['error' => 'Achat non trouvé']);
    }
} else {
    header('HTTP/1.1 400 Bad Request');
    echo json_encode(['error' => 'ID manquant ou non valide']);
}
