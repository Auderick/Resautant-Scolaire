<?php

require_once __DIR__ . '/../../includes/auth_check.php';
require_once __DIR__ . '/../../config/db.php';

$category = $_GET['category'] ?? '';
$date = $_GET['date'] ?? '';

try {
    $sql = "SELECT 
                h.*,
                u.nom as uploaded_by_name
            FROM haccp_documents h
            LEFT JOIN utilisateurs u ON h.uploaded_by = u.id
            WHERE 1=1";
    $params = [];

    if ($category) {
        $sql .= " AND h.category = ?";
        $params[] = $category;
    }

    if ($date) {
        $sql .= " AND DATE_FORMAT(h.upload_date, '%Y-%m') = ?";
        $params[] = $date;
    }

    $sql .= " ORDER BY h.upload_date DESC";    $stmt = $db->prepare($sql);
    $stmt->execute($params);
    $documents = $stmt->fetchAll(PDO::FETCH_ASSOC);// Formater les données pour l'affichage
    $documents = array_map(function ($doc) {
        return [
            'id' => $doc['id'],
            'name' => $doc['name'],
            'category' => ucfirst($doc['category']),
            'date' => (new DateTime($doc['upload_date']))->format('d/m/Y H:i'),
            'path' => 'documents/' . $doc['category'] . '/' . basename($doc['file_path']),
            'uploaded_by' => $doc['uploaded_by_name']
        ];
    }, $documents);

    header('Content-Type: application/json');
    echo json_encode($documents);

} catch (PDOException $e) {
    error_log("Erreur SQL dans list_documents.php : " . $e->getMessage());
    http_response_code(500);
    echo json_encode(['error' => 'Erreur lors de la récupération des documents: ' . $e->getMessage()]);
}
