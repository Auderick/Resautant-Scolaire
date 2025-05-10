<?php

require_once __DIR__ . '/../../src/Models/menu.php';
require_once __DIR__ . '/../../vendor/autoload.php';

// Vérifier qu'un ID est fourni
if (!isset($_GET['id'])) {
    die('ID non spécifié');
}

$menuModel = new Menu();
$semaineId = (int)$_GET['id'];
$semaine = $menuModel->getSemaine($semaineId);

if (!$semaine) {
    die('Semaine non trouvée');
}

// Récupérer les menus de la semaine
$menusSemaine = $menuModel->getMenusSemaine($semaineId);
$menus = [];

foreach ($menusSemaine as $menuJour) {
    $jour = $menuJour['jour'];
    $options = is_array($menuJour['options']) ? $menuJour['options'] : json_decode($menuJour['options'], true) ?: [];
    $allergenes = is_array($menuJour['allergenes']) ? $menuJour['allergenes'] : json_decode($menuJour['allergenes'], true) ?: [];

    $menus[$jour] = [
        'id' => $menuJour['id'],
        'entree' => $menuJour['entree'],
        'plat' => $menuJour['plat'],
        'accompagnement' => $menuJour['accompagnement'],
        'laitage' => $menuJour['laitage'],
        'dessert' => $menuJour['dessert'],
        'options' => $options,
        'allergenes' => $allergenes
    ];
}

// Configuration mPDF optimisée pour une seule page
$mpdf = new \Mpdf\Mpdf([
    'mode' => 'utf-8',
    'format' => 'A4',
    'margin_top' => 3,
    'margin_bottom' => 3,
    'margin_left' => 5,
    'margin_right' => 5,
    'default_font' => 'dejavusans'
]);

