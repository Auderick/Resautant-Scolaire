<?php
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment; filename=tracabilite_' . $month . '.xls');
header('Cache-Control: max-age=0');
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

        .title {
            text-align: center;
            font-size: 16pt;
            margin: 20px 0;
        }

        .subtitle {
            text-align: center;
            font-size: 12pt;
            margin: 10px 0;
        }
    </style>
</head>

<body>
    <div class="title">
        FICHE DE TRAÇABILITÉ DES PRODUITS<br>
        Restaurant Scolaire de Leignes sur Fontaine
    </div>
    <div class="subtitle">
        Mois :
        <?php echo date('F Y', strtotime($month)); ?>
    </div>

    <table>
        <tr>
            <th style="width: 12%">Date</th>
            <th style="width: 18%">Produit</th>
            <th style="width: 15%">Fournisseur</th>
            <th style="width: 15%">N° de lot</th>
            <th style="width: 12%">DLC/DDM</th>
            <th style="width: 15%">État à réception</th>
            <th style="width: 13%">Visa</th>
        </tr>
        <?php for ($i = 1; $i <= 25; $i++): ?>
        <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        <?php endfor; ?>
    </table>

    <div style="margin-top: 20px;">
        <p><strong>État à réception :</strong></p>
        <ul>
            <li>Vérifier la température</li>
            <li>Vérifier l'intégrité des emballages</li>
            <li>Vérifier la DLC/DDM</li>
            <li>Noter toute anomalie</li>
        </ul>
    </div>
</body>

</html>