<?php

require_once __DIR__ . '/../../includes/header.php';
require_once __DIR__ . '/../../src/Models/commande.php';

// Initialiser le modèle
$commandeModel = new Commande();

// Vérifier si l'ID est fourni
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header('Location: index.php');
    exit;
}

$commandeId = intval($_GET['id']);

// Traitement du formulaire de mise à jour
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Mettre à jour les informations générales
        $fournisseur = $_POST['fournisseur'];
        $dateLivraison = !empty($_POST['date_livraison']) ? $_POST['date_livraison'] : null;
        $notes = !empty($_POST['notes']) ? $_POST['notes'] : null;
        $statut = $_POST['statut'];

        // Mettre à jour la commande
        $sql = "UPDATE commandes SET fournisseur = ?, date_livraison_souhaitee = ?, notes = ?, statut = ? WHERE id = ?";
        $stmt = $commandeModel->db->prepare($sql);
        $stmt->execute([$fournisseur, $dateLivraison, $notes, $statut, $commandeId]);

        // Supprimer toutes les lignes existantes
        $sql = "DELETE FROM lignes_commande WHERE commande_id = ?";
        $stmt = $commandeModel->db->prepare($sql);
        $stmt->execute([$commandeId]);

        // Ajouter les nouvelles lignes
        if (isset($_POST['produits']) && is_array($_POST['produits'])) {
            foreach ($_POST['produits'] as $index => $produit) {
                if (empty($produit)) {
                    continue;
                }

                $quantite = isset($_POST['quantites'][$index]) ? $_POST['quantites'][$index] : 0;
                $unite = isset($_POST['unites'][$index]) ? $_POST['unites'][$index] : null;
                $prixUnitaire = isset($_POST['prix_unitaires'][$index]) && !empty($_POST['prix_unitaires'][$index])
                              ? $_POST['prix_unitaires'][$index] : null;

                $commandeModel->ajouterLigneCommande($commandeId, $produit, $quantite, $unite, $prixUnitaire);
            }
        }

        header("Location: voir.php?id=$commandeId&updated=1");
        exit;
    } catch (Exception $e) {
        $erreur = "Erreur lors de la modification de la commande: " . $e->getMessage();
    }
}

// Récupérer les détails de la commande
try {
    $commande = $commandeModel->getCommande($commandeId);
    if (!$commande) {
        header('Location: index.php');
        exit;
    }

    $lignesCommande = $commandeModel->getLignesCommande($commandeId);
} catch (Exception $e) {
    $erreur = "Erreur lors de la récupération des données: " . $e->getMessage();
    $commande = null;
    $lignesCommande = [];
}

