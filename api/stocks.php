<?php

require_once __DIR__ . '/../src/Models/stock.php';

header('Content-Type: application/json');

$stock = new Stock();

if (isset($_GET['id'])) {
    $data = $stock->getById($_GET['id']);
    // S'assurer que la date est au bon format pour le champ datetime-local
    if (isset($data['date_mouvement'])) {
        $data['date_mouvement'] = date('Y-m-d\TH:i', strtotime($data['date_mouvement']));
    } else {
        $data['date_mouvement'] = date('Y-m-d\TH:i');
    }
    echo json_encode($data);
}
