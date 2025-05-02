<?php

setlocale(LC_TIME, 'fr_FR.UTF-8', 'fra');
date_default_timezone_set('Europe/Paris');

require_once __DIR__ . '/../../includes/header.php';
require_once __DIR__ . '/../../includes/functions.php';
require_once __DIR__ . '/../../src/Models/vente.php';
require_once __DIR__ . '/../../auth/auth_functions.php';

$vente = new Vente();

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
                $dateVente = !empty($_POST['date_vente']) ? $_POST['date_vente'] : null;
                $vente->ajouter($_POST['nb_repas'], $_POST['prix_unitaire'], $dateVente);
                break;
            case 'modifier':
                $dateVente = !empty($_POST['date_vente']) ? $_POST['date_vente'] : null;
                $vente->modifier($_POST['id'], $_POST['nb_repas'], $_POST['prix_unitaire'], $dateVente);
                break;
            case 'supprimer':
                $vente->supprimer($_POST['id']);
                break;
        }
    }
}


// Récupération des ventes
$ventes = $vente->getListe($mois, $annee);
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
    <h1 class="text-center mb-4">Gestion des Ventes</h1>

    <!-- Formulaire d'ajout -->
    <?php if (hasEditPermission()): ?>
    <div class="card mb-4">
        <div class="card-body">
            <h2 class="card-title">Nouvelle vente</h2>
            <form method="POST" class="row g-3">
                <input type="hidden" name="action" value="ajouter">
                <div class="col-md-6">
                    <label for="nb_repas" class="form-label">Nombre de repas</label>
                    <input type="number" class="form-control" id="nb_repas" name="nb_repas" required>
                </div>
                <div class="col-md-6">
                    <label for="prix_unitaire" class="form-label">Prix unitaire</label>
                    <input type="number" step="0.01" class="form-control" id="prix_unitaire" name="prix_unitaire"
                        required>
                </div>
                <div class="col-md-6">
                    <label for="date_vente" class="form-label">Date de vente</label>
                    <input type="datetime-local" class="form-control" id="date_vente" name="date_vente">
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-primary">Ajouter</button>
                </div>
            </form>
        </div>
    </div>
    <?php endif; ?>

    <!-- Liste des ventes -->
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h2 class="card-title mb-0">Liste des ventes</h2>
                <button class="btn btn-primary" onclick="imprimerVentes()">
                    <i class="bi bi-printer"></i> Imprimer
                </button>
            </div>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Nombre de repas</th>
                            <th>Prix unitaire</th>
                            <th>Total</th>
                            <?php if (hasEditPermission()): ?>
                            <th>Actions</th>
                            <?php endif; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($ventes as $v): ?>
                        <tr>
                            <td><?= date('d/m/Y H:i', strtotime($v['date_vente'])) ?>
                            </td>
                            <td><?= htmlspecialchars($v['nb_repas']) ?>
                            </td>
                            <td><?= number_format($v['prix_unitaire'], 2) ?>
                                €</td>
                            <td><?= number_format($v['nb_repas'] * $v['prix_unitaire'], 2) ?>
                                €</td>
                                <?php if (hasEditPermission()): ?>
                            <td>
                                <button class="btn btn-sm btn-warning"
                                    onclick="modifierVente(<?= $v['id'] ?>)">
                                    Modifier
                                </button>
                                <button class="btn btn-sm btn-danger"
                                    onclick="supprimerVente(<?= $v['id'] ?>)">
                                    Supprimer
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
</div>

<!-- Modal de modification -->
<?php if (hasEditPermission()): ?>
<div class="modal fade" id="modalModifier" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Modifier la vente</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" id="formModifier">
                <div class="modal-body">
                    <input type="hidden" name="action" value="modifier">
                    <input type="hidden" name="id" id="modif_id">
                    <div class="mb-3">
                        <label for="modif_nb_repas" class="form-label">Nombre de repas</label>
                        <input type="number" class="form-control" id="modif_nb_repas" name="nb_repas" required>
                    </div>
                    <div class="mb-3">
                        <label for="modif_prix_unitaire" class="form-label">Prix unitaire</label>
                        <input type="number" step="0.01" class="form-control" id="modif_prix_unitaire"
                            name="prix_unitaire" required>
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
<script>
    function modifierVente(id) {
        // Récupérer les données de la vente via AJAX
        fetch(`/compte_restaurant_scolaire/api/ventes.php?id=${id}`)
            .then(response => response.json())
            .then(data => {
                document.getElementById('modif_id').value = data.id;
                document.getElementById('modif_nb_repas').value = data.nb_repas;
                document.getElementById('modif_prix_unitaire').value = data.prix_unitaire;
                new bootstrap.Modal(document.getElementById('modalModifier')).show();
            });
    }

    function supprimerVente(id) {
        if (confirm('Êtes-vous sûr de vouloir supprimer cette vente ?')) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.innerHTML = `
            <input type="hidden" name="action" value="supprimer">
            <input type="hidden" name="id" value="${id}">
        `;
            document.body.appendChild(form);
            form.submit();
        }
    }
</script>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>