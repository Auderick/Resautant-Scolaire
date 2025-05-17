<?php

setlocale(LC_TIME, 'fr_FR.UTF-8', 'fra');
date_default_timezone_set('Europe/Paris');

require_once __DIR__ . '/../../includes/auth_check.php';
require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../../src/Models/vente.php';

// Récupération des paramètres
$mois = isset($_GET['mois']) ? intval($_GET['mois']) : intval(date('m'));
$annee = isset($_GET['annee']) ? intval($_GET['annee']) : intval(date('Y'));

// Initialisation de mPDF
$mpdf = new \Mpdf\Mpdf([
    'margin_left' => 15,
    'margin_right' => 15,
    'margin_top' => 15,
    'margin_bottom' => 15,
]);

// Création d'une instance de Vente
$vente = new Vente();
$ventes = $vente->getListe($mois, $annee);

// En-tête du document
$html = '
<style>
    table { width: 100%; border-collapse: collapse; margin-bottom: 10px; }
    th, td { border: 1px solid #000; padding: 8px; text-align: center; }
    th { background-color: #f2f2f2; }
    h1 { text-align: center; color: #333; }
    .total { font-weight: bold; background-color: #f2f2f2; }
</style>

<h1>Récapitulatif des Ventes - ' . strftime('%B %Y', mktime(0, 0, 0, $mois, 1, $annee)) . '</h1>

<table>
    <thead>
        <tr>
            <th>Date</th>
            <th>Nombre de Repas</th>
            <th>Prix Unitaire</th>
            <th>Total</th>
        </tr>
    </thead>
    <tbody>';

$totalRepas = 0;
$totalMontant = 0;

foreach ($ventes as $v) {
    $total = $v['nb_repas'] * $v['prix_unitaire'];
    $totalRepas += $v['nb_repas'];
    $totalMontant += $total;

    $html .= '<tr>
        <td>' . date('d/m/Y', strtotime($v['date_vente'])) . '</td>
        <td>' . $v['nb_repas'] . '</td>
        <td>' . number_format($v['prix_unitaire'], 2, ',', ' ') . ' €</td>
        <td>' . number_format($total, 2, ',', ' ') . ' €</td>
    </tr>';
}

// Ligne des totaux
$html .= '<tr class="total">
        <td>Total</td>
        <td>' . $totalRepas . '</td>
        <td>-</td>
        <td>' . number_format($totalMontant, 2, ',', ' ') . ' €</td>
    </tr>
</tbody>
</table>';

// Statistiques
$html .= '<div style="margin-top: 20px;">
    <h2>Statistiques</h2>
    <p>Nombre total de repas : ' . $totalRepas . '</p>
    <p>Montant total : ' . number_format($totalMontant, 2, ',', ' ') . ' €</p>
    <p>Prix moyen par repas : ' . ($totalRepas > 0 ? number_format($totalMontant / $totalRepas, 2, ',', ' ') : '0,00') . ' €</p>
</div>';

// Génération du PDF
$mpdf->WriteHTML($html);

// Nom du fichier
$filename = 'Ventes_' . strftime('%B_%Y', mktime(0, 0, 0, $mois, 1, $annee)) . '.pdf';

// Envoi du PDF
$mpdf->Output($filename, 'D');
