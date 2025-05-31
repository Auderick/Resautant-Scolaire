<?php

require_once __DIR__ . '/../../includes/header.php';
require_once __DIR__ . '/../../src/Models/commande.php';

// Initialiser le modèle
$commandeModel = new Commande();

// Traitement du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Gérer la suppression
    if (isset($_POST['action']) && $_POST['action'] == 'supprimer' && isset($_POST['id'])) {
        try {
            $commandeModel->supprimerCommande($_POST['id']);
            $message = "La commande a été supprimée avec succès.";
        } catch (Exception $e) {
            $erreur = "Erreur lors de la suppression de la commande: " . $e->getMessage();
        }
    }
}

// Récupérer le mois et l'année en cours ou spécifiés par l'utilisateur
$mois = isset($_GET['mois']) ? intval($_GET['mois']) : intval(date('m'));
$annee = isset($_GET['annee']) ? intval($_GET['annee']) : intval(date('Y'));

// Récupérer la liste des commandes
$commandes = $commandeModel->getListeCommandes($mois, $annee);

// Noms des mois en français
$nomsMois = [
    1 => 'Janvier', 2 => 'Février', 3 => 'Mars', 4 => 'Avril',
    5 => 'Mai', 6 => 'Juin', 7 => 'Juillet', 8 => 'Août',
    9 => 'Septembre', 10 => 'Octobre', 11 => 'Novembre', 12 => 'Décembre'
];
?>

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Gestion des Commandes Fournisseurs</h1>
        <a href="nouvelle.php" class="btn btn-primary">Nouvelle Commande</a>
    </div>
    
    <?php if (isset($message)): ?>
        <div class="alert alert-success"><?= htmlspecialchars($message) ?></div>
    <?php endif; ?>
    
    <?php if (isset($erreur)): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($erreur) ?></div>
    <?php endif; ?>
    
    <!-- Sélecteur de mois/année -->
    <div class="mb-4">
        <form method="get" class="row g-3">
            <div class="col-auto">
                <select name="mois" class="form-select">
                    <?php foreach ($nomsMois as $num => $nom): ?>
                        <option value="<?= $num ?>" <?= $mois == $num ? 'selected' : '' ?>><?= $nom ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-auto">
                <select name="annee" class="form-select">
                    <?php for ($an = date('Y'); $an >= date('Y') - 5; $an--): ?>
                        <option value="<?= $an ?>" <?= $annee == $an ? 'selected' : '' ?>><?= $an ?></option>
                    <?php endfor; ?>
                </select>
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-secondary">Filtrer</button>
            </div>
        </form>
    </div>
    
    <!-- Tableau des commandes -->
    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead class="table-light">
                <tr>
                    <th>Date</th>
                    <th>Fournisseur</th>
                    <th>Livraison souhaitée</th>
                    <th>Statut</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($commandes)): ?>
                    <tr>
                        <td colspan="5" class="text-center">Aucune commande pour cette période</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($commandes as $commande): ?>
                        <tr>
                            <td><?= date('d/m/Y', strtotime($commande['date_commande'])) ?></td>
                            <td><?= htmlspecialchars($commande['fournisseur']) ?></td>
                            <td><?= $commande['date_livraison_souhaitee'] ? date('d/m/Y', strtotime($commande['date_livraison_souhaitee'])) : '-' ?></td>
                            <td>
                                <span class="badge bg-<?= $commande['statut'] == 'envoyee' ? 'success' :
                                    ($commande['statut'] == 'brouillon' ? 'warning' :
                                    ($commande['statut'] == 'recue' ? 'info' : 'danger')) ?>">
                                    <?= ucfirst(htmlspecialchars($commande['statut'])) ?>
                                </span>
                            </td>
                            <td>
                                <div class="btn-group">
                                    <a href="voir.php?id=<?= $commande['id'] ?>" class="btn btn-sm btn-primary">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="modifier.php?id=<?= $commande['id'] ?>" class="btn btn-sm btn-warning">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <button type="button" class="btn btn-sm btn-danger"
                                            onclick="confirmerSuppression(<?= $commande['id'] ?>)">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Formulaire de suppression -->
<form id="formSuppression" method="post" style="display:none;">
    <input type="hidden" name="action" value="supprimer">
    <input type="hidden" name="id" id="idSuppression">
</form>

<script>
function confirmerSuppression(id) {
    if (confirm('Êtes-vous sûr de vouloir supprimer cette commande ?')) {
        document.getElementById('idSuppression').value = id;
        document.getElementById('formSuppression').submit();
    }
}
</script>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>