<?php

require_once __DIR__ . '/../../src/Models/menu.php';

// Traitement du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $menuModel = new Menu();
    $editMode = false; // Initialisation de la variable

    // Traitement des données de la semaine
    $semaineData = [
        'numero_semaine' => $_POST['numero_semaine'],
        'annee' => $_POST['annee'],
        'date_debut' => $_POST['date_debut'],
        'date_fin' => $_POST['date_fin'],
        'active' => isset($_POST['active']) ? 1 : 0
    ];

    // Ajouter l'ID seulement s'il est présent et non vide
    if (!empty($_POST['semaine_id'])) {
        $semaineData['id'] = $_POST['semaine_id'];
        $editMode = true;
    }

    // Enregistrer la semaine
    $semaineId = $menuModel->saveSemaine($semaineData);

    if (empty($semaineId)) {
        die("Erreur : Aucun ID de semaine n'a été retourné!");
    }

    // Traitement des menus pour chaque jour
    $jours = ['lundi', 'mardi', 'jeudi', 'vendredi'];
    foreach ($jours as $jour) {
        if (isset($_POST['menus'][$jour]['plat']) && !empty($_POST['menus'][$jour]['plat'])) {
            $menuData = [
                'id' => $_POST['menus'][$jour]['id'] ?? null,
                'semaine_id' => $semaineId,
                'jour' => $jour,
                'entree' => $_POST['menus'][$jour]['entree'] ?? '',
                'plat' => $_POST['menus'][$jour]['plat'],
                'accompagnement' => $_POST['menus'][$jour]['accompagnement'] ?? '',
                'laitage' => $_POST['menus'][$jour]['laitage'] ?? '',
                'dessert' => $_POST['menus'][$jour]['dessert'] ?? '',
                'options' => $_POST['menus'][$jour]['options'] ?? [],
                'allergenes' => $_POST['menus'][$jour]['allergenes'] ?? []
            ];
            $menuModel->saveMenu($menuData);
        }
    }

    // Si la case "Activer" est cochée, désactiver les autres semaines
    if (isset($_POST['active'])) {
        $menuModel->setActive($semaineId);
    }

    // Redirection
    header('Location: index.php?message=' . ($editMode ? 'Menu modifié' : 'Menu créé') . ' avec succès');
    exit;
}

require_once __DIR__ . '/../../includes/header.php';

$menuModel = new Menu();
$editMode = false;
$semaine = [
    'id' => '',
    'numero_semaine' => '',
    'annee' => date('Y'),
    'date_debut' => '',
    'date_fin' => '',
    'active' => false
];
$menus = [
    'lundi' => ['entree' => '', 'plat' => '', 'accompagnement' => '', 'laitage' => '', 'dessert' => '', 'options' => []],
    'mardi' => ['entree' => '', 'plat' => '', 'accompagnement' => '', 'laitage' => '', 'dessert' => '', 'options' => []],
    'jeudi' => ['entree' => '', 'plat' => '', 'accompagnement' => '', 'laitage' => '', 'dessert' => '', 'options' => []],
    'vendredi' => ['entree' => '', 'plat' => '', 'accompagnement' => '', 'laitage' => '', 'dessert' => '', 'options' => []]
];

// En mode édition, charger les données existantes
if (isset($_GET['id'])) {
    $semaineId = (int)$_GET['id'];
    $semaineData = $menuModel->getSemaine($semaineId);

    if ($semaineData) {
        $editMode = true;
        $semaine = $semaineData;

        // Charger les menus de la semaine
        $menusSemaine = $menuModel->getMenusSemaine($semaineId);
        foreach ($menusSemaine as $menuJour) {
            $jour = $menuJour['jour'];

            if (!empty($menuJour['options'])) {
                if (is_string($menuJour['options'])) {
                    // Format ancien: chaîne CSV
                    $options = explode(',', $menuJour['options']);
                } elseif (is_array($menuJour['options'])) {
                    // Format nouveau: déjà un tableau
                    $options = $menuJour['options'];
                } else {
                    $options = [];
                }
            } else {
                $options = [];
            }

            $allergenes = !empty($menuJour['allergenes']) ? $menuJour['allergenes'] : [];

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
    }
}

// Traitement du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Créer un fichier de log spécial pour les allergènes
    $allergenes_log = "==== " . date('Y-m-d H:i:s') . " - DONNÉES POST FORMULAIRE MENU ====\n";
    $allergenes_log .= print_r($_POST, true) . "\n\n";
    file_put_contents(__DIR__ . '/../../logs/allergenes_debug.log', $allergenes_log, FILE_APPEND);

    // Vérification spécifique des allergènes
    if (isset($_POST['menus'])) {
        $allergenes_details = "==== " . date('Y-m-d H:i:s') . " - DÉTAILS DES ALLERGÈNES ====\n";
        foreach ($_POST['menus'] as $jour => $menuData) {
            $allergenes_details .= "Jour: $jour\n";
            if (isset($menuData['allergenes'])) {
                $allergenes_details .= "Allergènes trouvés: " . print_r($menuData['allergenes'], true) . "\n";
            } else {
                $allergenes_details .= "Aucun allergène trouvé pour ce jour\n";
            }
            $allergenes_details .= "-------------------------------\n";
        }
        file_put_contents(__DIR__ . '/../../logs/allergenes_debug.log', $allergenes_details, FILE_APPEND);
    }

    // Traitement des données de la semaine
    $semaineData = [
        'numero_semaine' => $_POST['numero_semaine'],
        'annee' => $_POST['annee'],
        'date_debut' => $_POST['date_debut'],
        'date_fin' => $_POST['date_fin'],
        'active' => isset($_POST['active']) ? 1 : 0
    ];

    // Ajouter l'ID seulement s'il est présent et non vide
    if (!empty($_POST['semaine_id'])) {
        $semaineData['id'] = $_POST['semaine_id'];
    }    // Enregistrer la semaine
    $semaineId = $menuModel->saveSemaine($semaineData);

    // Si l'ID est vide ou null, il y a un problème avec la méthode saveSemaine
    if (empty($semaineId)) {
        die("Erreur : Aucun ID de semaine n'a été retourné!");
    }

    // Traitement des menus pour chaque jour
    $jours = ['lundi', 'mardi', 'jeudi', 'vendredi'];
    foreach ($jours as $jour) {
        if (isset($_POST['menus'][$jour]['plat']) && !empty($_POST['menus'][$jour]['plat'])) {
            $menuData = [
                'id' => $_POST['menus'][$jour]['id'] ?? null,
                'semaine_id' => $semaineId,
                'jour' => $jour,
                'entree' => $_POST['menus'][$jour]['entree'] ?? '',
                'plat' => $_POST['menus'][$jour]['plat'],
                'accompagnement' => $_POST['menus'][$jour]['accompagnement'] ?? '',
                'laitage' => $_POST['menus'][$jour]['laitage'] ?? '',
                'dessert' => $_POST['menus'][$jour]['dessert'] ?? '',
                'options' => $_POST['menus'][$jour]['options'] ?? [],
                'allergenes' => $_POST['menus'][$jour]['allergenes'] ?? []
            ];

            $menuModel->saveMenu($menuData);
        }
    }

    // Si la case "Activer" est cochée, désactiver les autres semaines
    if (isset($_POST['active'])) {
        $menuModel->setActive($semaineId);
    }

    // Redirection
    header('Location: index.php?message=' . ($editMode ? 'Menu modifié' : 'Menu créé') . ' avec succès');
    exit;
}


