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
$commande_id = isset($_GET['commande']) && !empty($_GET['commande']) ? intval($_GET['commande']) : null;

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
                    $_POST['quantite'],
                    $_POST['unite'],
                    $_POST['prix_unitaire'],
                    $_POST['montant_total'],
                    $dateAchat
                );
                break;
            case 'modifier':
                $dateAchat = !empty($_POST['date_achat']) ? $_POST['date_achat'] : null;
                $achat->modifier(
                    $_POST['id'],
                    $_POST['fournisseur'],
                    $_POST['description'],
                    $_POST['quantite'],
                    $_POST['unite'],
                    $_POST['prix_unitaire'],
                    $_POST['montant_total'],
                    $dateAchat
                );
                break;
            case 'supprimer':
                $achat->supprimer($_POST['id']);
                break;
        }
    }
}
// Récupération des achats avec le filtre de commande
$achats = $achat->getListe($mois, $annee, $commande_id);
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
                <!-- Nouveaux champs -->
                <div class="col-md-4">
                    <label for="quantite" class="form-label">Quantité</label>
                    <input type="number" step="0.01" class="form-control" id="quantite" name="quantite" required
                        onchange="calculerMontantTotal()">
                </div>
                <div class="col-md-4">
                    <label for="unite" class="form-label">Unité</label>
                    <input type="text" class="form-control" id="unite" name="unite" required>
                </div>
                <div class="col-md-4">
                    <label for="prix_unitaire" class="form-label">Prix unitaire</label>
                    <input type="number" step="0.01" class="form-control" id="prix_unitaire" name="prix_unitaire"
                        required onchange="calculerMontantTotal()">
                </div>
                <div class="col-md-6">
                    <label for="montant" class="form-label">Montant total</label>
                    <input type="number" step="0.01" class="form-control" id="montant" name="montant_total" required>
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
                <div>
                    <!-- Formulaire de filtre par commande -->
                    <div class="d-inline-block me-2">
                        <form method="GET" class="d-flex align-items-center">
                            <input type="hidden" name="mois"
                                value="<?= $mois ?>">
                            <input type="hidden" name="annee"
                                value="<?= $annee ?>">
                            <select name="commande" class="form-select form-select-sm me-2"
                                onchange="this.form.submit()">
                                <option value="">Toutes les commandes</option>
                                <?php
                                    // Récupérer la liste des commandes ayant des achats
                                    $commandeIds = [];
                                          
                                    foreach ($achats as $a) {
                                        if (!empty($a['commande_id']) && !in_array($a['commande_id'], $commandeIds)) {
                                            $commandeIds[] = $a['commande_id'];
                                        }
                                    };
                                    foreach ($commandeIds as $cmdId):
                                ?>
                                <option value="<?= $cmdId ?>" <?= isset($_GET['commande']) && $_GET['commande'] == $cmdId ? 'selected' : '' ?>>
                                    Commande #<?= $cmdId ?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                            <?php if (isset($_GET['commande'])): ?>
                            <a href="?mois=<?= $mois ?>&annee=<?= $annee ?>"
                                class="btn btn-sm btn-outline-secondary">
                                <i class="bi bi-x"></i> Réinitialiser
                            </a>
                            <?php endif; ?>
                        </form>
                    </div>
                    <button class="btn btn-primary" onclick="imprimerAchats()">
                        <i class="bi bi-printer"></i> Imprimer
                    </button>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Fournisseur</th>
                            <th>Description</th>
                            <th>Quantité</th>
                            <th>Unité</th>
                            <th>Prix unit.</th>
                            <th>Montant</th>
                            <?php if (hasEditPermission()): ?>
                            <th>Actions</th>
                            <?php endif; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                    $currentCommandeId = null;
                    $commandeTotal = 0;
                    $totalGeneral = 0;

                    foreach ($achats as $a):
    // Si on change de commande, afficher un en-tête de commande
    if (!empty($a['commande_id']) && $a['commande_id'] !== $currentCommandeId):

        // Si on était dans une commande précédente, afficher le sous-total
        if ($currentCommandeId !== null && $commandeTotal > 0):
            ?>
                        <tr class="table-info">
                            <td colspan="6" class="text-end fw-bold">Sous-total commande
                                #<?= $currentCommandeId ?>:</td>
                            <td class="fw-bold">
                                <?= number_format($commandeTotal, 2) ?>
                                €
                            </td>
                            <td></td>
                        </tr>
                        <?php
        endif;

        // Réinitialiser le total de la commande
        $commandeTotal = 0;
        $currentCommandeId = $a['commande_id'];
        ?>
                        <tr class="commande-header">
                            <td colspan="8">
                                <div class="d-flex align-items-center">
                                    <i class="bi bi-box-seam me-2"></i>
                                    <strong>Commande
                                        #<?= $a['commande_id'] ?></strong>
                                    <?php if (!empty($a['commande_fournisseur'])): ?>
                                    <span class="ms-2">- Fournisseur:
                                        <?= htmlspecialchars($a['commande_fournisseur']) ?></span>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                        <?php elseif (empty($a['commande_id']) && $currentCommandeId !== null):
                            // On passe d'une commande à un achat individuel
                            if ($commandeTotal > 0):
                                ?>
                        <tr class="table-info">
                            <td colspan="6" class="text-end fw-bold">Sous-total commande
                                #<?= $currentCommandeId ?>:</td>
                            <td class="fw-bold">
                                <?= number_format($commandeTotal, 2) ?>
                                €
                            </td>
                            <td></td>
                        </tr>
                        <?php
                            endif;
                            $commandeTotal = 0;
                            $currentCommandeId = null;
                            endif;

                            // Ajouter au total de la commande si applicable
                            if (!empty($a['commande_id'])) {
                                $commandeTotal += $a['montant_total'];
                            }

                            // Ajouter au total général
                            $totalGeneral += $a['montant_total'];
                        ?>
                        <tr
                            class="<?= !empty($a['commande_id']) ? 'from-commande' : '' ?>">
                            <td><?= date('d/m/Y', strtotime($a['date_achat'])) ?>
                            </td>
                            <td><?= htmlspecialchars($a['fournisseur']) ?>
                            </td>
                            <td><?= htmlspecialchars($a['description']) ?>
                            </td>
                            <td><?= number_format($a['quantite'], 2) ?>
                            </td>
                            <td><?= htmlspecialchars($a['unite']) ?>
                            </td>
                            <td><?= number_format($a['prix_unitaire'], 2) ?>
                                €</td>
                            <td><?= number_format($a['montant_total'], 2) ?>
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
                        <?php endforeach;
