<?php

require_once __DIR__ . '/../../src/Models/menu.php';
require_once __DIR__ . '/../../vendor/autoload.php';

// Fonction utilitaire pour formater la liste des allergènes
function formatAllergenesList($allergenes)
{
    if (empty($allergenes)) {
        return '';
    }

    $allergenesList = [];
    foreach ($allergenes as $allergene) {
        switch ($allergene) {
            case 'lait': $allergenesList[] = 'Lait';
                break;
            case 'oeufs': $allergenesList[] = 'Œufs';
                break;
            case 'gluten': $allergenesList[] = 'Gluten';
                break;
            case 'arachides': $allergenesList[] = 'Arachides';
                break;
            case 'fruits_a_coque': $allergenesList[] = 'Fruits à coque';
                break;
            case 'crustaces': $allergenesList[] = 'Crustacés';
                break;
            case 'poisson': $allergenesList[] = 'Poisson';
                break;
            case 'soja': $allergenesList[] = 'Soja';
                break;
            case 'celeri': $allergenesList[] = 'Céleri';
                break;
            case 'moutarde': $allergenesList[] = 'Moutarde';
                break;
            case 'sesame': $allergenesList[] = 'Sésame';
                break;
            case 'sulfites': $allergenesList[] = 'Sulfites';
                break;
            case 'lupin': $allergenesList[] = 'Lupin';
                break;
            case 'mollusques': $allergenesList[] = 'Mollusques';
                break;
            default: $allergenesList[] = ucfirst($allergene);
                break;
        }
    }

    return !empty($allergenesList) ? '<span class="allergenes">(' . implode(', ', $allergenesList) . ')</span>' : '';
}

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

    // Traitement des options et allergènes
    if (is_array($menuJour['options'])) {
        $options = $menuJour['options'];
    } elseif (!empty($menuJour['options']) && is_string($menuJour['options'])) {
        $options = json_decode($menuJour['options'], true);
    } elseif (!empty($menuJour['options'])) {
        $optionsValue = explode(',', $menuJour['options']);
        $options = ['plat' => $optionsValue];
    } else {
        $options = [];
    }

    if (is_array($menuJour['allergenes'])) {
        $allergenes = $menuJour['allergenes'];
    } elseif (!empty($menuJour['allergenes']) && is_string($menuJour['allergenes'])) {
        $allergenes = json_decode($menuJour['allergenes'], true);
    } else {
        $allergenes = [];
    }

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

// Préparer les jours et leur nom pour l'affichage
$jours = ['lundi', 'mardi', 'jeudi', 'vendredi'];
$joursNoms = ['Lundi', 'Mardi', 'Jeudi', 'Vendredi'];

// Construire le contenu HTML pour le PDF
$html = '
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Menu - Semaine ' . $semaine['numero_semaine'] . '</title>
    <style>
        body {
            font-family: "Comic Sans MS", cursive, sans-serif;
            margin: 0;
            padding: 0;
            background-color: white;
        }
        
        .menu-container {
            max-width: 100%;
            margin: 0 auto;
            background-color: white;
            padding: 15px;
        }
        
        .header {
            background-color: #2b76c0;
            color: white;
            padding: 15px;
            border-radius: 15px;
            margin-bottom: 15px;
            text-align: center;
        }
        
        .header h1, .header p {
            color: white;
            margin: 5px 0;
        }
        
        h1 {
            color: #70b1f2;
            text-align: center;
            font-size: 20pt;
            margin: 15px 0;
        }
        
        h2 {
            color: #4a90e2;
            text-align: center;
            font-size: 16pt;
            margin: 10px 0;
        }
        
        .jour {
            margin-bottom: 20px;
            border: 2px solid #87ceeb;
            border-radius: 10px;
            padding: 10px;
        }
        
        .jour-titre {
            color: #4a90e2;
            border-bottom: 2px dashed #87ceeb;
            padding-bottom: 5px;
            font-size: 14pt;
            font-weight: bold;
            margin-bottom: 10px;
        }
        
        .plat {
            margin: 8px 0;
            padding: 5px;
        }
        
        .dessert {
            color: #e67e22;
        }
        
        .vegetarien {
            color: #27ae60;
            font-style: italic;
        }
        
        .allergenes {
            color: #e74c3c;
            font-weight: bold;
            display: block;
            margin-top: 3px;
            font-size: 9pt;
        }
        
        .legende {
            margin-top: 20px;
            padding: 10px;
            background-color: #f5f5f5;
            border-radius: 10px;
        }
        
        .legende h3 {
            margin: 5px 0;
            color: #4a90e2;
            font-size: 12pt;
        }
        
        .symboles {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            justify-content: center;
        }
        
        .symboles span {
            background-color: white;
            padding: 5px 10px;
            border-radius: 5px;
            margin: 5px;
        }
        
        .note {
            text-align: center;
            font-style: italic;
            margin-top: 20px;
            font-size: 10pt;
        }
        
        .icon-texte {
            display: inline-block;
            font-weight: bold;
            margin-right: 3px;
        }
        .icon-vege {
            color: #27ae60;
        }
        .icon-local {
            color: #3498db;
        }
        .icon-bio {
            color: #27ae60;
        }
        .icon-warning {
            color: #e74c3c;
        }
    </style>
