<?php
setlocale(LC_TIME, 'fr_FR.UTF-8', 'fra');
date_default_timezone_set('Europe/Paris');

require_once __DIR__ . '/../../includes/header.php';
require_once __DIR__ . '/../../includes/functions.php';
require_once __DIR__ . '/../../src/Models/stock.php';

$stock = new Stock();

// Gestion des paramètres de date
$mois = isset($_GET['mois']) ? intval($_GET['mois']) : intval(date('m'));
$annee = isset($_GET['annee']) ? intval($_GET['annee']) : intval(date('Y'));

// Calcul du mois précédent et suivant
$datePrecedente = new DateTime("$annee-$mois-01");
$datePrecedente->modify('-1 month');
$dateSuivante = new DateTime("$annee-$mois-01");
$dateSuivante->modify('+1 month');

// Récupération de l'historique
$historique = $stock->getHistoriqueMouvements($mois, $annee);
?>

<div class="container">
    <!-- Navigation des mois -->
    <div class="card mb-4">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
                <a href="?mois=<?= $datePrecedente->format('m') ?>&annee=<?= $datePrecedente->format('Y') ?>" 
                   class="btn btn-outline-primary">
                    <i class="bi bi-chevron-left"></i> Mois précédent
                </a>
                <h2 class="mb-0">
                    Historique :  <?= formatDateToFrench("$annee-$mois-01", 'MMMM y') ?>
                </h2>
                <a href="?mois=<?= $dateSuivante->format('m') ?>&annee=<?= $dateSuivante->format('Y') ?>" 
                   class="btn btn-outline-primary">
                    Mois suivant <i class="bi bi-chevron-right"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Tableau historique -->
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Produit</th>
                            <th>Type</th>
                            <th>Quantité avant</th>
                            <th>Quantité après</th>
                            <th>Différence</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($historique as $h): ?>
                        <tr>
                            <td><?= date('d/m/Y H:i', strtotime($h['date_mouvement'])) ?></td>
                            <td><?= htmlspecialchars($h['produit']) ?></td>
                            <td>
                                <span class="badge <?= $h['type_mouvement'] === 'entrée' ? 'bg-success' : 'bg-warning' ?>">
                                    <?= $h['type_mouvement'] ?>
                                </span>
                            </td>
                            <td><?= $h['quantite_avant'] ?> <?= $h['unite'] ?></td>
                            <td><?= $h['quantite_apres'] ?> <?= $h['unite'] ?></td>
                            <td><?= $h['quantite_apres'] - $h['quantite_avant'] ?> <?= $h['unite'] ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>