<?php
require_once __DIR__ . '/../../includes/header.php';
require_once __DIR__ . '/../../includes/functions.php';
require_once __DIR__ . '/../../src/Models/presence.php';
require_once __DIR__ . '/../../auth/auth_functions.php';

$presence = new Presence();
$categories = $presence->getCategories();
$categorieId = isset($_GET['categorie']) ? intval($_GET['categorie']) : 1;

// Traitement des actions
if ($_SERVER['REQUEST_METHOD'] === 'POST' && hasEditPermission()) {
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'ajouter':
                if ($presence->ajouterPersonne($_POST['nom'], $_POST['prenom'], $_POST['categorie_id'])) {
                    $successMessage = "Personne ajoutée avec succès";
                } else {
                    $errorMessage = "Erreur lors de l'ajout";
                }
                break;
            case 'modifier':
                if ($presence->modifierPersonne($_POST['id'], $_POST['nom'], $_POST['prenom'], $_POST['categorie_id'])) {
                    $successMessage = "Personne modifiée avec succès";
                } else {
                    $errorMessage = "Erreur lors de la modification";
                }
                break;
            case 'supprimer':
                if ($presence->supprimerPersonne($_POST['id'])) {
                    $successMessage = "Personne supprimée avec succès";
                } else {
                    $errorMessage = "Erreur lors de la suppression";
                }
                break;
        }
    }
}

$personnes = $presence->getPersonnesByCategorie($categorieId);
?>

<div class="container">
    <h1 class="text-center mb-4">Gestion des Personnes</h1>

    <!-- Navigation entre les catégories -->
    <div class="card mb-4">
        <div class="card-body">
            <div class="btn-group d-flex" role="group">
                <?php foreach ($categories as $cat): ?>
                <a href="?categorie=<?= $cat['id'] ?>"
                    class="btn <?= $cat['id'] == $categorieId ? 'btn-primary' : 'btn-outline-primary' ?>">
                    <?= htmlspecialchars($cat['nom']) ?>
                </a>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <?php if (isset($successMessage)): ?>
    <div class="alert alert-success"><?= $successMessage ?></div>
    <?php endif; ?>

    <?php if (isset($errorMessage)): ?>
    <div class="alert alert-danger"><?= $errorMessage ?></div>
    <?php endif; ?>

    <!-- Formulaire d'ajout -->
    <?php if (hasEditPermission()): ?>
    <div class="card mb-4">
        <div class="card-body">
            <h2 class="card-title">Ajouter une personne</h2>
            <form method="POST" class="row g-3">
                <input type="hidden" name="action" value="ajouter">
                <input type="hidden" name="categorie_id"
                    value="<?= $categorieId ?>">

                <div class="col-md-6">
                    <label for="nom" class="form-label">Nom</label>
                    <input type="text" class="form-control" id="nom" name="nom" required>
                </div>

                <div class="col-md-6">
                    <label for="prenom" class="form-label">Prénom</label>
                    <input type="text" class="form-control" id="prenom" name="prenom" required>
                </div>

                <div class="col-12">
                    <button type="submit" class="btn btn-primary">Ajouter</button>
                </div>
            </form>
        </div>
    </div>
    <?php endif; ?>

    <!-- Liste des personnes -->
    <div class="card">
        <div class="card-body">
            <h2 class="card-title">Liste des personnes</h2>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Nom</th>
                            <th>Prénom</th>
                            <?php if (hasEditPermission()): ?>
                            <th>Actions</th>
                            <?php endif; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($personnes as $personne): ?>
                        <tr>
                            <td><?= htmlspecialchars($personne['nom']) ?>
                            </td>
                            <td><?= htmlspecialchars($personne['prenom']) ?>
                            </td>
                            <?php if (hasEditPermission()): ?>
                            <td>
                                <button class="btn btn-sm btn-warning"
                                    onclick="modifierPersonne(<?= $personne['id'] ?>)">
                                    Modifier
                                </button>
                                <button class="btn btn-sm btn-danger"
                                    onclick="supprimerPersonne(<?= $personne['id'] ?>)">
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
<div class="modal fade" id="modalModifier" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Modifier la personne</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" id="formModifier">
                <div class="modal-body">
                    <input type="hidden" name="action" value="modifier">
                    <input type="hidden" name="id" id="modif_id">
                    <input type="hidden" name="categorie_id" id="modif_categorie_id"
                        value="<?= $categorieId ?>">

                    <div class="mb-3">
                        <label for="modif_nom" class="form-label">Nom</label>
                        <input type="text" class="form-control" id="modif_nom" name="nom" required>
                    </div>

                    <div class="mb-3">
                        <label for="modif_prenom" class="form-label">Prénom</label>
                        <input type="text" class="form-control" id="modif_prenom" name="prenom" required>
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

<script>
    function modifierPersonne(id) {
        // Récupérer les données de la personne dans le tableau
        const row = document.querySelector(`button[onclick="modifierPersonne(${id})"]`).closest('tr');
        const nom = row.cells[0].textContent;
        const prenom = row.cells[1].textContent;

        // Remplir le formulaire
        document.getElementById('modif_id').value = id;
        document.getElementById('modif_nom').value = nom;
        document.getElementById('modif_prenom').value = prenom;

        // Afficher le modal
        new bootstrap.Modal(document.getElementById('modalModifier')).show();
    }

    function supprimerPersonne(id) {
        if (confirm('Êtes-vous sûr de vouloir supprimer cette personne ?')) {
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