</head>
<body>
    <div class="menu-container">
        <!-- En-tête -->
        <div class="header">
            <h1>École de Leignes sur Fontaine</h1>
            <p>Tél: 05.49.56.90.10 | Service: 11h30 - 13h30</p>
        </div>
        
        <h1>Menu de la Semaine ' . $semaine['numero_semaine'] . '</h1>
        <h2>Du ' . date('d/m/Y', strtotime($semaine['date_debut'])) . ' au ' . date('d/m/Y', strtotime($semaine['date_fin'])) . '</h2>
        <h2>Le Chef vous propose</h2>';

// Parcourir chaque jour et générer son contenu
foreach ($jours as $index => $jour) {
    if (isset($menus[$jour]) && !empty($menus[$jour]['plat'])) {
        // Calculer la date pour ce jour
        $jourDate = new DateTime($semaine['date_debut']);
        $jourDate->modify("+$index day");
        $dateStr = $jourDate->format('d/m');

        $html .= '
        <div class="jour">
            <div class="jour-titre">' . $joursNoms[$index] . ' ' . $dateStr . '</div>';

        // Entrée
        if (!empty($menus[$jour]['entree'])) {
            $entree = htmlspecialchars($menus[$jour]['entree']);
            $icones = '';
            $allergeneInfo = '';

            // Vérifier les options pour l'entrée
            if (isset($menus[$jour]['options']['entree'])) {
                if (in_array('vegetarien', $menus[$jour]['options']['entree'])) {
                    $icones .= '<span class="icon-texte icon-vege">(V)</span>';
                }
                if (in_array('local', $menus[$jour]['options']['entree'])) {
                    $icones .= '<span class="icon-texte icon-local">(L)</span>';
                }
                if (in_array('bio', $menus[$jour]['options']['entree'])) {
                    $icones .= '<span class="icon-texte icon-bio">(B)</span>';
                }
                // Traiter les allergènes
                if (in_array('allergenes', $menus[$jour]['options']['entree'])) {
                    $icones .= '<span class="icon-texte icon-warning">(!)</span>';

                    // Informations sur les allergènes
                    if (isset($menus[$jour]['allergenes']['entree']) && !empty($menus[$jour]['allergenes']['entree'])) {
                        $allergeneInfo = '<span class="allergenes">(Allergènes: ' . implode(', ', $menus[$jour]['allergenes']['entree']) . ')</span>';
                    }
                }
            }

            $html .= '
            <div class="plat">
                Entrée: ' . $entree . ' ' . $icones . '
                ' . $allergeneInfo . '
            </div>';
        }

        // Plat principal
        if (!empty($menus[$jour]['plat'])) {
            $plat = htmlspecialchars($menus[$jour]['plat']);
            $icones = '';
            $allergeneInfo = '';

            // Options du plat
            if (isset($menus[$jour]['options']['plat'])) {
                if (in_array('vegetarien', $menus[$jour]['options']['plat'])) {
                    $icones .= '<span class="icon-texte icon-vege">(V)</span>';
                }
                if (in_array('local', $menus[$jour]['options']['plat'])) {
                    $icones .= '<span class="icon-texte icon-local">(L)</span>';
                }
                if (in_array('bio', $menus[$jour]['options']['plat'])) {
                    $icones .= '<span class="icon-texte icon-bio">(B)</span>';
                }
                // Traiter les allergènes
                if (in_array('allergenes', $menus[$jour]['options']['plat'])) {
                    $icones .= '<span class="icon-texte icon-warning">(!)</span>';

                    // Informations sur les allergènes
                    if (isset($menus[$jour]['allergenes']['plat']) && !empty($menus[$jour]['allergenes']['plat'])) {
                        $allergeneInfo = '<span class="allergenes">(Allergènes: ' . implode(', ', $menus[$jour]['allergenes']['plat']) . ')</span>';
                    }
                }
            }

            $html .= '
            <div class="plat">
                Plat: ' . $plat . ' ' . $icones . '
                ' . $allergeneInfo . '
            </div>';
        }

        // Accompagnement
        if (!empty($menus[$jour]['accompagnement'])) {
            $accompagnement = htmlspecialchars($menus[$jour]['accompagnement']);
            $icones = '';
            $allergeneInfo = '';

            // Options pour l'accompagnement
            if (isset($menus[$jour]['options']['accompagnement'])) {
                if (in_array('vegetarien', $menus[$jour]['options']['accompagnement'])) {
                    $icones .= '<span class="icon-texte icon-vege">(V)</span>';
                }
                if (in_array('local', $menus[$jour]['options']['accompagnement'])) {
                    $icones .= '<span class="icon-texte icon-local">(L)</span>';
                }
                if (in_array('bio', $menus[$jour]['options']['accompagnement'])) {
                    $icones .= '<span class="icon-texte icon-bio">(B)</span>';
                }
                // Traiter les allergènes
                if (in_array('allergenes', $menus[$jour]['options']['accompagnement'])) {
                    $icones .= '<span class="icon-texte icon-warning">(!)</span>';

                    // Informations sur les allergènes
                    if (isset($menus[$jour]['allergenes']['accompagnement']) && !empty($menus[$jour]['allergenes']['accompagnement'])) {
                        $allergeneInfo = '<span class="allergenes">(Allergènes: ' . implode(', ', $menus[$jour]['allergenes']['accompagnement']) . ')</span>';
                    }
                }
            }

            $html .= '
            <div class="plat">
                Accompagnement: ' . $accompagnement . ' ' . $icones . '
                ' . $allergeneInfo . '
            </div>';
        }

        // Laitage
        if (!empty($menus[$jour]['laitage'])) {
            $laitage = htmlspecialchars($menus[$jour]['laitage']);
            $icones = '';
            $allergeneInfo = '';

            // Options pour le laitage
            if (isset($menus[$jour]['options']['laitage'])) {
                if (in_array('vegetarien', $menus[$jour]['options']['laitage'])) {
                    $icones .= '<span class="icon-texte icon-vege">(V)</span>';
                }
                if (in_array('local', $menus[$jour]['options']['laitage'])) {
                    $icones .= '<span class="icon-texte icon-local">(L)</span>';
                }
                if (in_array('bio', $menus[$jour]['options']['laitage'])) {
                    $icones .= '<span class="icon-texte icon-bio">(B)</span>';
                }
                // Traiter les allergènes
                if (in_array('allergenes', $menus[$jour]['options']['laitage'])) {
                    $icones .= '<span class="icon-texte icon-warning">(!)</span>';

                    // Informations sur les allergènes
                    if (isset($menus[$jour]['allergenes']['laitage']) && !empty($menus[$jour]['allergenes']['laitage'])) {
                        $allergeneInfo = '<span class="allergenes">(Allergènes: ' . implode(', ', $menus[$jour]['allergenes']['laitage']) . ')</span>';
                    }
                }
            }

            $html .= '
            <div class="plat">
                Laitage: ' . $laitage . ' ' . $icones . '
                ' . $allergeneInfo . '
            </div>';
        }

        // Dessert
        if (!empty($menus[$jour]['dessert'])) {
            $dessert = htmlspecialchars($menus[$jour]['dessert']);
            $icones = '';
            $allergeneInfo = '';

            // Options pour le dessert
            if (isset($menus[$jour]['options']['dessert'])) {
                if (in_array('vegetarien', $menus[$jour]['options']['dessert'])) {
                    $icones .= '<span class="icon-texte icon-vege">(V)</span>';
                }
                if (in_array('local', $menus[$jour]['options']['dessert'])) {
                    $icones .= '<span class="icon-texte icon-local">(L)</span>';
                }
                if (in_array('bio', $menus[$jour]['options']['dessert'])) {
                    $icones .= '<span class="icon-texte icon-bio">(B)</span>';
                }
                // Traiter les allergènes
                if (in_array('allergenes', $menus[$jour]['options']['dessert'])) {
                    $icones .= '<span class="icon-texte icon-warning">(!)</span>';

                    // Informations sur les allergènes
                    if (isset($menus[$jour]['allergenes']['dessert']) && !empty($menus[$jour]['allergenes']['dessert'])) {
                        $allergeneInfo = '<span class="allergenes">(Allergènes: ' . implode(', ', $menus[$jour]['allergenes']['dessert']) . ')</span>';
                    }
                }
            }

            $html .= '
            <div class="plat dessert">
                Dessert: ' . $dessert . ' ' . $icones . '
                ' . $allergeneInfo . '
            </div>';
        }

        $html .= '
        </div>';
    }
}

$html .= '
        <!-- Légende -->
        <div class="legende">
            <h3>Légende</h3>
            <div class="symboles">
                <span><span class="icon-texte icon-vege">(V)</span> Végétarien</span>
                <span><span class="icon-texte icon-warning">(!)</span> Allergènes</span>
                <span><span class="icon-texte icon-local">(L)</span> Produit local</span>
                <span><span class="icon-texte icon-bio">(B)</span> Bio</span>
            </div>
        </div>
        
        <div class="note">
            Menu sous réserve de modifications selon les approvisionnements
        </div>
    </div>
</body>
</html>';

// Générer le PDF avec mPDF
$mpdf = new \Mpdf\Mpdf([
    'mode' => 'utf-8',
    'format' => 'A4',
    'margin_top' => 10,
    'margin_bottom' => 10,
    'margin_left' => 10,
    'margin_right' => 10,
    'default_font' => 'dejavusans'
]);

$mpdf->WriteHTML($html);

// Définir le nom du fichier de téléchargement
$filename = "Menu_Semaine_{$semaine['numero_semaine']}_{$semaine['annee']}.pdf";

// Output le PDF directement au navigateur pour téléchargement
$mpdf->Output($filename, 'D');
