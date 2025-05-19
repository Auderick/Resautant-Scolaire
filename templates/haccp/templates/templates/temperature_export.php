<div class="title">
    <h1>RELEVÉ DES TEMPÉRATURES</h1>
    <p>Restaurant Scolaire de Leignes sur Fontaine</p>
    <p>Mois : <?php echo ucfirst($mois_fr); ?></p>
</div>

<table class="temperature-table">
    <thead>
        <tr class="temperature-header">
            <th rowspan="2">Date</th>
            <th colspan="2">Congélateur<br>-18°C Mini</th>
            <th colspan="4">Armoire froide<br>+3°C Maxi</th>
        </tr>
        <tr>
            <th>T° arrivée</th>
            <th>T° départ</th>
            <th>T° matin</th>
            <th>T° soir</th>
            <th>T° matin</th>
            <th>T° soir</th>
        </tr>
    </thead>
    <tbody>
        <?php
        // Nombre de jours dans le mois
        $nbJours = date('t', strtotime($month . '-01'));
    for ($i = 1; $i <= $nbJours; $i++):
        ?>
        <tr>
            <td class="date-column"><?php echo $i; ?></td>
            <td class="temp-column"></td>
            <td class="temp-column"></td>
            <td class="temp-column"></td>
            <td class="temp-column"></td>
            <td class="temp-column"></td>
            <td class="temp-column"></td>
        </tr>
        <?php endfor; ?>
    </tbody>
</table>

<!-- Tableau des non-conformités -->
<div class="subtitle">Gestion des non-conformités :</div>
<table class="non-conformite-table">
    <thead>
        <tr>
            <th>DATE</th>
            <th>CONSTATATION</th>
            <th>ANALYSE</th>
            <th>ACTION(S)</th>
        </tr>
    </thead>
    <tbody>
        <?php for ($i = 0; $i < 5; $i++): ?>
        <tr>
            <td style="height:40px"></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <?php endfor; ?>
    </tbody>
</table>

<div class="signature">
    <p>Responsable : _________________________ Signature : _________________________</p>
</div>