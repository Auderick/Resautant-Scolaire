<?php
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment; filename=plan_nettoyage_' . $month . '.xls');
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
        PLAN DE NETTOYAGE ET DÉSINFECTION<br>
        Restaurant Scolaire de Leignes sur Fontaine
    </div>
    <div class="subtitle">
        Mois :
        <?php echo date('F Y', strtotime($month)); ?>
    </div>

    <table>
        <tr>
            <th style="width: 15%">Zone/Équipement</th>
            <th style="width: 15%">Fréquence</th>
            <th style="width: 15%">Produit utilisé</th>
            <th style="width: 15%">Date</th>
            <th style="width: 25%">Observations</th>
            <th style="width: 15%">Visa</th>
        </tr>
        <?php for ($i = 1; $i <= 20; $i++): ?>
        <tr>
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
        <p><strong>Instructions :</strong></p>
        <ol>
            <li>Respecter les dilutions des produits</li>
            <li>Porter les équipements de protection individuelle</li>
            <li>Noter toute anomalie dans la colonne observations</li>
        </ol>
    </div>
</body>

</html>