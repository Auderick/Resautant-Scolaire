<?php

setlocale(LC_TIME, 'fr_FR.UTF-8', 'fra');
date_default_timezone_set('Europe/Paris');

require_once __DIR__ . '/../../includes/header.php';
require_once __DIR__ . '/../../includes/functions.php';
require_once __DIR__ . '/../../src/Models/achat.php';
require_once __DIR__ . '/../../auth/auth_functions.php';

$achat = new Achat();

// Gestion des paramètres de date
$mois = isset($_GET['mois']) ? intval($_GET['mois']) : intval(date('m'));
$annee = isset($_GET['annee']) ? intval($_GET['annee']) : intval(date('Y'));

// Calcul du mois précédent et suivant
$datePrecedente = new DateTime("$annee-$mois-01");
$datePrecedente->modify('-1 month');
$dateSuivante = new DateTime("$annee-$mois-01");
$dateSuivante->modify('+1 month');

// Traitement des actions
if ($_SERVER['REQUEST_METHOD'] === 'POST' && hasEditPermission()) {
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'ajouter':
                $dateAchat = !empty($_POST['date_achat']) ? $_POST['date_achat'] : null;
                $achat->ajouter(
                    $_POST['fournisseur'],
                    $_POST['description'],
                    $_POST['montant'],
                    $dateAchat
                );
                break;
            case 'modifier':
                $dateAchat = !empty($_POST['date_achat']) ? $_POST['date_achat'] : null;
                $achat->modifier(
                    $_POST['id'],
                    $_POST['fournisseur'],
                    $_POST['description'],
                    $_POST['montant'],
                    $dateAchat
                );
                break;
            case 'supprimer':
                $achat->supprimer($_POST['id']);
                break;
        }
    }
}

$achats = $achat->getListe($mois, $annee);
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
                    <?= formatDateToFrench("$annee-$mois-01", 'MMMM y') ?>
                </h2>
                <a href="?mois=<?= $dateSuivante->format('m') ?>&annee=<?= $dateSuivante->format('Y') ?>"
                    class="btn btn-outline-primary">
                    Mois suivant <i class="bi bi-chevron-right"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Formulaire d'ajout -->
    <?php if (hasEditPermission()): ?>
    <div class="card mb-4">
        <div class="card-body">
            <h2 class="card-title">Nouvel achat</h2>
            <form method="POST" class="row g-3">
                <input type="hidden" name="action" value="ajouter">
                <div class="col-md-6">
                    <label for="fournisseur" class="form-label">Fournisseur</label>
                    <input type="text" class="form-control" id="fournisseur" name="fournisseur" required>
                </div>
                <div class="col-md-6">
                    <label for="description" class="form-label">Description</label>
                    <input type="text" class="form-control" id="description" name="description" required>
                </div>
                <div class="col-md-6">
                    <label for="montant" class="form-label">Montant</label>
                    <input type="number" step="0.01" class="form-control" id="montant" name="montant" required>
                </div>
                <div class="col-md-6">
                    <label for="date_achat" class="form-label">Date d'achat</label>
                    <input type="datetime-local" class="form-control" id="date_achat" name="date_achat">
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-primary">Ajouter</button>
                </div>
            </form>
        </div>
    </div>
    <?php endif; ?>
    <!-- Liste des achats -->
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h2 class="card-title mb-0">Liste des achats</h2>
                <button class="btn btn-primary" onclick="imprimerAchats()">
                    <i class="bi bi-printer"></i> Imprimer
                </button>
            </div>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Fournisseur</th>
                            <th>Description</th>
                            <th>Montant</th>
                            <?php if (hasEditPermission()): ?>
                            <th>Actions</th>
                            <?php endif; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($achats as $a): ?>
                        <tr>
                            <td><?= date('d/m/Y H:i', strtotime($a['date_achat'])) ?>
                            </td>
                            <td><?= htmlspecialchars($a['fournisseur']) ?>
                            </td>
                            <td><?= htmlspecialchars($a['description']) ?>
                            </td>
                            <td><?= number_format($a['montant'], 2) ?>
                                €</td>
                            <?php if (hasEditPermission()): ?>
                            <td>
                                <button class="btn btn-sm btn-warning"
                                    onclick="modifierAchat(<?= $a['id'] ?>)">
                                    <i class="bi bi-pencil"></i>
                                </button>
                                <button class="btn btn-sm btn-danger"
                                    onclick="supprimerAchat(<?= $a['id'] ?>)">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </td>
                            <?php endif; ?>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal de modification -->
    <?php if (hasEditPermission()): ?>
    <div class="modal fade" id="modalModifier" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Modifier l'achat</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form method="POST" id="formModifier">
                    <div class="modal-body">
                        <input type="hidden" name="action" value="modifier">
                        <input type="hidden" name="id" id="modif_id">
                        <div class="mb-3">
                            <label for="modif_fournisseur" class="form-label">Fournisseur</label>
                            <input type="text" class="form-control" id="modif_fournisseur" name="fournisseur" required>
                        </div>
                        <div class="mb-3">
                            <label for="modif_description" class="form-label">Description</label>
                            <input type="text" class="form-control" id="modif_description" name="description" required>
                        </div>
                        <div class="mb-3">
                            <label for="modif_montant" class="form-label">Montant</label>
                            <input type="number" step="0.01" class="form-control" id="modif_montant" name="montant"
                                required>
                        </div>
                        <div class="mb-3">
                            <label for="modif_date_achat" class="form-label">Date d'achat</label>
                            <input type="datetime-local" class="form-control" id="modif_date_achat" name="date_achat">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-primary">Enregistrer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php endif; ?>

     <!-- Définir la variable de permission -->
    <script>
        window.hasEditPermission = <?= hasEditPermission() ? 'true' : 'false' ?>;
    </script>

    <?php require_once __DIR__ . '/../../includes/footer.php'; ?>