// CSS optimisé
$css = '
body { font-family: dejavusans; margin: 0; padding: 0; font-size: 9pt; }
.menu-container { width: 100%; margin: 0 auto; }
.header { background-color: #2b76c0; color: white; padding: 3px; margin-bottom: 3px; text-align: center; }
.header h1, .header p { margin: 2px 0; }
.header h1 { font-size: 14pt; }
.header p { font-size: 8pt; }
h1 { color: #70b1f2; text-align: center; font-size: 12pt; margin: 3px 0; }
h2 { color: #4a90e2; text-align: center; font-size: 10pt; margin: 2px 0; }
.jour { margin-bottom: 3px; border: 1px solid #87ceeb; padding: 1px; }
.jour-titre { color: #4a90e2; border-bottom: 1px dashed #87ceeb; padding: 1px; font-size: 10pt; font-weight: bold; margin-bottom: 1px; text-align: center; }
.plat { margin: 1px; font-size: 9pt; text-align: center; }
.allergenes { color: #e74c3c; font-weight: normal; font-size: 7pt; display: inline; }
.legende { margin-top: 2px; padding: 2px; background-color: #f5f5f5; text-align: center; font-size: 7pt; }
.icon-texte { font-weight: bold; margin-right: 1px; }
.icon-vege { color: #27ae60; }
.icon-local { color: #3498db; }
.icon-bio { color: #27ae60; }
.icon-warning { color: #e74c3c; }
.note { text-align: center; font-style: italic; font-size: 7pt; margin-top: 2px; }
';

// Appliquer le CSS
$mpdf->WriteHTML($css, \Mpdf\HTMLParserMode::HEADER_CSS);

// Début du contenu HTML
$html = '<div class="menu-container">
<div class="header">
    <h1>École de Leignes sur Fontaine</h1>
    <p>Tél: 05.49.56.90.10 | Service: 11h30 - 13h30</p>
</div>
<h1>Menu de la Semaine ' . $semaine['numero_semaine'] . '</h1>
<h2>Du ' . date('d/m/Y', strtotime($semaine['date_debut'])) . ' au ' . date('d/m/Y', strtotime($semaine['date_fin'])) . '</h2>';

$jours = ['lundi', 'mardi', 'jeudi', 'vendredi'];
$joursNoms = ['Lundi', 'Mardi', 'Jeudi', 'Vendredi'];

foreach ($jours as $index => $jour) {
    if (isset($menus[$jour]) && !empty($menus[$jour]['plat'])) {
        $jourDate = new DateTime($semaine['date_debut']);
        $jourDate->modify("+$index day");
        $dateStr = $jourDate->format('d/m');

        $html .= '<div class="jour">
        <div class="jour-titre">' . $joursNoms[$index] . ' ' . $dateStr . '</div>';

        // Entrée
        if (!empty($menus[$jour]['entree'])) {
            $html .= '<div class="plat"><strong>E:</strong> ' . htmlspecialchars($menus[$jour]['entree']);
            if (isset($menus[$jour]['options']['entree'])) {
                if (in_array('allergenes', $menus[$jour]['options']['entree']) && !empty($menus[$jour]['allergenes']['entree'])) {
                    $html .= ' <span class="allergenes">(' . implode(', ', $menus[$jour]['allergenes']['entree']) . ')</span>';
                }
            }
            $html .= '</div>';
        }

        // Plat principal
        if (!empty($menus[$jour]['plat'])) {
            $html .= '<div class="plat"><strong>P:</strong> ' . htmlspecialchars($menus[$jour]['plat']);
            if (isset($menus[$jour]['options']['plat'])) {
                if (in_array('allergenes', $menus[$jour]['options']['plat']) && !empty($menus[$jour]['allergenes']['plat'])) {
                    $html .= ' <span class="allergenes">(' . implode(', ', $menus[$jour]['allergenes']['plat']) . ')</span>';
                }
            }
            $html .= '</div>';
        }

        // Accompagnement
        if (!empty($menus[$jour]['accompagnement'])) {
            $html .= '<div class="plat"><strong>A:</strong> ' . htmlspecialchars($menus[$jour]['accompagnement']);
            if (isset($menus[$jour]['options']['accompagnement'])) {
                if (in_array('allergenes', $menus[$jour]['options']['accompagnement']) && !empty($menus[$jour]['allergenes']['accompagnement'])) {
                    $html .= ' <span class="allergenes">(' . implode(', ', $menus[$jour]['allergenes']['accompagnement']) . ')</span>';
                }
            }
            $html .= '</div>';
        }

        // Laitage
        if (!empty($menus[$jour]['laitage'])) {
            $html .= '<div class="plat"><strong>L:</strong> ' . htmlspecialchars($menus[$jour]['laitage']);
            if (isset($menus[$jour]['options']['laitage'])) {
                if (in_array('allergenes', $menus[$jour]['options']['laitage']) && !empty($menus[$jour]['allergenes']['laitage'])) {
                    $html .= ' <span class="allergenes">(' . implode(', ', $menus[$jour]['allergenes']['laitage']) . ')</span>';
                }
            }
            $html .= '</div>';
        }

        // Dessert
        if (!empty($menus[$jour]['dessert'])) {
            $html .= '<div class="plat"><strong>D:</strong> ' . htmlspecialchars($menus[$jour]['dessert']);
            if (isset($menus[$jour]['options']['dessert'])) {
                if (in_array('allergenes', $menus[$jour]['options']['dessert']) && !empty($menus[$jour]['allergenes']['dessert'])) {
                    $html .= ' <span class="allergenes">(' . implode(', ', $menus[$jour]['allergenes']['dessert']) . ')</span>';
                }
            }
            $html .= '</div>';
        }

        $html .= '</div>';
    }
}

$html .= '<div class="note">Menu sous réserve de modifications selon les approvisionnements</div>
</div>';

// Générer le PDF
$mpdf->WriteHTML($html);

// Définir le nom du fichier
$filename = "Menu_Semaine_{$semaine['numero_semaine']}_{$semaine['annee']}.pdf";

// Output le PDF
$mpdf->Output($filename, 'D');