// Récupérer la liste des fournisseurs pour l'auto-complétion
$fournisseurs = $commandeModel->getFournisseurs();
?>

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Modifier la Commande #<?= $commandeId ?></h1>
        <a href="voir.php?id=<?= $commandeId ?>" class="btn btn-secondary">Retour à la commande</a>
    </div>
    
    <?php if (isset($erreur)): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($erreur) ?></div>
    <?php endif; ?>
    
    <form method="post" class="mb-5">
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">Informations générales</h5>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <label for="fournisseur" class="col-md-3 col-form-label">Fournisseur <span class="text-danger">*</span></label>
                    <div class="col-md-9">
                        <input type="text" class="form-control" id="fournisseur" name="fournisseur" 
                               value="<?= htmlspecialchars($commande['fournisseur']) ?>" required
                               list="liste-fournisseurs">
                        <datalist id="liste-fournisseurs">
                            <?php foreach ($fournisseurs as $fournisseur): ?>
                                <option value="<?= htmlspecialchars($fournisseur) ?>">
                            <?php endforeach; ?>
                        </datalist>
                    </div>
                </div>
                
                <div class="row mb-3">
                    <label for="date_livraison" class="col-md-3 col-form-label">Date de livraison souhaitée</label>
                    <div class="col-md-9">
                        <input type="date" class="form-control" id="date_livraison" name="date_livraison"
                               value="<?= $commande['date_livraison_souhaitee'] ? date('Y-m-d', strtotime($commande['date_livraison_souhaitee'])) : '' ?>">
                    </div>
                </div>
                
                <div class="row mb-3">
                    <label for="statut" class="col-md-3 col-form-label">Statut <span class="text-danger">*</span></label>
                    <div class="col-md-9">
                        <select name="statut" id="statut" class="form-select" required>
                            <option value="brouillon" <?= $commande['statut'] === 'brouillon' ? 'selected' : '' ?>>Brouillon</option>
                            <option value="envoyee" <?= $commande['statut'] === 'envoyee' ? 'selected' : '' ?>>Envoyée</option>
                            <option value="recue" <?= $commande['statut'] === 'recue' ? 'selected' : '' ?>>Reçue</option>
                            <option value="annulee" <?= $commande['statut'] === 'annulee' ? 'selected' : '' ?>>Annulée</option>
                        </select>
                    </div>
                </div>
                
                <div class="row mb-3">
                    <label for="notes" class="col-md-3 col-form-label">Notes</label>
                    <div class="col-md-9">
                        <textarea class="form-control" id="notes" name="notes" rows="3"
                                  placeholder="Instructions spéciales, conditions de livraison..."><?= htmlspecialchars($commande['notes'] ?? '') ?></textarea>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">Produits commandés</h5>
            </div>
            <div class="card-body">
                <div id="produits-container">
                    <?php if (empty($lignesCommande)): ?>
                        <div class="row mb-2 produit-row">
                            <div class="col-md-5">
                                <input type="text" class="form-control" name="produits[]" 
                                       placeholder="Nom du produit" required>
                            </div>
                            <div class="col-md-2">
                                <input type="number" class="form-control" name="quantites[]" 
                                       placeholder="Quantité" step="0.01" min="0" required>
                            </div>
                            <div class="col-md-2">
                                <input type="text" class="form-control" name="unites[]" 
                                       placeholder="Unité (kg, L...)" list="liste-unites">
                            </div>
                            <div class="col-md-2">
                                <input type="number" class="form-control" name="prix_unitaires[]" 
                                       placeholder="Prix unitaire" step="0.01" min="0">
                            </div>
                            <div class="col-md-1">
                                <button type="button" class="btn btn-danger btn-remove-row">
                                    <i class="bi bi-dash-circle"></i>
                                </button>
                            </div>
                        </div>
                    <?php else: ?>
                        <?php foreach ($lignesCommande as $ligne): ?>
                            <div class="row mb-2 produit-row">
                                <div class="col-md-5">
                                    <input type="text" class="form-control" name="produits[]" 
                                           value="<?= htmlspecialchars($ligne['produit']) ?>"
                                           placeholder="Nom du produit" required>
                                </div>
                                <div class="col-md-2">
                                    <input type="number" class="form-control" name="quantites[]" 
                                           value="<?= $ligne['quantite'] ?>"
                                           placeholder="Quantité" step="0.01" min="0" required>
                                </div>
                                <div class="col-md-2">
                                    <input type="text" class="form-control" name="unites[]" 
                                           value="<?= htmlspecialchars($ligne['unite'] ?? '') ?>"
                                           placeholder="Unité (kg, L...)" list="liste-unites">
                                </div>
                                <div class="col-md-2">
                                    <input type="number" class="form-control" name="prix_unitaires[]" 
                                           value="<?= $ligne['prix_unitaire'] ?? '' ?>"
                                           placeholder="Prix unitaire" step="0.01" min="0">
                                </div>
                                <div class="col-md-1">
                                    <button type="button" class="btn btn-danger btn-remove-row">
                                        <i class="bi bi-dash-circle"></i>
                                    </button>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
                
                <button type="button" class="btn btn-success mt-2" id="btnAjouterProduit">
                    <i class="bi bi-plus-circle"></i> Ajouter un produit
                </button>
            </div>
        </div>
        
        <div class="text-center mt-4">
            <a href="voir.php?id=<?= $commandeId ?>" class="btn btn-secondary btn-lg me-2">Annuler</a>
            <button type="submit" class="btn btn-primary btn-lg">Enregistrer les modifications</button>
        </div>
    </form>
    
    <!-- Datalist pour les unités -->
    <datalist id="liste-unites">
        <option value="kg">
        <option value="L">
        <option value="unité">
        <option value="pièce">
        <option value="carton">
        <option value="boîte">
        <option value="barquette">
        <option value="sachet">
        <option value="bouteille">
        <option value="pot">
    </datalist>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Ajouter une nouvelle ligne produit
    document.getElementById('btnAjouterProduit').addEventListener('click', function() {
        const container = document.getElementById('produits-container');
        const rows = container.querySelectorAll('.produit-row');
        const newRow = rows[0].cloneNode(true);
        
        // Réinitialiser les valeurs
        newRow.querySelectorAll('input').forEach(input => {
            input.value = '';
        });
        
        // Ajouter la nouvelle ligne
        container.appendChild(newRow);
        
        // Ajouter le gestionnaire d'événement pour supprimer
        newRow.querySelector('.btn-remove-row').addEventListener('click', function() {
            if (container.querySelectorAll('.produit-row').length > 1) {
                this.closest('.produit-row').remove();
            }
        });
    });
    
    // Gestionnaire d'événement pour les boutons de suppression existants
    document.querySelectorAll('.btn-remove-row').forEach(button => {
        button.addEventListener('click', function() {
            const container = document.getElementById('produits-container');
            if (container.querySelectorAll('.produit-row').length > 1) {
                this.closest('.produit-row').remove();
            }
        });
    });
});
</script>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>