// Afficher le dernier sous-total si nécessaire
if ($currentCommandeId !== null && $commandeTotal > 0):
    ?>
                        <tr class="table-info">
                            <td colspan="6" class="text-end fw-bold">Sous-total commande
                                #<?= $currentCommandeId ?>:</td>
                            <td class="fw-bold">
                                <?= number_format($commandeTotal, 2) ?>
                                €
                            </td>
                            <td></td>
                        </tr>
                        <?php endif; ?>

                        <!-- Total général -->
                        <tr class="table-dark">
                            <td colspan="6" class="text-end fw-bold">Total général:</td>
                            <td class="fw-bold">
                                <?= number_format($totalGeneral, 2) ?>
                                €
                            </td>
                            <td></td>
                        </tr>
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
                            <label for="modif_quantite" class="form-label">Quantité</label>
                            <input type="number" step="0.01" class="form-control" id="modif_quantite" name="quantite"
                                required onchange="calculerMontantTotalModif()" oninput="calculerMontantTotalModif()">
                        </div>

                        <div class="mb-3">
                            <label for="modif_unite" class="form-label">Unité</label>
                            <input type="text" class="form-control" id="modif_unite" name="unite" required>
                        </div>

                        <div class="mb-3">
                            <label for="modif_prix_unitaire" class="form-label">Prix unitaire (€)</label>
                            <input type="number" step="0.01" class="form-control" id="modif_prix_unitaire"
                                name="prix_unitaire" required onchange="calculerMontantTotalModif()"
                                oninput="calculerMontantTotalModif()">
                        </div>

                        <div class="mb-3">
                            <label for="modif_montant" class="form-label">Montant total (€)</label>
                            <input type="number" step="0.01" class="form-control" id="modif_montant"
                                name="montant_total" readonly>
                            <small class="form-text text-muted">Calculé automatiquement (quantité × prix
                                unitaire)</small>
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
        window
            .hasEditPermission = <?= hasEditPermission() ? 'true' : 'false' ?> ;
    </script>

    <?php require_once __DIR__ . '/../../includes/footer.php'; ?>