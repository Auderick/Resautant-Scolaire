<?php
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment; filename=refroidissement_' . $month . '.xls');
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
        CONTRÔLE DU REFROIDISSEMENT ET REMISE EN TEMPÉRATURE<br>
        Restaurant Scolaire de Leignes sur Fontaine
    </div>
    <div class="subtitle">
        Mois :
        <?php echo date('F Y', strtotime($month)); ?>
    </div>

    <h2>Refroidissement rapide</h2>
    <table>
        <tr>
            <th rowspan="2" style="width: 15%">Date</th>
            <th rowspan="2" style="width: 20%">Produit</th>
            <th colspan="3">Température</th>
            <th rowspan="2" style="width: 15%">Conforme<br>(Oui/Non)</th>
            <th rowspan="2" style="width: 15%">Visa</th>
        </tr>
        <tr>
            <th>Début</th>
            <th>+2h</th>
            <th>+4h</th>
        </tr>
        <?php for ($i = 1; $i <= 15; $i++): ?>
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

    <h2>Remise en température</h2>
    <table>
        <tr>
            <th style="width: 15%">Date</th>
            <th style="width: 20%">Produit</th>
            <th style="width: 15%">T° départ</th>
            <th style="width: 15%">T° finale</th>
            <th style="width: 20%">Durée totale</th>
            <th style="width: 15%">Visa</th>
        </tr>
        <?php for ($i = 1; $i <= 15; $i++): ?>
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
        <p><strong>Rappel des normes :</strong></p>
        <ul>
            <li>Refroidissement : de +63°C à +10°C en moins de 2h</li>
            <li>Remise en température : atteindre +63°C à cœur en moins d'1h</li>
        </ul>
    </div>
</body>

</html>