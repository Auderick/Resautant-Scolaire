<?php

require_once __DIR__ . '/../src/Models/vente.php';

header('Content-Type: application/json');

$vente = new Vente();

if (isset($_GET['id'])) {
    $data = $vente->getById($_GET['id']);
    echo json_encode($data);
}
