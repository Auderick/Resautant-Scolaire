<?php

require_once __DIR__ . '/../src/Models/menu.php';

header('Content-Type: application/json');

// Si un ID est fourni, récupérer une semaine spécifique
if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $menuModel = new Menu();
    $semaine = $menuModel->getSemaine($id);

    if (!$semaine) {
        http_response_code(404);
        echo json_encode(['error' => 'Semaine non trouvée']);
        exit;
    }

    $menusSemaine = $menuModel->getMenusSemaine($id);
    $menus = [];

    foreach ($menusSemaine as $menuJour) {
        $jour = $menuJour['jour'];

        // S'assurer que les options sont correctement formatées
        // Même logique que dans download.php pour gérer les formats différents
        if (is_array($menuJour['options'])) {
            $options = $menuJour['options'];
        } elseif (!empty($menuJour['options']) && is_string($menuJour['options']) && substr($menuJour['options'], 0, 1) === '{') {
            $options = json_decode($menuJour['options'], true);
        } elseif (!empty($menuJour['options'])) {
            $optionsValue = explode(',', $menuJour['options']);
            $options = ['plat' => $optionsValue];
        } else {
            $options = [];
        }

        // Même chose pour les allergènes
        if (is_array($menuJour['allergenes'])) {
            $allergenes = $menuJour['allergenes'];
        } elseif (!empty($menuJour['allergenes']) && is_string($menuJour['allergenes']) && substr($menuJour['allergenes'], 0, 1) === '{') {
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

    echo json_encode([
        'semaine' => $semaine,
        'menus' => $menus
    ]);
    exit;
}

// Si aucun ID n'est fourni, retourner la liste des semaines
$menuModel = new Menu();
$semaines = $menuModel->getAllSemaines();
echo json_encode(['semaines' => $semaines]);
