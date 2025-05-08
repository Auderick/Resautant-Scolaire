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

// Traitement du formulaire pour changer le statut
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'update_statut') {
    try {
        $statut = $_POST['statut'];
        $commandeModel->updateStatut($commandeId, $statut);
        $message = "Le statut de la commande a été mis à jour.";
    } catch (Exception $e) {
        $erreur = "Erreur lors de la mise à jour du statut: " . $e->getMessage();
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

// Calculer le total de la commande
$totalCommande = 0;
foreach ($lignesCommande as $ligne) {
    if (!empty($ligne['prix_unitaire'])) {
        $totalCommande += $ligne['quantite'] * $ligne['prix_unitaire'];
    }
}

// Formater le total avec séparateur de milliers
$totalFormate = number_format($totalCommande, 2, ',', ' ');

// Notification après création
$created = isset($_GET['created']) && $_GET['created'] === '1';
?>

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Bon de Commande
            <?= $commande['id'] ?>
        </h1>
        <div>
            <a href="index.php" class="btn btn-secondary">Retour à la liste</a>
            <button onclick="imprimerCommande(<?= $commandeId ?>)"
                class="btn btn-info me-2">
                <i class="bi bi-printer"></i> Imprimer
            </button>
            <a href="download.php?id=<?= $commandeId ?>"
                class="btn btn-success ms-2">
                <i class="bi bi-download"></i> Télécharger PDF
            </a>
        </div>
    </div>

    <?php if ($created): ?>
    <div class="alert alert-success">La commande a été créée avec succès!</div>
    <?php endif; ?>

    <?php if (isset($message)): ?>
    <div class="alert alert-success">
        <?= htmlspecialchars($message) ?>
    </div>
    <?php endif; ?>

    <?php if (isset($erreur)): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($erreur) ?>
    </div>
    <?php endif; ?>

    <div class="row" id="printable-content">
        <!-- En-tête pour l'impression -->
        <div class="d-none d-print-block mb-4">
            <div class="text-center">
                <h1>Restaurant Scolaire de Leignes sur Fontaine</h1>
                <h3>Bon de Commande N° <?= $commandeId ?></h3>
            </div>
        </div>

        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Informations générales</h5>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <th style="width: 40%;">Date de commande:</th>
                            <td><?= date('d/m/Y', strtotime($commande['date_commande'])) ?>
                            </td>
                        </tr>
                        <tr>
                            <th>Fournisseur:</th>
                            <td><?= htmlspecialchars($commande['fournisseur']) ?>
                            </td>
                        </tr>
                        <tr>
                            <th>Livraison souhaitée:</th>
                            <td><?= $commande['date_livraison_souhaitee'] ? date('d/m/Y', strtotime($commande['date_livraison_souhaitee'])) : '-' ?>
                            </td>
                        </tr>
                        <tr>
                            <th>Statut:</th>
                            <td>
                                <span
                                    class="badge bg-<?= $commande['statut'] == 'envoyee' ? 'success' :
                                    ($commande['statut'] == 'brouillon' ? 'warning' :
                                    ($commande['statut'] == 'recue' ? 'info' : 'danger')) ?>">
                                    <?= ucfirst(htmlspecialchars($commande['statut'])) ?>
                                </span>
                            </td>
                        </tr>
                        <?php if (isset($commande['convertie_en_achats']) && $commande['convertie_en_achats']): ?>
                        <tr>
                            <td colspan="2">
                                <div class="alert alert-success mt-2 mb-0">
                                    <i class="bi bi-check-circle-fill"></i>
                                    Cette commande a été automatiquement ajoutée aux achats.
                                    <a href="../achats/index.php?filtre_commande=<?= $commande['id'] ?>"
                                        class="alert-link">
                                        Voir les achats générés
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <?php endif; ?>
                        <?php if (!empty($commande['notes'])): ?>
                        <tr>
                            <th>Notes:</th>
                            <td><?= nl2br(htmlspecialchars($commande['notes'])) ?>
                            </td>
                        </tr>
                        <?php endif; ?>
                    </table>
                </div>
            </div>

            <!-- Formulaire de changement de statut (non imprimé) -->
            <div class="card mt-3 d-print-none">
                <div class="card-header">
                    <h5 class="card-title mb-0">Mettre à jour le statut</h5>
                </div>
                <div class="card-body">
                    <form method="post" class="d-flex">
                        <input type="hidden" name="action" value="update_statut">
                        <select name="statut" class="form-select me-2">
                            <option value="brouillon" <?= $commande['statut'] === 'brouillon' ? 'selected' : '' ?>>Brouillon
                            </option>
                            <option value="envoyee" <?= $commande['statut'] === 'envoyee' ? 'selected' : '' ?>>Envoyée
                            </option>
                            <option value="recue" <?= $commande['statut'] === 'recue' ? 'selected' : '' ?>>Reçue
                            </option>
                            <option value="annulee" <?= $commande['statut'] === 'annulee' ? 'selected' : '' ?>>Annulée
                            </option>
                        </select>
                        <button type="submit" class="btn btn-primary">Mettre à jour</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-4">
            <!-- Coordonnées pour l'impression -->
            <div class="card d-none d-print-block mb-4">
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <strong>Restaurant Scolaire</strong><br>
                            École de Leignes sur Fontaine<br>
                            [Adresse complète]<br>
                            Tél: 06 77 80 41 55<br>
                            Email: [Adresse email]
                        </div>
                        <div class="col-6 text-end">
                            <strong>Fournisseur:</strong><br>
                            <?= htmlspecialchars($commande['fournisseur']) ?><br>
                            [Adresse du fournisseur]
                        </div>
                    </div>
                </div>
            </div>

            <!-- Numéro de commande spécial pour l'impression -->
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Produits commandés</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table mb-0">
                            <thead>
                                <tr>
                                    <th>Produit</th>
                                    <th class="text-center">Quantité</th>
                                    <th>Unité</th>
                                    <th class="text-end">Prix unitaire</th>
                                    <th class="text-end">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($lignesCommande)): ?>
                                <tr>
                                    <td colspan="5" class="text-center">Aucun produit dans cette commande</td>
                                </tr>
                                <?php else: ?>
                                <?php foreach ($lignesCommande as $ligne): ?>
                                <tr>
                                    <td><?= htmlspecialchars($ligne['produit']) ?>
                                    </td>
                                    <td class="text-center">
                                        <?= number_format($ligne['quantite'], 2, ',', ' ') ?>
                                    </td>
                                    <td><?= htmlspecialchars($ligne['unite'] ?? '') ?>
                                    </td>
                                    <td class="text-end">
                                        <?= !empty($ligne['prix_unitaire']) ? number_format($ligne['prix_unitaire'], 2, ',', ' ') . ' €' : '-' ?>
                                    </td>
                                    <td class="text-end">
                                        <?php if (!empty($ligne['prix_unitaire'])): ?>
                                        <?= number_format($ligne['quantite'] * $ligne['prix_unitaire'], 2, ',', ' ') ?>
                                        €
                                        <?php else: ?>
                                        -
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="4" class="text-end">Total</th>
                                    <th class="text-end">
                                        <?= $totalFormate ?> €
                                    </th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Zone signature pour impression -->
        <div class="col-12 d-none d-print-block mt-5">
            <div class="row">
                <div class="col-6">
                    <div class="border-top pt-2">
                        <p><strong>Date et signature du Restaurant Scolaire:</strong></p>
                        <div style="height: 80px;"></div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="border-top pt-2">
                        <p><strong>Date et signature du Fournisseur:</strong></p>
                        <div style="height: 80px;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bouton d'impression et actions (non imprimés) -->
    <div class="d-flex justify-content-center my-4 d-print-none">
        <a href="modifier.php?id=<?= $commandeId ?>"
            class="btn btn-warning me-2">
            <i class="bi bi-pencil"></i> Modifier
        </a>
        <button onclick="imprimerCommande(<?= $commandeId ?>)"
            class="btn btn-info me-2">
            <i class="bi bi-printer"></i> Imprimer
        </button>
        <button onclick="telechargerCommande(<?= $commandeId ?>)"
            class="btn btn-success">
            <i class="bi bi-download"></i> Télécharger PDF
        </button>
    </div>


    <?php require_once __DIR__ . '/../../includes/footer.php'; ?>