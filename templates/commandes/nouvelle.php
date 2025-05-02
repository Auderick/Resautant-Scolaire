<?php
// filepath: c:\MAMP\htdocs\compte_restaurant_scolaire\templates\commandes\nouvelle.php
require_once __DIR__ . '/../../includes/header.php';
require_once __DIR__ . '/../../src/Models/commande.php';

// Initialiser le modèle Commande
$commandeModel = new Commande();

// Traitement du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $fournisseur = $_POST['fournisseur'];
        $dateLivraison = !empty($_POST['date_livraison']) ? $_POST['date_livraison'] : null;
        $notes = !empty($_POST['notes']) ? $_POST['notes'] : null;

        // Créer la commande
        $commandeId = $commandeModel->creerCommande($fournisseur, $dateLivraison, $notes);

        // Ajouter les produits si présents
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

        header("Location: voir.php?id=$commandeId&created=1");
        exit;
    } catch (Exception $e) {
        $erreur = "Erreur lors de la création de la commande: " . $e->getMessage();
    }
}

// Récupérer la liste des fournisseurs pour l'auto-complétion
$fournisseurs = $commandeModel->getFournisseurs();
?>

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Nouvelle Commande</h1>
        <a href="index.php" class="btn btn-secondary">Retour à la liste</a>
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
                        <input type="text" class="form-control" id="fournisseur" name="fournisseur" required
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
                        <input type="date" class="form-control" id="date_livraison" name="date_livraison">
                    </div>
                </div>
                
                <div class="row mb-3">
                    <label for="notes" class="col-md-3 col-form-label">Notes</label>
                    <div class="col-md-9">
                        <textarea class="form-control" id="notes" name="notes" rows="3"
                                  placeholder="Instructions spéciales, conditions de livraison..."></textarea>
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
                </div>
                
                <button type="button" class="btn btn-success mt-2" id="btnAjouterProduit">
                    <i class="bi bi-plus-circle"></i> Ajouter un produit
                </button>
            </div>
        </div>
        
        <div class="text-center mt-4">
            <button type="submit" class="btn btn-primary btn-lg">Créer la commande</button>
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
        const newRow = container.querySelector('.produit-row').cloneNode(true);
        
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
    
    // Gestionnaire d'événement pour le bouton de suppression existant
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