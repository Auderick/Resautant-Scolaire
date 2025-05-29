<?php
require_once __DIR__ . '/../../includes/auth_check.php';
require_once __DIR__ . '/../../config/db.php';

// Récupération des paramètres
$category = isset($_GET['category']) ? $_GET['category'] : '';
$month = isset($_GET['month']) ? $_GET['month'] : date('Y-m');

// Conversion du mois en français
$mois = [
    '01' => 'Janvier',
    '02' => 'Février',
    '03' => 'Mars',
    '04' => 'Avril',
    '05' => 'Mai',
    '06' => 'Juin',
    '07' => 'Juillet',
    '08' => 'Août',
    '09' => 'Septembre',
    '10' => 'Octobre',
    '11' => 'Novembre',
    '12' => 'Décembre'
];

$month_num = date('m', strtotime($month));
$year = date('Y', strtotime($month));
$mois_fr = $mois[$month_num] . ' ' . $year;

// Configuration de l'entête pour Excel
header('Content-Type: application/vnd.ms-excel; charset=UTF-8');
header('Content-Disposition: attachment; filename=export_' . $category . '_' . $month . '.xls');
header('Cache-Control: max-age=0');
header('Pragma: public');

// Fonction pour sécuriser les données
function clean($str)
{
    if (is_null($str)) {
        return '';
    }
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}

// Pour les templates spécifiques
$templates_categories = ['distribution', 'temperatures', 'nettoyage', 'refroidissement', 'tracabilite'];
if (in_array($category, $templates_categories)) {
    $template_file = __DIR__ . '/templates/' . $category . '_export.php';
    if (file_exists($template_file)) {
        include $template_file;
        exit;
    }
}

// Requête SQL pour la synthèse
$sql = "SELECT * FROM haccp_documents WHERE DATE_FORMAT(upload_date, '%Y-%m') = ? ";
if (!empty($category)) {
    $sql .= "AND category = ? ";
}
$sql .= "ORDER BY upload_date DESC";

$stmt = $db->prepare($sql);
if (!empty($category)) {
    $stmt->execute([$month, $category]);
} else {
    $stmt->execute([$month]);
}
$documents = $stmt->fetchAll();
?>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }

        th,
        td {
            border: 1px solid black;
            padding: 5px;
        }

        .header {
            font-size: 14pt;
            font-weight: bold;
            text-align: center;
        }
    </style>
</head>

<body>
    <table>
        <tr class="header">            <td colspan="4">Documents HACCP -
                <?php echo clean($category); ?> -
                <?php echo $mois_fr; ?>
            </td>
        </tr>        <tr>
            <th>Date</th>
            <th>Catégorie</th>
            <th>Nom du document</th>
        </tr>
        <?php foreach ($documents as $doc): ?>
        <tr>
            <td><?php echo date('d/m/Y', strtotime($doc['upload_date'])); ?>
            </td>
            <td><?php echo clean($doc['category']); ?>
            </td>
            <td><?php echo clean($doc['name']); ?>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>

</html>