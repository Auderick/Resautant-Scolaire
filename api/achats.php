<?php

require_once __DIR__ . '/../src/Models/achat.php';

header('Content-Type: application/json');

$achat = new Achat();

if (isset($_GET['id'])) {
    $data = $achat->getById($_GET['id']);
    echo json_encode($data);
}
