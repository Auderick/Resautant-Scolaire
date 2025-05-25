<?php
setlocale(LC_TIME, 'fr_FR.UTF-8', 'fra');
date_default_timezone_set('Europe/Paris');

require_once __DIR__ . '/../../includes/header.php';
require_once __DIR__ . '/../../includes/functions.php';
require_once __DIR__ . '/../../src/Models/presence.php';
require_once __DIR__ . '/../../auth/auth_functions.php';

// Ajout du CSS d'impression
echo '<link rel="stylesheet" href="/public/css/print.css" media="print">';

// Ajout du JavaScript des présences
echo '<script src="/public/js/presences.js" defer></script>';

$presence = new Presence();
$categories = $presence->getCategories();

// Gestion de la date
$date = isset($_GET['date']) ? $_GET['date'] : date('Y-m-d');
$categorieId = isset($_GET['categorie']) ? intval($_GET['categorie']) : 1;

// Traitement du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST' && hasEditPermission()) {
    $presences = isset($_POST['presences']) ? $_POST['presences'] : [];
    $absences = isset($_POST['absences']) ? $_POST['absences'] : [];
    if ($presence->enregistrerPresences($_POST['date'], $presences, $absences, $categorieId)) {
        $successMessage = "Présences enregistrées avec succès";
    } else {
        $errorMessage = "Erreur lors de l'enregistrement des présences";
    }
}

// Récupération des données
$personnes = $presence->getPersonnesByCategorie($categorieId);
$presencesJour = $presence->getPresences($date, $categorieId);
$presencesMap = array_column($presencesJour, 'present', 'personne_id');
$absencesMap = array_column($presencesJour, 'absent', 'personne_id');
?>

<div class="container"> <!-- En-tête avec les boutons d'action -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Gestion des Présences</h1>
        <div class="d-flex gap-2">
            <a href="recap.php" class="btn btn-info">
                <i class="bi bi-calendar-check"></i> Récapitulatif mensuel
            </a>
            <?php if (hasEditPermission()): ?>
            <a href="personnes.php" class="btn btn-primary">
                <i class="bi bi-people"></i> Gérer les personnes
            </a>
            <?php endif; ?>
        </div>
    </div>

    <!-- Navigation entre les catégories -->
    <div class="card mb-4">
        <div class="card-body">
            <div class="btn-group d-flex" role="group">
                <?php foreach ($categories as $cat): ?>
                <a href="?categorie=<?= $cat['id'] ?>&date=<?= $date ?>"
                    class="btn <?= $cat['id'] == $categorieId ? 'btn-primary' : 'btn-outline-primary' ?>">
                    <?= htmlspecialchars($cat['nom']) ?>
                </a>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <!-- Sélection de la date -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" class="row align-items-end">
                <input type="hidden" name="categorie"
                    value="<?= $categorieId ?>">
                <div class="col-md-4">
                    <label for="date" class="form-label">Date</label>
                    <input type="date" class="form-control" id="date" name="date"
                        value="<?= $date ?>"
                        onchange="this.form.submit()">
                </div>
                <div class="col-md-8">
                    <div class="d-flex gap-2">
                        <a href="?categorie=<?= $categorieId ?>&date=<?= date('Y-m-d', strtotime('-1 day', strtotime($date))) ?>"
                            class="btn btn-outline-primary">
                            <i class="bi bi-chevron-left"></i> Jour précédent
                        </a>
                        <a href="?categorie=<?= $categorieId ?>&date=<?= date('Y-m-d') ?>"
                            class="btn btn-outline-primary">
                            Aujourd'hui
                        </a>
                        <a href="?categorie=<?= $categorieId ?>&date=<?= date('Y-m-d', strtotime('+1 day', strtotime($date))) ?>"
                            class="btn btn-outline-primary">
                            Jour suivant <i class="bi bi-chevron-right"></i>
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <?php if (isset($successMessage)): ?>
    <div class="alert alert-success"><?= $successMessage ?></div>
    <?php endif; ?>

    <?php if (isset($errorMessage)): ?>
    <div class="alert alert-danger"><?= $errorMessage ?></div>
    <?php endif; ?>

    <!-- Liste des présences -->
    <div class="card">
        <div class="card-body">
            <form method="POST">
                <input type="hidden" name="date"
                    value="<?= $date ?>">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Nom</th>
                                <th>Prénom</th>
                                <th class="text-center">Présent(e)</th>
                                <th class="text-center">Absent(e)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($personnes as $personne): ?>
                            <tr>
                                <td><?= htmlspecialchars($personne['nom']) ?>
                                </td>
                                <td><?= htmlspecialchars($personne['prenom']) ?>
                                </td>
                                <td class="text-center">
                                    <div class="form-check d-flex justify-content-center">
                                        <input type="checkbox" class="form-check-input presence-checkbox"
                                            name="presences[<?= $personne['id'] ?>]"
                                            value="1"
                                            <?= isset($presencesMap[$personne['id']]) && $presencesMap[$personne['id']] ? 'checked' : '' ?>
                                        onchange="updateAbsenceCheckbox(this)">
                                    </div>
                                </td>
                                <td class="text-center">
                                    <div class="form-check d-flex justify-content-center">
                                        <input type="checkbox" class="form-check-input absence-checkbox"
                                            name="absences[<?= $personne['id'] ?>]"
                                            value="1"
                                            <?= isset($absencesMap[$personne['id']]) && $absencesMap[$personne['id']] ? 'checked' : '' ?>
                                        onchange="updatePresenceCheckbox(this)">
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <?php if (hasEditPermission()): ?>
                <div class="d-flex justify-content-between mt-3">
                    <button type="submit" class="btn btn-primary">
                        Enregistrer les présences
                    </button> <a
                        href="imprimer_presence.php?type=jour&categorie=<?= $categorieId ?>&date=<?= $date ?>"
                        class="btn btn-secondary" target="_blank">
                        <i class="bi bi-printer"></i> Imprimer
                    </a>
                </div>
                <?php endif; ?>
            </form>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>