// Calcul du numéro de semaine actuelle

// Calcul du numéro de semaine actuelle pour les valeurs par défaut
$currentWeek = date('W');
$currentYear = date('Y');

// Si vous êtes en mode création, ne définissez que le numéro de semaine et l'année
// Les dates seront calculées par JavaScript
if (!$editMode) {
    $semaine['numero_semaine'] = $currentWeek;
    $semaine['annee'] = $currentYear;
    // Ne pas initialiser les dates pour laisser JavaScript le faire
}
?>

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1><?= $editMode ? 'Modifier' : 'Créer' ?>
            un menu hebdomadaire</h1>
        <a href="index.php" class="btn btn-secondary">Retour à la liste</a>
    </div>

    <form method="post">
        <input type="hidden" name="semaine_id"
            value="<?= $semaine['id'] ?>">

        <!-- Informations sur la semaine -->
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                <h2 class="card-title h5 mb-0">Informations générales</h2>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="numero_semaine" class="form-label">Numéro de semaine</label>
                        <input type="number" class="form-control" id="numero_semaine" name="numero_semaine"
                            value="<?= $semaine['numero_semaine'] ?: $currentWeek ?>"
                            min="1" max="53" required>
                    </div>
                    <div class="col-md-6">
                        <label for="annee" class="form-label">Année</label>
                        <input type="number" class="form-control" id="annee" name="annee"
                            value="<?= $semaine['annee'] ?: $currentYear ?>"
                            min="2020" max="2030" required>
                    </div>
                    <div class="col-md-6">
                        <label for="date_debut" class="form-label">Date de début</label>
                        <input type="date" class="form-control" id="date_debut" name="date_debut"
                            value="<?= $semaine['date_debut'] ?>"
                            required>
                    </div>
                    <div class="col-md-6">
                        <label for="date_fin" class="form-label">Date de fin</label>
                        <input type="date" class="form-control" id="date_fin" name="date_fin"
                            value="<?= $semaine['date_fin'] ?>"
                            required>
                    </div>
                    <div class="col-12">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="active" name="active"
                                <?= $semaine['active'] ? 'checked' : '' ?>>
                            <label class="form-check-label" for="active">
                                Activer cette semaine (sera affichée par défaut)
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Menus des jours -->
        <div class="card mb-4">
            <div class="card-header bg-success text-white">
                <h2 class="card-title h5 mb-0">Menus des jours</h2>
            </div>
            <div class="card-body">
                <ul class="nav nav-tabs" id="menuTabs" role="tablist">
                    <?php
                        $jours = ['lundi', 'mardi', 'jeudi', 'vendredi'];
