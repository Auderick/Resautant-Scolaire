<?php
require_once __DIR__ . '/../../includes/functions.php';
require_once __DIR__ . '/../../src/Models/presence.php';

$presence = new Presence();
$categories = $presence->getCategories();

// Type d'impression (journalier ou recap)
$type = isset($_GET['type']) ? $_GET['type'] : 'jour';
$categorieId = isset($_GET['categorie']) ? intval($_GET['categorie']) : 1;

// Récupération du nom de la catégorie
$nomCategorie = '';
foreach ($categories as $cat) {
    if ($cat['id'] == $categorieId) {
        $nomCategorie = $cat['nom'];
        break;
    }
}

// Variables spécifiques selon le type
if ($type === 'jour') {
    $date = isset($_GET['date']) ? $_GET['date'] : date('Y-m-d');
    $personnes = $presence->getPersonnesByCategorie($categorieId);
    $presencesJour = $presence->getPresences($date, $categorieId);
    $presencesMap = array_column($presencesJour, 'present', 'personne_id');
    $absencesMap = array_column($presencesJour, 'absent', 'personne_id');
} else {
    $mois = isset($_GET['mois']) ? intval($_GET['mois']) : intval(date('m'));
    $annee = isset($_GET['annee']) ? intval($_GET['annee']) : intval(date('Y'));
    $recap = $presence->getRecapitulatifMensuel($mois, $annee, $categorieId);
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>
        <?= $type === 'jour' ? 'Liste des Présences' : 'Récapitulatif Mensuel' ?>
        - <?= htmlspecialchars($nomCategorie) ?></title>
    <link rel="stylesheet" href="/public/css/print.css">
    <style>
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

        th,
        td {
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
        }

        /* Style uniformisé pour les mini-tableaux de jours */
        .jours-table {
            width: 100%;
            margin: 0 !important;
            border: none !important;
        }

        .jours-table tr td {
            width: 25%;
            text-align: center;
            border: 1px solid #999;
            padding: 2px;
            margin: 2px;
            border-radius: 3px;
        }

        .jours-table tr td.empty {
            border: none;
        }

        @media print {
            body {
                margin: 15mm;
            }

            .no-print {
                display: none;
            }
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>
            <?php if ($type === 'jour'): ?>
            Liste des Présences -
            <?= htmlspecialchars($nomCategorie) ?>
            <?php else: ?>
            Récapitulatif des Présences -
            <?= htmlspecialchars($nomCategorie) ?>
            <?php endif; ?>
        </h1>
        <div>
            <?php if ($type === 'jour'): ?>
            <?= formatDateToFrench($date, 'l j F Y') ?>
            <?php else: ?>
            <?= formatDateToFrench("$annee-$mois-01", 'MMMM Y') ?>
            <?php endif; ?>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 20%">Nom</th>
                <th style="width: 20%">Prénom</th>
                <?php if ($type === 'jour'): ?>
                <th>Présent(e)</th>
                <th>Absent(e)</th>
                <?php else: ?>
                <th>Jours présent</th>
                <th>Jours absent</th>
                <th style="width: 12%">Total P.</th>
                <th style="width: 12%">Total A.</th>
                <?php endif; ?>
            </tr>
        </thead>
        <tbody>
            <?php if ($type === 'recap'):
                // Fonction pour créer une table de jours (4 colonnes)
                $createDaysTable = function ($jours) {
                    if (empty($jours)) {
                        return '-';
                    }

                    $html = '<table class="jours-table">';
                    $chunks = array_chunk($jours, 4);

                    foreach ($chunks as $chunk) {
                        $html .= '<tr>';
                        foreach ($chunk as $jour) {
                            $html .= '<td>' . $jour . '</td>';
                        }
                        // Remplir les cellules manquantes si nécessaire
                        for ($i = count($chunk); $i < 4; $i++) {
                            $html .= '<td class="empty"></td>';
                        }
                        $html .= '</tr>';
                    }
                    $html .= '</table>';
                    return $html;
                };

                foreach ($recap as $personne):
                    $joursPresent = $personne['jours_present'] ? explode(',', $personne['jours_present']) : [];
                    $joursAbsent = $personne['jours_absent'] ? explode(',', $personne['jours_absent']) : [];
                    sort($joursPresent, SORT_NUMERIC);
                    sort($joursAbsent, SORT_NUMERIC);
                    ?>
            <tr>
                <td><?= htmlspecialchars($personne['nom']) ?>
                </td>
                <td><?= htmlspecialchars($personne['prenom']) ?>
                </td>
                <td><?= $createDaysTable($joursPresent) ?></td>
                <td><?= $createDaysTable($joursAbsent) ?></td>
                <td style="text-align: center">
                    <?= count($joursPresent) ?></td>
                <td style="text-align: center">
                    <?= count($joursAbsent) ?></td>
            </tr>
            <?php endforeach; ?>
            <?php else: // type === 'jour'?>
            <?php foreach ($personnes as $personne): ?>
            <tr>
                <td><?= htmlspecialchars($personne['nom']) ?>
                </td>
                <td><?= htmlspecialchars($personne['prenom']) ?>
                </td>
                <td style="text-align: center">
                    <?= isset($presencesMap[$personne['id']]) && $presencesMap[$personne['id']] ? '✓' : '' ?>
                </td>
                <td style="text-align: center">
                    <?= isset($absencesMap[$personne['id']]) && $absencesMap[$personne['id']] ? '✓' : '' ?>
                </td>
            </tr>
            <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>

    <div class="footer">
        <?= htmlspecialchars($nomCategorie) ?> -
        <?php if ($type === 'jour'): ?>
        <?= formatDateToFrench($date, 'l j F Y') ?>
        <?php else: ?>
        <?= formatDateToFrench("$annee-$mois-01", 'MMMM Y') ?>
        <?php endif; ?>
    </div>

    <script>
        window.onload = function() {
            window.print();
        }
    </script>
</body>

</html>