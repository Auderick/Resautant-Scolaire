<?php

require_once __DIR__ . '/../../includes/auth_check.php';
require_once __DIR__ . '/../../config/db.php';

// Accepter à la fois DELETE et POST pour la suppression
if ($_SERVER['REQUEST_METHOD'] === 'DELETE' || ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['_method']) && $_POST['_method'] === 'DELETE')) {
    $id = $_GET['id'] ?? null;

    if (!$id) {
        http_response_code(400);
        echo json_encode(['error' => 'ID du document manquant']);
        exit;
    }

    try {        // Récupérer le chemin du fichier
        $stmt = $db->prepare("SELECT file_path FROM haccp_documents WHERE id = ?");
        $stmt->execute([$id]);
        $document = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$document) {
            throw new Exception('Document non trouvé');
        }

        // Supprimer le fichier physique
        $filePath = __DIR__ . '/' . $document['file_path'];
        if (file_exists($filePath)) {
            unlink($filePath);
        }        // Supprimer l'entrée de la base de données
        $stmt = $db->prepare("DELETE FROM haccp_documents WHERE id = ?");
        $stmt->execute([$id]);

        echo json_encode(['success' => true, 'message' => 'Document supprimé avec succès']);

    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(['error' => $e->getMessage()]);
    }
} else {
    http_response_code(405);
    echo json_encode(['error' => 'Méthode non autorisée']);
}
