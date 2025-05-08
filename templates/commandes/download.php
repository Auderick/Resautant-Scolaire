<?php

require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../../src/Models/commande.php';

// Vérifier si l'ID est fourni
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header('Location: index.php');
    exit;
}

$commandeId = intval($_GET['id']);

// Initialiser le modèle
$commandeModel = new Commande();

// Récupérer les détails de la commande
try {
    $commande = $commandeModel->getCommande($commandeId);
    if (!$commande) {
        die("Commande introuvable.");
    }

    $lignesCommande = $commandeModel->getLignesCommande($commandeId);
} catch (Exception $e) {
    die("Erreur lors de la récupération des données: " . $e->getMessage());
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

// Créer une instance de mPDF
$mpdf = new \Mpdf\Mpdf([
    'mode' => 'utf-8',
    'format' => 'A4',
    'margin_left' => 15,
    'margin_right' => 15,
    'margin_top' => 15,
    'margin_bottom' => 15
]);

// Définir les métadonnées du document
$mpdf->SetTitle('Bon de commande #' . $commandeId);
$mpdf->SetAuthor('Restaurant Scolaire de Leignes sur Fontaine');
$mpdf->SetCreator('Système de Gestion');

// Créer le contenu HTML
$html = '
<style>
    body { font-family: Arial, sans-serif; }
    .header { text-align: center; margin-bottom: 20px; }
    .info-container { margin-bottom: 20px; }
    .info-table { width: 100%; }
    .info-table td, .info-table th { padding: 5px; }
    .products-table { width: 100%; border-collapse: collapse; }
    .products-table th, .products-table td { border: 1px solid #ddd; padding: 8px; text-align: left; }
    .products-table th { background-color: #f2f2f2; }
    .text-right { text-align: right; }
    .text-center { text-align: center; }
    .footer { margin-top: 50px; }
    .signature { width: 45%; float: left; margin-right: 5%; border-top: 1px solid #000; padding-top: 10px; }
    .signature-right { margin-right: 0; float: right; }
    .clear { clear: both; }
    .address-block { width: 48%; float: left; margin-bottom: 20px; }
    .supplier-block { width: 48%; float: right; text-align: right; margin-bottom: 20px; }
</style>

<div class="header">
    <h1>Restaurant Scolaire de Leignes sur Fontaine</h1>
    <h2>Bon de Commande N° ' . $commandeId . '</h2>
</div>

<div class="info-container">
    <div class="address-block">
        <strong>Restaurant Scolaire</strong><br>
        École de Leignes sur Fontaine<br>
        2, place de la Mairie<br>
        86300 Leignes sur Fontaine<br>
        Tél: 06 77 80 41 55<br>
        Email: [Adresse email]
    </div>
    
    <div class="supplier-block">
        <strong>Fournisseur:</strong><br>
        ' . htmlspecialchars($commande['fournisseur']) . '<br>
        
    </div>
    
    <div style="clear:both;"></div>
    
    <table class="info-table">
        <tr>
            <th style="width:30%;">Date de commande:</th>
            <td>' . date('d/m/Y', strtotime($commande['date_commande'])) . '</td>
        </tr>
        <tr>
            <th>Livraison souhaitée:</th>
            <td>' . ($commande['date_livraison_souhaitee'] ? date('d/m/Y', strtotime($commande['date_livraison_souhaitee'])) : '-') . '</td>
        </tr>';

if (!empty($commande['notes'])) {
    $html .= '
        <tr>
            <th>Notes:</th>
            <td>' . nl2br(htmlspecialchars($commande['notes'])) . '</td>
        </tr>';
}

$html .= '
    </table>
</div>

<h3>Produits commandés</h3>
<table class="products-table">
    <thead>
        <tr>
            <th>Produit</th>
            <th class="text-center">Quantité</th>
            <th>Unité</th>
            <th class="text-right">Prix unitaire</th>
            <th class="text-right">Total</th>
        </tr>
    </thead>
    <tbody>';

if (empty($lignesCommande)) {
    $html .= '
        <tr>
            <td colspan="5" class="text-center">Aucun produit dans cette commande</td>
        </tr>';
} else {
    foreach ($lignesCommande as $ligne) {
        $prixUnitaireFormate = !empty($ligne['prix_unitaire']) ? number_format($ligne['prix_unitaire'], 2, ',', ' ') . ' €' : '-';
        $totalLigne = !empty($ligne['prix_unitaire']) ? number_format($ligne['quantite'] * $ligne['prix_unitaire'], 2, ',', ' ') . ' €' : '-';

        $html .= '
        <tr>
            <td>' . htmlspecialchars($ligne['produit']) . '</td>
            <td class="text-center">' . number_format($ligne['quantite'], 2, ',', ' ') . '</td>
            <td>' . htmlspecialchars($ligne['unite'] ?? '') . '</td>
            <td class="text-right">' . $prixUnitaireFormate . '</td>
            <td class="text-right">' . $totalLigne . '</td>
        </tr>';
    }
}

$html .= '
    </tbody>
    <tfoot>
        <tr>
            <th colspan="4" class="text-right">Total</th>
            <th class="text-right">' . $totalFormate . ' €</th>
        </tr>
    </tfoot>
</table>

<div class="footer">
    <div class="signature">
        <p><strong>Date et signature du Restaurant Scolaire:</strong></p>
    </div>
    <div class="signature signature-right">
        <p><strong>Date et signature du Fournisseur:</strong></p>
    </div>
    <div class="clear"></div>
</div>';

// Écrire le contenu HTML dans le PDF
$mpdf->WriteHTML($html);

// Sortie du PDF
$filename = 'BonCommande_' . $commandeId . '_' . date('Ymd') . '.pdf';
$mpdf->Output($filename, 'D');