$joursNoms = ['Lundi', 'Mardi', 'Jeudi', 'Vendredi'];
foreach ($jours as $index => $jour):
    ?>
                    <li class="nav-item" role="presentation">
                        <button
                            class="nav-link <?= $index === 0 ? 'active' : '' ?>"
                            id="<?= $jour ?>-tab"
                            data-bs-toggle="tab"
                            data-bs-target="#<?= $jour ?>-pane"
                            type="button" role="tab">
                            <?= $joursNoms[$index] ?>
                        </button>
                    </li>
                    <?php endforeach; ?>
                </ul>
                <div class="tab-content p-3 border border-top-0 rounded-bottom">
                    <?php foreach ($jours as $index => $jour): ?>
                    <div class="tab-pane fade <?= $index === 0 ? 'show active' : '' ?>"
                        id="<?= $jour ?>-pane" role="tabpanel"
                        tabindex="0">
                        <input type="hidden"
                            name="menus[<?= $jour ?>][id]"
                            value="<?= $menus[$jour]['id'] ?? '' ?>">

                        <div class="row g-3">
                            <!-- ENTRÉE -->
                            <div class="col-md-12">
                                <div class="card mb-3">
                                    <div class="card-header bg-light">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <h5 class="mb-0">Entrée</h5>
                                            <div>
                                                <div class="form-check form-check-inline mb-0">
                                                    <input class="form-check-input" type="checkbox"
                                                        name="menus[<?= $jour ?>][options][entree][]"
                                                        value="vegetarien"
                                                        id="<?= $jour ?>-entree-vegetarien"
                                                        <?= isset($menus[$jour]['options']['entree']) && in_array('vegetarien', $menus[$jour]['options']['entree'] ?? []) ? 'checked' : '' ?>>
                                                    <label class="form-check-label"
                                                        for="<?= $jour ?>-entree-vegetarien">🥬</label>
                                                </div>
                                                <div class="form-check form-check-inline mb-0">
                                                    <input class="form-check-input" type="checkbox"
                                                        name="menus[<?= $jour ?>][options][entree][]"
                                                        value="allergenes"
                                                        id="<?= $jour ?>-entree-allergenes"
                                                        <?= isset($menus[$jour]['options']['entree']) && in_array('allergenes', $menus[$jour]['options']['entree'] ?? []) ? 'checked' : '' ?>
                                                    onclick="toggleAllergenes('<?= $jour ?>-entree-allergenes-details')">
                                                    <label class="form-check-label"
                                                        for="<?= $jour ?>-entree-allergenes">⚠️</label>
                                                </div>
                                                <div class="form-check form-check-inline mb-0">
                                                    <input class="form-check-input" type="checkbox"
                                                        name="menus[<?= $jour ?>][options][entree][]"
                                                        value="local"
                                                        id="<?= $jour ?>-entree-local"
                                                        <?= isset($menus[$jour]['options']['entree']) && in_array('local', $menus[$jour]['options']['entree'] ?? []) ? 'checked' : '' ?>>
                                                    <label class="form-check-label"
                                                        for="<?= $jour ?>-entree-local">🌟</label>
                                                </div>
                                                <div class="form-check form-check-inline mb-0">
                                                    <input class="form-check-input" type="checkbox"
                                                        name="menus[<?= $jour ?>][options][entree][]"
                                                        value="bio"
                                                        id="<?= $jour ?>-entree-bio"
                                                        <?= isset($menus[$jour]['options']['entree']) && in_array('bio', $menus[$jour]['options']['entree'] ?? []) ? 'checked' : '' ?>>
                                                    <label class="form-check-label"
                                                        for="<?= $jour ?>-entree-bio">🌱</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <input type="text" class="form-control"
                                            name="menus[<?= $jour ?>][entree]"
                                            value="<?= htmlspecialchars($menus[$jour]['entree'] ?? '') ?>">

                                        <div id="<?= $jour ?>-entree-allergenes-details"
                                            class="mt-2"
                                            style="display: <?= isset($menus[$jour]['options']['entree']) && in_array('allergenes', $menus[$jour]['options']['entree'] ?? []) ? 'block' : 'none' ?>;">
                                            <label class="form-label">Sélectionnez les allergènes :</label>
                                            <select class="form-control select-allergenes"
                                                name="menus[<?= $jour ?>][allergenes][entree][]"
                                                multiple="multiple" data-placeholder="Choisir les allergènes présents">
                                                <option value="lait" <?= isset($menus[$jour]['allergenes']['entree']) && in_array('lait', $menus[$jour]['allergenes']['entree'] ?? []) ? 'selected' : '' ?>>Lait
                                                </option>
                                                <option value="oeufs" <?= isset($menus[$jour]['allergenes']['entree']) && in_array('oeufs', $menus[$jour]['allergenes']['entree'] ?? []) ? 'selected' : '' ?>>Œufs
                                                </option>
                                                <option value="gluten" <?= isset($menus[$jour]['allergenes']['entree']) && in_array('gluten', $menus[$jour]['allergenes']['entree'] ?? []) ? 'selected' : '' ?>>Gluten
                                                </option>
                                                <option value="arachides" <?= isset($menus[$jour]['allergenes']['entree']) && in_array('arachides', $menus[$jour]['allergenes']['entree'] ?? []) ? 'selected' : '' ?>>Arachides
                                                </option>
                                                <option value="fruits_a_coque" <?= isset($menus[$jour]['allergenes']['entree']) && in_array('fruits_a_coque', $menus[$jour]['allergenes']['entree'] ?? []) ? 'selected' : '' ?>>Fruits
                                                    à coque</option>
                                                <option value="crustaces" <?= isset($menus[$jour]['allergenes']['entree']) && in_array('crustaces', $menus[$jour]['allergenes']['entree'] ?? []) ? 'selected' : '' ?>>Crustacés
                                                </option>
                                                <option value="poisson" <?= isset($menus[$jour]['allergenes']['entree']) && in_array('poisson', $menus[$jour]['allergenes']['entree'] ?? []) ? 'selected' : '' ?>>Poisson
                                                </option>
                                                <option value="soja" <?= isset($menus[$jour]['allergenes']['entree']) && in_array('soja', $menus[$jour]['allergenes']['entree'] ?? []) ? 'selected' : '' ?>>Soja
                                                </option>
                                                <option value="celeri" <?= isset($menus[$jour]['allergenes']['entree']) && in_array('celeri', $menus[$jour]['allergenes']['entree'] ?? []) ? 'selected' : '' ?>>Céleri
                                                </option>
                                                <option value="moutarde" <?= isset($menus[$jour]['allergenes']['entree']) && in_array('moutarde', $menus[$jour]['allergenes']['entree'] ?? []) ? 'selected' : '' ?>>Moutarde
                                                </option>
                                                <option value="sesame" <?= isset($menus[$jour]['allergenes']['entree']) && in_array('sesame', $menus[$jour]['allergenes']['entree'] ?? []) ? 'selected' : '' ?>>Sésame
                                                </option>
                                                <option value="sulfites" <?= isset($menus[$jour]['allergenes']['entree']) && in_array('sulfites', $menus[$jour]['allergenes']['entree'] ?? []) ? 'selected' : '' ?>>Sulfites
                                                </option>
                                                <option value="lupin" <?= isset($menus[$jour]['allergenes']['entree']) && in_array('lupin', $menus[$jour]['allergenes']['entree'] ?? []) ? 'selected' : '' ?>>Lupin
                                                </option>
                                                <option value="mollusques" <?= isset($menus[$jour]['allergenes']['entree']) && in_array('mollusques', $menus[$jour]['allergenes']['entree'] ?? []) ? 'selected' : '' ?>>Mollusques
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- PLAT PRINCIPAL -->
                            <div class="col-md-12">
                                <div class="card mb-3">
                                    <div class="card-header bg-light">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <h5 class="mb-0">Plat principal</h5>
                                            <div>
                                                <div class="form-check form-check-inline mb-0">
                                                    <input class="form-check-input" type="checkbox"
                                                        name="menus[<?= $jour ?>][options][plat][]"
                                                        value="vegetarien"
                                                        id="<?= $jour ?>-plat-vegetarien"
                                                        <?= isset($menus[$jour]['options']['plat']) && in_array('vegetarien', $menus[$jour]['options']['plat'] ?? []) ? 'checked' : '' ?>>
                                                    <label class="form-check-label"
                                                        for="<?= $jour ?>-plat-vegetarien">🥬</label>
                                                </div>
                                                <div class="form-check form-check-inline mb-0">
                                                    <input class="form-check-input" type="checkbox"
                                                        name="menus[<?= $jour ?>][options][plat][]"
                                                        value="allergenes"
                                                        id="<?= $jour ?>-plat-allergenes"
                                                        <?= isset($menus[$jour]['options']['plat']) && in_array('allergenes', $menus[$jour]['options']['plat'] ?? []) ? 'checked' : '' ?>
                                                    onclick="toggleAllergenes('<?= $jour ?>-plat-allergenes-details')">
                                                    <label class="form-check-label"
                                                        for="<?= $jour ?>-plat-allergenes">⚠️</label>
                                                </div>
                                                <div class="form-check form-check-inline mb-0">
                                                    <input class="form-check-input" type="checkbox"
                                                        name="menus[<?= $jour ?>][options][plat][]"
                                                        value="local"
                                                        id="<?= $jour ?>-plat-local"
                                                        <?= isset($menus[$jour]['options']['plat']) && in_array('local', $menus[$jour]['options']['plat'] ?? []) ? 'checked' : '' ?>>
                                                    <label class="form-check-label"
                                                        for="<?= $jour ?>-plat-local">🌟</label>
                                                </div>
                                                <div class="form-check form-check-inline mb-0">
                                                    <input class="form-check-input" type="checkbox"
                                                        name="menus[<?= $jour ?>][options][plat][]"
                                                        value="bio"
                                                        id="<?= $jour ?>-plat-bio"
                                                        <?= isset($menus[$jour]['options']['plat']) && in_array('bio', $menus[$jour]['options']['plat'] ?? []) ? 'checked' : '' ?>>
                                                    <label class="form-check-label"
                                                        for="<?= $jour ?>-plat-bio">🌱</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <input type="text" class="form-control"
                                            name="menus[<?= $jour ?>][plat]"
                                            value="<?= htmlspecialchars($menus[$jour]['plat'] ?? '') ?>">

                                        <div id="<?= $jour ?>-plat-allergenes-details"
                                            class="mt-2"
                                            style="display: <?= isset($menus[$jour]['options']['plat']) && in_array('allergenes', $menus[$jour]['options']['plat'] ?? []) ? 'block' : 'none' ?>;">
                                            <label class="form-label">Sélectionnez les allergènes :</label>
                                            <select class="form-control select-allergenes"
                                                name="menus[<?= $jour ?>][allergenes][plat][]"
                                                multiple="multiple" data-placeholder="Choisir les allergènes présents">
                                                <option value="lait" <?= isset($menus[$jour]['allergenes']['plat']) && in_array('lait', $menus[$jour]['allergenes']['plat'] ?? []) ? 'selected' : '' ?>>Lait
                                                </option>
                                                <option value="oeufs" <?= isset($menus[$jour]['allergenes']['plat']) && in_array('oeufs', $menus[$jour]['allergenes']['plat'] ?? []) ? 'selected' : '' ?>>Œufs
                                                </option>
                                                <option value="gluten" <?= isset($menus[$jour]['allergenes']['plat']) && in_array('gluten', $menus[$jour]['allergenes']['plat'] ?? []) ? 'selected' : '' ?>>Gluten
                                                </option>
                                                <option value="arachides" <?= isset($menus[$jour]['allergenes']['plat']) && in_array('arachides', $menus[$jour]['allergenes']['plat'] ?? []) ? 'selected' : '' ?>>Arachides
                                                </option>
                                                <option value="fruits_a_coque" <?= isset($menus[$jour]['allergenes']['plat']) && in_array('fruits_a_coque', $menus[$jour]['allergenes']['plat'] ?? []) ? 'selected' : '' ?>>Fruits
                                                    à coque</option>
                                                <option value="crustaces" <?= isset($menus[$jour]['allergenes']['plat']) && in_array('crustaces', $menus[$jour]['allergenes']['plat'] ?? []) ? 'selected' : '' ?>>Crustacés
                                                </option>
                                                <option value="poisson" <?= isset($menus[$jour]['allergenes']['plat']) && in_array('poisson', $menus[$jour]['allergenes']['plat'] ?? []) ? 'selected' : '' ?>>Poisson
                                                </option>
                                                <option value="soja" <?= isset($menus[$jour]['allergenes']['plat']) && in_array('soja', $menus[$jour]['allergenes']['plat'] ?? []) ? 'selected' : '' ?>>Soja
                                                </option>
                                                <option value="celeri" <?= isset($menus[$jour]['allergenes']['plat']) && in_array('celeri', $menus[$jour]['allergenes']['plat'] ?? []) ? 'selected' : '' ?>>Céleri
                                                </option>
                                                <option value="moutarde" <?= isset($menus[$jour]['allergenes']['plat']) && in_array('moutarde', $menus[$jour]['allergenes']['plat'] ?? []) ? 'selected' : '' ?>>Moutarde
                                                </option>
                                                <option value="sesame" <?= isset($menus[$jour]['allergenes']['plat']) && in_array('sesame', $menus[$jour]['allergenes']['plat'] ?? []) ? 'selected' : '' ?>>Sésame
                                                </option>
                                                <option value="sulfites" <?= isset($menus[$jour]['allergenes']['plat']) && in_array('sulfites', $menus[$jour]['allergenes']['plat'] ?? []) ? 'selected' : '' ?>>Sulfites
                                                </option>
                                                <option value="lupin" <?= isset($menus[$jour]['allergenes']['plat']) && in_array('lupin', $menus[$jour]['allergenes']['plat'] ?? []) ? 'selected' : '' ?>>Lupin
                                                </option>
                                                <option value="mollusques" <?= isset($menus[$jour]['allergenes']['plat']) && in_array('mollusques', $menus[$jour]['allergenes']['plat'] ?? []) ? 'selected' : '' ?>>Mollusques
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- ACCOMPAGNEMENT -->
                            <div class="col-md-12">
                                <div class="card mb-3">
                                    <div class="card-header bg-light">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <h5 class="mb-0">Accompagnement</h5>
                                            <div>
                                                <div class="form-check form-check-inline mb-0">
                                                    <input class="form-check-input" type="checkbox"
                                                        name="menus[<?= $jour ?>][options][accompagnement][]"
                                                        value="vegetarien"
                                                        id="<?= $jour ?>-accompagnement-vegetarien"
                                                        <?= isset($menus[$jour]['options']['accompagnement']) && in_array('vegetarien', $menus[$jour]['options']['accompagnement'] ?? []) ? 'checked' : '' ?>>
                                                    <label class="form-check-label"
                                                        for="<?= $jour ?>-accompagnement-vegetarien">🥬</label>
                                                </div>
                                                <div class="form-check form-check-inline mb-0">
                                                    <input class="form-check-input" type="checkbox"
                                                        name="menus[<?= $jour ?>][options][accompagnement][]"
                                                        value="allergenes"
                                                        id="<?= $jour ?>-accompagnement-allergenes"
                                                        <?= isset($menus[$jour]['options']['accompagnement']) && in_array('allergenes', $menus[$jour]['options']['accompagnement'] ?? []) ? 'checked' : '' ?>
                                                    onclick="toggleAllergenes('<?= $jour ?>-accompagnement-allergenes-details')">
                                                    <label class="form-check-label"
                                                        for="<?= $jour ?>-accompagnement-allergenes">⚠️</label>
                                                </div>
                                                <div class="form-check form-check-inline mb-0">
                                                    <input class="form-check-input" type="checkbox"
                                                        name="menus[<?= $jour ?>][options][accompagnement][]"
                                                        value="local"
                                                        id="<?= $jour ?>-accompagnement-local"
                                                        <?= isset($menus[$jour]['options']['accompagnement']) && in_array('local', $menus[$jour]['options']['accompagnement'] ?? []) ? 'checked' : '' ?>>
                                                    <label class="form-check-label"
                                                        for="<?= $jour ?>-accompagnement-local">🌟</label>
                                                </div>
                                                <div class="form-check form-check-inline mb-0">
                                                    <input class="form-check-input" type="checkbox"
                                                        name="menus[<?= $jour ?>][options][accompagnement][]"
                                                        value="bio"
                                                        id="<?= $jour ?>-accompagnement-bio"
                                                        <?= isset($menus[$jour]['options']['accompagnement']) && in_array('bio', $menus[$jour]['options']['accompagnement'] ?? []) ? 'checked' : '' ?>>
                                                    <label class="form-check-label"
                                                        for="<?= $jour ?>-accompagnement-bio">🌱</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <input type="text" class="form-control"
                                            name="menus[<?= $jour ?>][accompagnement]"
                                            value="<?= htmlspecialchars($menus[$jour]['accompagnement'] ?? '') ?>">

                                        <div id="<?= $jour ?>-accompagnement-allergenes-details"
                                            class="mt-2"
                                            style="display: <?= isset($menus[$jour]['options']['accompagnement']) && in_array('allergenes', $menus[$jour]['options']['accompagnement'] ?? []) ? 'block' : 'none' ?>;">
                                            <label class="form-label">Sélectionnez les allergènes :</label>
                                            <select class="form-control select-allergenes"
                                                name="menus[<?= $jour ?>][allergenes][accompagnement][]"
                                                multiple="multiple" data-placeholder="Choisir les allergènes présents">
                                                <option value="lait" <?= isset($menus[$jour]['allergenes']['accompagnement']) && in_array('lait', $menus[$jour]['allergenes']['accompagnement'] ?? []) ? 'selected' : '' ?>>Lait
                                                </option>
                                                <option value="oeufs" <?= isset($menus[$jour]['allergenes']['accompagnement']) && in_array('oeufs', $menus[$jour]['allergenes']['accompagnement'] ?? []) ? 'selected' : '' ?>>Œufs
                                                </option>
                                                <option value="gluten" <?= isset($menus[$jour]['allergenes']['accompagnement']) && in_array('gluten', $menus[$jour]['allergenes']['accompagnement'] ?? []) ? 'selected' : '' ?>>Gluten
                                                </option>
                                                <option value="arachides" <?= isset($menus[$jour]['allergenes']['accompagnement']) && in_array('arachides', $menus[$jour]['allergenes']['accompagnement'] ?? []) ? 'selected' : '' ?>>Arachides
                                                </option>
                                                <option value="fruits_a_coque" <?= isset($menus[$jour]['allergenes']['accompagnement']) && in_array('fruits_a_coque', $menus[$jour]['allergenes']['accompagnement'] ?? []) ? 'selected' : '' ?>>Fruits
                                                    à coque</option>
                                                <option value="crustaces" <?= isset($menus[$jour]['allergenes']['accompagnement']) && in_array('crustaces', $menus[$jour]['allergenes']['accompagnement'] ?? []) ? 'selected' : '' ?>>Crustacés
                                                </option>
                                                <option value="poisson" <?= isset($menus[$jour]['allergenes']['accompagnement']) && in_array('poisson', $menus[$jour]['allergenes']['accompagnement'] ?? []) ? 'selected' : '' ?>>Poisson
                                                </option>
                                                <option value="soja" <?= isset($menus[$jour]['allergenes']['accompagnement']) && in_array('soja', $menus[$jour]['allergenes']['accompagnement'] ?? []) ? 'selected' : '' ?>>Soja
                                                </option>
                                                <option value="celeri" <?= isset($menus[$jour]['allergenes']['accompagnement']) && in_array('celeri', $menus[$jour]['allergenes']['accompagnement'] ?? []) ? 'selected' : '' ?>>Céleri
                                                </option>
                                                <option value="moutarde" <?= isset($menus[$jour]['allergenes']['accompagnement']) && in_array('moutarde', $menus[$jour]['allergenes']['accompagnement'] ?? []) ? 'selected' : '' ?>>Moutarde
                                                </option>
                                                <option value="sesame" <?= isset($menus[$jour]['allergenes']['accompagnement']) && in_array('sesame', $menus[$jour]['allergenes']['accompagnement'] ?? []) ? 'selected' : '' ?>>Sésame
                                                </option>
                                                <option value="sulfites" <?= isset($menus[$jour]['allergenes']['accompagnement']) && in_array('sulfites', $menus[$jour]['allergenes']['accompagnement'] ?? []) ? 'selected' : '' ?>>Sulfites
                                                </option>
                                                <option value="lupin" <?= isset($menus[$jour]['allergenes']['accompagnement']) && in_array('lupin', $menus[$jour]['allergenes']['accompagnement'] ?? []) ? 'selected' : '' ?>>Lupin
                                                </option>
                                                <option value="mollusques" <?= isset($menus[$jour]['allergenes']['accompagnement']) && in_array('mollusques', $menus[$jour]['allergenes']['accompagnement'] ?? []) ? 'selected' : '' ?>>Mollusques
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- LAITAGE -->
                            <div class="col-md-12">
                                <div class="card mb-3">
                                    <div class="card-header bg-light">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <h5 class="mb-0">Laitage</h5>
                                            <div>
                                                <div class="form-check form-check-inline mb-0">
                                                    <input class="form-check-input" type="checkbox"
                                                        name="menus[<?= $jour ?>][options][laitage][]"
                                                        value="vegetarien"
                                                        id="<?= $jour ?>-laitage-vegetarien"
                                                        <?= isset($menus[$jour]['options']['laitage']) && in_array('vegetarien', $menus[$jour]['options']['laitage'] ?? []) ? 'checked' : '' ?>>
                                                    <label class="form-check-label"
                                                        for="<?= $jour ?>-laitage-vegetarien">🥬</label>
                                                </div>
                                                <div class="form-check form-check-inline mb-0">
                                                    <input class="form-check-input" type="checkbox"
                                                        name="menus[<?= $jour ?>][options][laitage][]"
                                                        value="allergenes"
                                                        id="<?= $jour ?>-laitage-allergenes"
                                                        <?= isset($menus[$jour]['options']['laitage']) && in_array('allergenes', $menus[$jour]['options']['laitage'] ?? []) ? 'checked' : '' ?>
                                                    onclick="toggleAllergenes('<?= $jour ?>-laitage-allergenes-details')">
                                                    <label class="form-check-label"
                                                        for="<?= $jour ?>-laitage-allergenes">⚠️</label>
                                                </div>
                                                <div class="form-check form-check-inline mb-0">
                                                    <input class="form-check-input" type="checkbox"
                                                        name="menus[<?= $jour ?>][options][laitage][]"
                                                        value="local"
                                                        id="<?= $jour ?>-laitage-local"
                                                        <?= isset($menus[$jour]['options']['laitage']) && in_array('local', $menus[$jour]['options']['laitage'] ?? []) ? 'checked' : '' ?>>
                                                    <label class="form-check-label"
                                                        for="<?= $jour ?>-laitage-local">🌟</label>
                                                </div>
                                                <div class="form-check form-check-inline mb-0">
                                                    <input class="form-check-input" type="checkbox"
                                                        name="menus[<?= $jour ?>][options][laitage][]"
                                                        value="bio"
                                                        id="<?= $jour ?>-laitage-bio"
                                                        <?= isset($menus[$jour]['options']['laitage']) && in_array('bio', $menus[$jour]['options']['laitage'] ?? []) ? 'checked' : '' ?>>
                                                    <label class="form-check-label"
                                                        for="<?= $jour ?>-laitage-bio">🌱</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <input type="text" class="form-control"
                                            name="menus[<?= $jour ?>][laitage]"
                                            value="<?= htmlspecialchars($menus[$jour]['laitage'] ?? '') ?>">

                                        <div id="<?= $jour ?>-laitage-allergenes-details"
                                            class="mt-2"
                                            style="display: <?= isset($menus[$jour]['options']['laitage']) && in_array('allergenes', $menus[$jour]['options']['laitage'] ?? []) ? 'block' : 'none' ?>;">
                                            <label class="form-label">Sélectionnez les allergènes :</label>
                                            <select class="form-control select-allergenes"
                                                name="menus[<?= $jour ?>][allergenes][laitage][]"
                                                multiple="multiple" data-placeholder="Choisir les allergènes présents">
                                                <option value="lait" <?= isset($menus[$jour]['allergenes']['laitage']) && in_array('lait', $menus[$jour]['allergenes']['laitage'] ?? []) ? 'selected' : '' ?>>Lait
                                                </option>
                                                <option value="oeufs" <?= isset($menus[$jour]['allergenes']['laitage']) && in_array('oeufs', $menus[$jour]['allergenes']['laitage'] ?? []) ? 'selected' : '' ?>>Œufs
                                                </option>
                                                <option value="gluten" <?= isset($menus[$jour]['allergenes']['laitage']) && in_array('gluten', $menus[$jour]['allergenes']['laitage'] ?? []) ? 'selected' : '' ?>>Gluten
                                                </option>
                                                <option value="arachides" <?= isset($menus[$jour]['allergenes']['laitage']) && in_array('arachides', $menus[$jour]['allergenes']['laitage'] ?? []) ? 'selected' : '' ?>>Arachides
                                                </option>
                                                <option value="fruits_a_coque" <?= isset($menus[$jour]['allergenes']['laitage']) && in_array('fruits_a_coque', $menus[$jour]['allergenes']['laitage'] ?? []) ? 'selected' : '' ?>>Fruits
                                                    à coque</option>
                                                <option value="crustaces" <?= isset($menus[$jour]['allergenes']['laitage']) && in_array('crustaces', $menus[$jour]['allergenes']['laitage'] ?? []) ? 'selected' : '' ?>>Crustacés
                                                </option>
                                                <option value="poisson" <?= isset($menus[$jour]['allergenes']['laitage']) && in_array('poisson', $menus[$jour]['allergenes']['laitage'] ?? []) ? 'selected' : '' ?>>Poisson
                                                </option>
                                                <option value="soja" <?= isset($menus[$jour]['allergenes']['laitage']) && in_array('soja', $menus[$jour]['allergenes']['laitage'] ?? []) ? 'selected' : '' ?>>Soja
                                                </option>
                                                <option value="celeri" <?= isset($menus[$jour]['allergenes']['laitage']) && in_array('celeri', $menus[$jour]['allergenes']['laitage'] ?? []) ? 'selected' : '' ?>>Céleri
                                                </option>
                                                <option value="moutarde" <?= isset($menus[$jour]['allergenes']['laitage']) && in_array('moutarde', $menus[$jour]['allergenes']['laitage'] ?? []) ? 'selected' : '' ?>>Moutarde
                                                </option>
                                                <option value="sesame" <?= isset($menus[$jour]['allergenes']['laitage']) && in_array('sesame', $menus[$jour]['allergenes']['laitage'] ?? []) ? 'selected' : '' ?>>Sésame
                                                </option>
                                                <option value="sulfites" <?= isset($menus[$jour]['allergenes']['laitage']) && in_array('sulfites', $menus[$jour]['allergenes']['laitage'] ?? []) ? 'selected' : '' ?>>Sulfites
                                                </option>
                                                <option value="lupin" <?= isset($menus[$jour]['allergenes']['laitage']) && in_array('lupin', $menus[$jour]['allergenes']['laitage'] ?? []) ? 'selected' : '' ?>>Lupin
                                                </option>
                                                <option value="mollusques" <?= isset($menus[$jour]['allergenes']['laitage']) && in_array('mollusques', $menus[$jour]['allergenes']['laitage'] ?? []) ? 'selected' : '' ?>>Mollusques
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- DESSERT -->
                            <div class="col-md-12">
                                <div class="card mb-3">
                                    <div class="card-header bg-light">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <h5 class="mb-0">Dessert</h5>
                                            <div>
                                                <div class="form-check form-check-inline mb-0">
                                                    <input class="form-check-input" type="checkbox"
                                                        name="menus[<?= $jour ?>][options][dessert][]"
                                                        value="vegetarien"
                                                        id="<?= $jour ?>-dessert-vegetarien"
                                                        <?= isset($menus[$jour]['options']['dessert']) && in_array('vegetarien', $menus[$jour]['options']['dessert'] ?? []) ? 'checked' : '' ?>>
                                                    <label class="form-check-label"
                                                        for="<?= $jour ?>-dessert-vegetarien">🥬</label>
                                                </div>
                                                <div class="form-check form-check-inline mb-0">
                                                    <input class="form-check-input" type="checkbox"
                                                        name="menus[<?= $jour ?>][options][dessert][]"
                                                        value="allergenes"
                                                        id="<?= $jour ?>-dessert-allergenes"
                                                        <?= isset($menus[$jour]['options']['dessert']) && in_array('allergenes', $menus[$jour]['options']['dessert'] ?? []) ? 'checked' : '' ?>
                                                    onclick="toggleAllergenes('<?= $jour ?>-dessert-allergenes-details')">
                                                    <label class="form-check-label"
                                                        for="<?= $jour ?>-dessert-allergenes">⚠️</label>
                                                </div>
                                                <div class="form-check form-check-inline mb-0">
                                                    <input class="form-check-input" type="checkbox"
                                                        name="menus[<?= $jour ?>][options][dessert][]"
                                                        value="local"
                                                        id="<?= $jour ?>-dessert-local"
                                                        <?= isset($menus[$jour]['options']['dessert']) && in_array('local', $menus[$jour]['options']['dessert'] ?? []) ? 'checked' : '' ?>>
                                                    <label class="form-check-label"
                                                        for="<?= $jour ?>-dessert-local">🌟</label>
                                                </div>
                                                <div class="form-check form-check-inline mb-0">
                                                    <input class="form-check-input" type="checkbox"
                                                        name="menus[<?= $jour ?>][options][dessert][]"
                                                        value="bio"
                                                        id="<?= $jour ?>-dessert-bio"
                                                        <?= isset($menus[$jour]['options']['dessert']) && in_array('bio', $menus[$jour]['options']['dessert'] ?? []) ? 'checked' : '' ?>>
                                                    <label class="form-check-label"
                                                        for="<?= $jour ?>-dessert-bio">🌱</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <input type="text" class="form-control"
                                            name="menus[<?= $jour ?>][dessert]"
                                            value="<?= htmlspecialchars($menus[$jour]['dessert'] ?? '') ?>">

                                        <div id="<?= $jour ?>-dessert-allergenes-details"
                                            class="mt-2"
                                            style="display: <?= isset($menus[$jour]['options']['dessert']) && in_array('allergenes', $menus[$jour]['options']['dessert'] ?? []) ? 'block' : 'none' ?>;">
                                            <label class="form-label">Sélectionnez les allergènes :</label>
                                            <select class="form-control select-allergenes"
                                                name="menus[<?= $jour ?>][allergenes][dessert][]"
                                                multiple="multiple" data-placeholder="Choisir les allergènes présents">
                                                <option value="lait" <?= isset($menus[$jour]['allergenes']['dessert']) && in_array('lait', $menus[$jour]['allergenes']['dessert'] ?? []) ? 'selected' : '' ?>>Lait
                                                </option>
                                                <option value="oeufs" <?= isset($menus[$jour]['allergenes']['dessert']) && in_array('oeufs', $menus[$jour]['allergenes']['dessert'] ?? []) ? 'selected' : '' ?>>Œufs
                                                </option>
                                                <option value="gluten" <?= isset($menus[$jour]['allergenes']['dessert']) && in_array('gluten', $menus[$jour]['allergenes']['dessert'] ?? []) ? 'selected' : '' ?>>Gluten
                                                </option>
                                                <option value="arachides" <?= isset($menus[$jour]['allergenes']['dessert']) && in_array('arachides', $menus[$jour]['allergenes']['dessert'] ?? []) ? 'selected' : '' ?>>Arachides
                                                </option>
                                                <option value="fruits_a_coque" <?= isset($menus[$jour]['allergenes']['dessert']) && in_array('fruits_a_coque', $menus[$jour]['allergenes']['dessert'] ?? []) ? 'selected' : '' ?>>Fruits
                                                    à coque</option>
                                                <option value="crustaces" <?= isset($menus[$jour]['allergenes']['dessert']) && in_array('crustaces', $menus[$jour]['allergenes']['dessert'] ?? []) ? 'selected' : '' ?>>Crustacés
                                                </option>
                                                <option value="poisson" <?= isset($menus[$jour]['allergenes']['dessert']) && in_array('poisson', $menus[$jour]['allergenes']['dessert'] ?? []) ? 'selected' : '' ?>>Poisson
                                                </option>
                                                <option value="soja" <?= isset($menus[$jour]['allergenes']['dessert']) && in_array('soja', $menus[$jour]['allergenes']['dessert'] ?? []) ? 'selected' : '' ?>>Soja
                                                </option>
                                                <option value="celeri" <?= isset($menus[$jour]['allergenes']['dessert']) && in_array('celeri', $menus[$jour]['allergenes']['dessert'] ?? []) ? 'selected' : '' ?>>Céleri
                                                </option>
                                                <option value="moutarde" <?= isset($menus[$jour]['allergenes']['dessert']) && in_array('moutarde', $menus[$jour]['allergenes']['dessert'] ?? []) ? 'selected' : '' ?>>Moutarde
                                                </option>
                                                <option value="sesame" <?= isset($menus[$jour]['allergenes']['dessert']) && in_array('sesame', $menus[$jour]['allergenes']['dessert'] ?? []) ? 'selected' : '' ?>>Sésame
                                                </option>
                                                <option value="sulfites" <?= isset($menus[$jour]['allergenes']['dessert']) && in_array('sulfites', $menus[$jour]['allergenes']['dessert'] ?? []) ? 'selected' : '' ?>>Sulfites
                                                </option>
                                                <option value="lupin" <?= isset($menus[$jour]['allergenes']['dessert']) && in_array('lupin', $menus[$jour]['allergenes']['dessert'] ?? []) ? 'selected' : '' ?>>Lupin
                                                </option>
                                                <option value="mollusques" <?= isset($menus[$jour]['allergenes']['dessert']) && in_array('mollusques', $menus[$jour]['allergenes']['dessert'] ?? []) ? 'selected' : '' ?>>Mollusques
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>

                <div class="d-flex justify-content-between">
                    <a href="index.php" class="btn btn-secondary">Annuler</a>
                    <button type="submit" class="btn btn-primary">
                        <?= $editMode ? 'Mettre à jour' : 'Créer' ?>
                        le menu
                    </button>
                </div>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        console.log('jQuery version:', window.jQuery ? window.jQuery.fn.jquery : 'non chargé');
        console.log('Select2 version:', window.jQuery ? (window.jQuery.fn.select2 ? 'chargé' : 'non chargé') :
            'non chargé');
    });
</script>

<!-- Script pour la gestion des allergènes -->
<script src="/public/js/allergenes.js"></script>
<?php require_once __DIR__ . '/../../includes/footer.php'; ?>