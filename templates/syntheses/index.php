<?php

setlocale(LC_TIME, 'fr_FR.UTF-8', 'fra');
date_default_timezone_set('Europe/Paris');

require_once __DIR__ . '/../../config/db.php';
require_once __DIR__ . '/../../includes/functions.php';
require_once __DIR__ . '/../../includes/header.php';
require_once __DIR__ . '/../../src/Models/synthese.php';

$mois = isset($_GET['mois']) ? $_GET['mois'] : date('m');
$annee = isset($_GET['annee']) ? $_GET['annee'] : date('Y');

$synthese = new Synthese($db);
$donnees_mois = $synthese->getSyntheseMensuelle($mois, $annee);
$donnees_annee = $synthese->getSyntheseAnnuelle($annee);

?>

<div class="container">
    <h1 class="mb-4">Synthèse</h1>

    <!-- Navigation entre les mois -->
    <div class="mb-4">
        <div class="d-flex justify-content-between align-items-center">
            <?php
            $moisPrecedent = $mois == 1 ? 12 : $mois - 1;
            $anneePrecedente = $mois == 1 ? $annee - 1 : $annee;

            $moisSuivant = $mois == 12 ? 1 : $mois + 1;
            $anneeSuivante = $mois == 12 ? $annee + 1 : $annee;
            ?>

            <a href="?mois=<?= $moisPrecedent ?>&annee=<?= $anneePrecedente ?>"
                class="btn btn-outline-primary">
                <i class="bi bi-chevron-left"></i> Mois précédent
            </a>

            <h2><?= formatDateToFrench("$annee-$mois-01", 'MMMM y') ?>
            </h2>

            <a href="?mois=<?= $moisSuivant ?>&annee=<?= $anneeSuivante ?>"
                class="btn btn-outline-primary">
                Mois suivant <i class="bi bi-chevron-right"></i>
            </a>
        </div>
    </div>

    <!-- Synthèse Mensuelle -->
    <div class="card mb-4">
        <div class="card-header">
            <h2><?= formatDateToFrench("$annee-$mois-01", 'MMMM y') ?>
            </h2>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <div class="card border-primary">
                        <div class="card-body">
                            <h5 class="card-title">Total Ventes</h5>
                            <p class="card-text">
                                <?= formatMontant($donnees_mois['total_ventes']) ?>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border-danger">
                        <div class="card-body">
                            <h5 class="card-title">Total Achats</h5>
                            <p class="card-text">
                                <?= formatMontant($donnees_mois['total_achats']) ?>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border-success">
                        <div class="card-body">
                            <h5 class="card-title">Valeur Stock</h5>
                            <p class="card-text">
                                <?= formatMontant($donnees_mois['valeur_stock_mensuelle']) ?>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-md-4">
                    <div class="card border-info">
                        <div class="card-body">
                            <h5 class="card-title">Nombre de Couverts</h5>
                            <p class="card-text">
                                <?= formatNombre($donnees_mois['nombre_couverts']) ?>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border-warning">
                        <div class="card-body">
                            <h5 class="card-title">Coût par Couvert</h5>
                            <p class="card-text">
                                <?= formatMontant($donnees_mois['cout_par_couvert']) ?>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border-dark">
                        <div class="card-body">
                            <h5 class="card-title">Résultat Total</h5>
                            <p class="card-text">
                                <?= formatMontant($donnees_mois['resultat_total']) ?>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Synthèse Annuelle -->
    <div class="card">
        <div class="card-header">
            <h2>Synthèse Annuelle <?= $annee ?></h2>
        </div>
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th>Mois</th>
                        <th>Ventes</th>
                        <th>Achats</th>
                        <th>Valeur Stock</th>
                        <th>Nombre Couverts</th>
                        <th>Coût/Couvert</th>
                        <th>Résultat</th>
                        <th>Résultat Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($donnees_annee as $ligne): ?>
                    <tr <?= $ligne['mois'] === 'Total' ? 'class="table-primary font-weight-bold"' : '' ?>>
                        <td><?= $ligne['mois'] === 'Total' ? 'Total Année' : formatDateToFrench("2024-{$ligne['mois']}-01", 'MMMM') ?>
                        </td>
                        <td><?= formatMontant($ligne['total_ventes']) ?>
                        </td>
                        <td><?= formatMontant($ligne['total_achats']) ?>
                        </td>
                        <td><?= formatMontant($ligne['valeur_stock']) ?>
                        </td>
                        <td><?= formatNombre($ligne['nombre_couverts']) ?>
                        </td>
                        <td><?= formatMontant($ligne['cout_par_couvert']) ?>
                        </td>
                        <td><?= formatMontant($ligne['resultat']) ?>
                        </td>
                        <td><?= formatMontant($ligne['resultat_total']) ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>