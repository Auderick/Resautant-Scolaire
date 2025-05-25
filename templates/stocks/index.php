<?php
setlocale(LC_TIME, 'fr_FR.UTF-8', 'fra');
date_default_timezone_set('Europe/Paris');

require_once __DIR__ . '/../../includes/debug.php'; // Ajout du fichier de débogage
require_once __DIR__ . '/../../includes/header.php';
require_once __DIR__ . '/../../includes/functions.php';
require_once __DIR__ . '/../../src/Models/stock.php';
require_once __DIR__ . '/../../auth/auth_functions.php';

$stock = new Stock();

// Gestion des paramètres de date
$mois = isset($_GET['mois']) ? intval($_GET['mois']) : intval(date('m'));
$annee = isset($_GET['annee']) ? intval($_GET['annee']) : intval(date('Y'));

// Calcul du mois précédent et suivant
$datePrecedente = new DateTime("$annee-$mois-01");
$datePrecedente->modify('-1 month');
$dateSuivante = new DateTime("$annee-$mois-01");
$dateSuivante->modify('+1 month');

// Traitement des actions

// Remplacer la section de traitement des actions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!hasEditPermission()) {
        die("Erreur : Vous n'avez pas la permission d'effectuer cette action");
    }
    if (isset($_POST['action'])) {
        try {
            // Log des données reçues
            error_log("Action reçue : " . $_POST['action']);
            error_log("Données POST : " . print_r($_POST, true));
            switch ($_POST['action']) {
                case 'ajouter':
                    $date_mouvement = !empty($_POST['date_mouvement'])
                        ? date('Y-m-d H:i:s', strtotime($_POST['date_mouvement']))
                        : null;

                    $stock->ajouter(
                        $_POST['produit'],
                        $_POST['quantite'],
                        $_POST['prix_unitaire'],
                        $_POST['unite'],
                        $_POST['seuil_alerte'],
                        $date_mouvement
                    );
                    break;

                case 'modifier':
                    if (!isset($_POST['id'])) {
                        throw new Exception('ID manquant');
                    }
                    $date_mouvement = !empty($_POST['date_mouvement'])
                        ? date('Y-m-d H:i:s', strtotime($_POST['date_mouvement']))
                        : null;

                    $stock->modifier(
                        $_POST['id'],
                        $_POST['produit'],
                        $_POST['quantite'],
                        $_POST['prix_unitaire'],
                        $_POST['unite'],
                        $_POST['seuil_alerte'],
                        $date_mouvement
                    );
                    break;

                case 'ajuster':
                    if (!isset($_POST['id']) || !isset($_POST['ajustement'])) {
                        throw new Exception('Paramètres manquants');
                    }
                    $date_mouvement = !empty($_POST['date_mouvement'])
                        ? date('Y-m-d H:i:s', strtotime($_POST['date_mouvement']))
                        : null;
                    $stock->ajusterStock($_POST['id'], $_POST['ajustement'], $date_mouvement);
                    break;

                case 'supprimer':
                    if (!isset($_POST['id'])) {
                        throw new Exception('ID manquant');
                    }
                    $stock->supprimer($_POST['id']);
                    break;
            }
            // Redirection après succès
            header("Location: ?mois={$mois}&annee={$annee}");
            exit;
        } catch (Exception $e) {
            // En cas d'erreur, on affiche un message
            $error = $e->getMessage();
        }
    }
}


