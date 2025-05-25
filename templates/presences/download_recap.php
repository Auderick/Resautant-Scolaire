<?php

require_once __DIR__ . '/../../includes/functions.php';
require_once __DIR__ . '/../../src/Models/presence.php';
require_once __DIR__ . '/../../vendor/autoload.php';

$presence = new Presence();
$categories = $presence->getCategories();

// Gestion des paramètres
$mois = isset($_GET['mois']) ? intval($_GET['mois']) : intval(date('m'));
$annee = isset($_GET['annee']) ? intval($_GET['annee']) : intval(date('Y'));
$categorieId = isset($_GET['categorie']) ? intval($_GET['categorie']) : 1;

// Récupération du nom de la catégorie
$nomCategorie = '';
foreach ($categories as $cat) {
    if ($cat['id'] == $categorieId) {
        $nomCategorie = $cat['nom'];
        break;
    }
}

// Récupération des données
$recap = $presence->getRecapitulatifMensuel($mois, $annee, $categorieId);

// Configuration MPDF
$mpdf = new \Mpdf\Mpdf([
    'margin_left' => 10,
    'margin_right' => 10,
    'margin_top' => 15,
    'margin_bottom' => 15,
]);

// CSS pour le PDF
$css = file_get_contents(__DIR__ . '/../../public/css/presence-grid.css');
$mpdf->WriteHTML('
<style>
    ' . $css . '
    body {
        font-family: Arial, sans-serif;
        margin: 20px;
        font-size: 12pt;
    }
    h1 {
        font-size: 16pt;
        text-align: center;
        margin-bottom: 20px;
    }
    .header {
        text-align: center;
        margin-bottom: 30px;
    }
    table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 30px;
        page-break-inside: auto;
    }
    tr {
        page-break-inside: avoid;
        page-break-after: auto;
    }
    thead {
        display: table-header-group;
    }
    th {
        font-weight: bold;
        background-color: #f8f9fa;
    }
    th, td {
        border: 1px solid #000;
        padding: 8px;
        font-size: 11pt;
    }
    .footer {
        text-align: center;
        font-size: 8pt;
        margin-top: 30px;
        position: fixed;
        bottom: 0;
        width: 100%;
    }    .jours-present, .jours-absent {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 5px;
        padding: 0;
        margin: 0;
        list-style: none;
    }
    .jours-present li, .jours-absent li {
        text-align: center;
        padding: 2px 5px;
        border: 1px solid #999;
        border-radius: 3px;
        margin: 0;
    }
</style>
');

// Contenu du PDF
$html = '
<div class="header">
    <h1>Récapitulatif des Présences - ' . htmlspecialchars($nomCategorie) . '</h1>
    <div>' . formatDateToFrench("$annee-$mois-01", 'MMMM Y') . '</div>
</div>

<table>
    <thead>
        <tr>
            <th style="width: 20%">Nom</th>
            <th style="width: 20%">Prénom</th>
            <th>Jours présent</th>
            <th>Jours absent</th>
            <th style="width: 12%">Total P.</th>
            <th style="width: 12%">Total A.</th>
        </tr>
    </thead>
    <tbody>';

foreach ($recap as $personne) {
    $joursPresent = $personne['jours_present'] ? explode(',', $personne['jours_present']) : [];
    $joursAbsent = $personne['jours_absent'] ? explode(',', $personne['jours_absent']) : [];
    sort($joursPresent, SORT_NUMERIC);
    sort($joursAbsent, SORT_NUMERIC);    // Fonction pour créer une table de jours (4 colonnes)
    $createDaysTable = function($jours) {
        if (empty($jours)) return '-';
        
        $html = '<table style="width: 100%; margin: 0; border: none;">';
        $chunks = array_chunk($jours, 4);
        
        foreach ($chunks as $chunk) {
            $html .= '<tr>';
            foreach ($chunk as $jour) {
                $html .= '<td style="width: 25%; text-align: center; border: 1px solid #999; padding: 2px; margin: 2px; border-radius: 3px;">' . 
                    $jour . 
                '</td>';
            }
            // Remplir les cellules manquantes si nécessaire
            for ($i = count($chunk); $i < 4; $i++) {
                $html .= '<td style="width: 25%; border: none;"></td>';
            }
            $html .= '</tr>';
        }
        $html .= '</table>';
        return $html;
    };

    $html .= '<tr>
        <td>' . htmlspecialchars($personne['nom']) . '</td>
        <td>' . htmlspecialchars($personne['prenom']) . '</td>
        <td style="padding: 2px;">' . $createDaysTable($joursPresent) . '</td>
        <td style="padding: 2px;">' . $createDaysTable($joursAbsent) . '</td>
        <td style="text-align: center">' . $personne['total_presences'] . '</td>
        <td style="text-align: center">' . $personne['total_absences'] . '</td>
    </tr>';
}

$html .= '</tbody></table>

<div class="footer">
    ' . htmlspecialchars($nomCategorie) . ' - ' . formatDateToFrench("$annee-$mois-01", 'MMMM Y') . '
</div>';

$mpdf->WriteHTML($html);

// Nom du fichier
$filename = 'recap_presences_' . $nomCategorie . '_' . $mois . '_' . $annee . '.pdf';

// Envoi du PDF
$mpdf->Output($filename, 'D');
