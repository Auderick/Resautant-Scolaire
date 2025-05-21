<?php
setlocale(LC_TIME, 'fr_FR.UTF-8', 'fra');
date_default_timezone_set('Europe/Paris');

require_once __DIR__ . '/../../includes/header.php';
require_once __DIR__ . '/../../includes/functions.php';
require_once __DIR__ . '/../../src/Models/presence.php';
require_once __DIR__ . '/../../auth/auth_functions.php';

// Ajout du CSS d'impression et de la grille
echo '<link rel="stylesheet" href="/compte_restaurant_scolaire/public/css/print.css">';
echo '<link rel="stylesheet" href="/compte_restaurant_scolaire/public/css/presence-grid.css">';
?>
<style>
    .jours-present,
    .jours-absent {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 5px;
        padding: 0;
        margin: 0;
        list-style: none;
    }

    .jours-present li,
    .jours-absent li {
        text-align: center;
        padding: 2px 5px;
        border: 1px solid #ddd;
        border-radius: 3px;
    }
</style>
<?php

$presence = new Presence();
$categories = $presence->getCategories();

// Gestion des paramètres
$mois = isset($_GET['mois']) ? intval($_GET['mois']) : intval(date('m'));
$annee = isset($_GET['annee']) ? intval($_GET['annee']) : intval(date('Y'));
$categorieId = isset($_GET['categorie']) ? intval($_GET['categorie']) : 1;

// Récupération du nom de la catégorie
$nomCategorie = '';
foreach ($categories as $cat) {
    if ($cat['id'] == $categorieId) {
        $nomCategorie = $cat['nom'];
        break;
    }
}

// Calcul des mois précédent et suivant
$datePrecedente = new DateTime("$annee-$mois-01");
$datePrecedente->modify('-1 month');
$dateSuivante = new DateTime("$annee-$mois-01");
$dateSuivante->modify('+1 month');

// Récupération des données
$recap = $presence->getRecapitulatifMensuel($mois, $annee, $categorieId);

// Nombre de jours dans le mois
$nombreJours = cal_days_in_month(CAL_GREGORIAN, $mois, $annee);
?>

<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Récapitulatif Mensuel des Présences</h1>
        <div class="d-flex gap-2"> <a href="index.php" class="btn btn-primary">
                <i class="bi bi-arrow-left"></i> Retour aux présences
            </a>
            <a href="imprimer_presence.php?type=recap&categorie=<?= $categorieId ?>&mois=<?= $mois ?>&annee=<?= $annee ?>"
                class="btn btn-secondary" target="_blank">
                <i class="bi bi-printer"></i> Imprimer
            </a>
            <a href="download_recap.php?categorie=<?= $categorieId ?>&mois=<?= $mois ?>&annee=<?= $annee ?>"
                class="btn btn-success">
                <i class="bi bi-file-pdf"></i> Télécharger PDF
            </a>
        </div>
    </div>

    <!-- Navigation des catégories -->
    <div class="card mb-4">
        <div class="card-body">
            <div class="btn-group d-flex" role="group">
                <?php foreach ($categories as $cat): ?>
                <a href="?categorie=<?= $cat['id'] ?>&mois=<?= $mois ?>&annee=<?= $annee ?>"
                    class="btn <?= $cat['id'] == $categorieId ? 'btn-primary' : 'btn-outline-primary' ?>">
                    <?= htmlspecialchars($cat['nom']) ?>
                </a>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <!-- Navigation des mois -->
    <div class="card mb-4">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
                <a href="?categorie=<?= $categorieId ?>&mois=<?= $datePrecedente->format('m') ?>&annee=<?= $datePrecedente->format('Y') ?>"
                    class="btn btn-outline-primary">
                    <i class="bi bi-chevron-left"></i> Mois précédent
                </a>
                <h3 class="mb-0">
                    <?= formatDateToFrench("$annee-$mois-01", 'MMMM Y') ?>
                </h3>
                <a href="?categorie=<?= $categorieId ?>&mois=<?= $dateSuivante->format('m') ?>&annee=<?= $dateSuivante->format('Y') ?>"
                    class="btn btn-outline-primary">
                    Mois suivant <i class="bi bi-chevron-right"></i>
                </a>
            </div>
        </div>
    </div> <!-- Tableau récapitulatif -->
    <div class="card">
        <div class="card-body">
            <!-- En-tête pour l'impression -->
            <div class="print-header">
                <div class="print-title">Récapitulatif des Présences -
                    <?= htmlspecialchars($nomCategorie) ?>
                </div>
                <div class="print-subtitle">
                    <?= formatDateToFrench("$annee-$mois-01", 'MMMM Y') ?>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th class="col-nom">Nom</th>
                            <th class="col-prenom">Prénom</th>
                            <th class="col-jours">Jours présent</th>
                            <th class="col-jours">Jours absent</th>
                            <th>Total présences</th>
                            <th>Total absences</th>
                        </tr>
                    </thead>
                    <tbody> <?php foreach ($recap as $personne): ?>
                        <?php
                            $joursPresent = $personne['jours_present'] ? explode(',', $personne['jours_present']) : [];
                        $joursAbsent = $personne['jours_absent'] ? explode(',', $personne['jours_absent']) : [];
                        sort($joursPresent, SORT_NUMERIC);
                        sort($joursAbsent, SORT_NUMERIC);
                        ?>
                        <tr>
                            <td class="col-nom">
                                <?= htmlspecialchars($personne['nom']) ?>
                            </td>
                            <td class="col-prenom">
                                <?= htmlspecialchars($personne['prenom']) ?>
                            </td>
                            <td class="col-jours">
                                <?php if (!empty($joursPresent)): ?>
                                <ul class="jours-present">
                                    <?php foreach ($joursPresent as $jour): ?>
                                    <li><?= $jour ?></li>
                                    <?php endforeach; ?>
                                </ul>
                                <?php else: ?>
                                -
                                <?php endif; ?>
                            </td>
                            <td class="col-jours">
                                <?php if (!empty($joursAbsent)): ?>
                                <ul class="jours-absent">
                                    <?php foreach ($joursAbsent as $jour): ?>
                                    <li><?= $jour ?></li>
                                    <?php endforeach; ?>
                                </ul>
                                <?php else: ?>
                                -
                                <?php endif; ?>
                            </td>
                            <td class="col-total">
                                <?= $personne['total_presences'] ?>
                            </td>
                            <td class="col-total">
                                <?= $personne['total_absences'] ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>