$stocks = $stock->getListe($mois, $annee);
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

    <h1 class="text-center mb-4">Gestion des Stocks</h1>

    <!-- Formulaire d'ajout -->
    <?php if (hasEditPermission()): ?>
    <div class="card mb-4">
        <div class="card-body">
            <h2 class="card-title">Nouveau produit</h2>
            <form method="POST" class="row g-3">
                <input type="hidden" name="action" value="ajouter">
                <div class="col-md-4">
                    <label for="produit" class="form-label">Produit</label>
                    <input type="text" class="form-control" id="produit" name="produit" required>
                </div>
                <div class="col-md-2">
                    <label for="quantite" class="form-label">Quantité</label>
                    <input type="number" class="form-control" id="quantite" name="quantite" required>
                </div>
                <div class="col-md-2">
                    <label for="prix_unitaire" class="form-label">Prix unitaire</label>
                    <input type="number" step="0.01" class="form-control" id="prix_unitaire" name="prix_unitaire"
                        required>
                </div>
                <div class="col-md-2">
                    <label for="unite" class="form-label">Unité</label>
                    <select class="form-select" id="unite" name="unite" required>
                        <option value="kg">Kilogrammes</option>
                        <option value="g">Grammes</option>
                        <option value="l">Litres</option>
                        <option value="unité">Unités</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label for="seuil_alerte" class="form-label">Seuil d'alerte</label>
                    <input type="number" class="form-control" id="seuil_alerte" name="seuil_alerte" value="10">
                </div>
                <div class="col-md-4">
                    <label for="date_mouvement" class="form-label">Date du mouvement</label>
                    <input type="datetime-local" class="form-control" id="date_mouvement" name="date_mouvement"
                        value="<?= date('Y-m-d\TH:i') ?>"
                        required>
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-primary">Ajouter</button>
                </div>
            </form>
        </div>
    </div>
    <?php endif; ?>

    <!-- Liste des stocks -->
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h2 class="card-title mb-0">État des stocks</h2>
                <div>
                    <a href="historique.php" class="btn btn-secondary me-2">
                        <i class="bi bi-clock-history"></i> Historique
                    </a>
                    <button class="btn btn-primary" onclick="imprimerStocks()">
                        <i class="bi bi-printer"></i> Imprimer
                    </button>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Produit</th>
                            <th>Quantité</th>
                            <th>Prix unitaire</th>
                            <th>Valeur stock</th>
                            <th>Unité</th>
                            <th>Dernière MAJ</th>
                            <th>Seuil d'alerte</th>
                            <?php if (hasEditPermission()): ?>
                            <th>Actions</th>
                            <?php endif; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $total_stock = 0;
                        foreach ($stocks as $s):
                            $total_stock += $s['valeur_stock'];
                            ?>
                        <tr
                            class="<?= $s['stock_status'] === 'alert' ? 'table-danger' : ($s['stock_status'] === 'warning' ? 'table-warning' : '') ?>">
                            <td><?= htmlspecialchars($s['produit']) ?>
                            </td>
                            <td><?= $s['quantite'] ?>
                            </td>
                            <td><?= number_format($s['prix_unitaire'], 2) ?>
                                €</td>
                            <td><?= number_format($s['valeur_stock'], 2) ?>
                                €</td>
                            <td><?= htmlspecialchars($s['unite']) ?>
                            </td>
                            <td><?= date('d/m/Y H:i', strtotime($s['date_maj'])) ?>
                            </td>
                            <td><?= $s['seuil_alerte'] ?>
                            </td>
                            <?php if (hasEditPermission()): ?>
                            <td>
                                <button class="btn btn-sm btn-primary"
                                    onclick="ajusterStock(<?= $s['id'] ?>)">
                                    <i class="bi bi-arrow-down-up"></i>
                                </button>
                                <button class="btn btn-sm btn-warning"
                                    onclick="modifierStock(<?= $s['id'] ?>)">
                                    <i class="bi bi-pencil"></i>
                                </button>
                                <button class="btn btn-sm btn-danger"
                                    onclick="supprimerStock(<?= $s['id'] ?>)">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </td>
                            <?php endif; ?>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <tfoot>
                    <tr class="table-primary">
                        <td colspan="3"><strong>Valeur totale du stock</strong></td>
                        <td colspan="5">
                            <strong><?= number_format($total_stock, 2) ?>
                                €</strong>
                        </td>
                    </tr>
                </tfoot>
            </div>
        </div>
    </div>

    <!-- Modal de modification -->
    <?php if (hasEditPermission()): ?>
    <div class="modal fade" id="modalModifier" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Modifier le produit</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form method="POST" id="formModifier">
                    <div class="modal-body">
                        <input type="hidden" name="action" value="modifier">
                        <input type="hidden" name="id" id="modif_id">
                        <div class="mb-3">
                            <label for="modif_produit" class="form-label">Produit</label>
                            <input type="text" class="form-control" id="modif_produit" name="produit" required>
                        </div>
                        <div class="mb-3">
                            <label for="modif_quantite" class="form-label">Quantité</label>
                            <input type="number" class="form-control" id="modif_quantite" name="quantite" required>
                        </div>
                        <div class="mb-3">
                            <label for="modif_prix_unitaire" class="form-label">Prix unitaire</label>
                            <input type="number" step="0.01" class="form-control" id="modif_prix_unitaire"
                                name="prix_unitaire" required>
                        </div>
                        <div class="mb-3">
                            <label for="modif_unite" class="form-label">Unité</label>
                            <select class="form-select" id="modif_unite" name="unite" required>
                                <option value="kg">Kilogrammes</option>
                                <option value="g">Grammes</option>
                                <option value="l">Litres</option>
                                <option value="unité">Unités</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="modif_seuil_alerte" class="form-label">Seuil d'alerte</label>
                            <input type="number" class="form-control" id="modif_seuil_alerte" name="seuil_alerte"
                                required>
                        </div>
                        <div class="mb-3">
                            <label for="modif_date_mouvement" class="form-label">Date du mouvement</label>
                            <input type="datetime-local" class="form-control" id="modif_date_mouvement"
                                name="date_mouvement">
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
</div>
 <!-- Définir la variable de permission -->
    <script>
        window.hasEditPermission = <?= hasEditPermission() ? 'true' : 'false' ?>;
    </script>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>