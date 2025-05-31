<div class="title">
    <h1>FICHE DE CONTRÔLE DES TEMPÉRATURES PRODUITS<br>PENDANT LE SERVICE</h1>
    <p>Restaurant Scolaire de Leignes sur Fontaine</p>
    <p>Mois : <?php echo ucfirst($mois_fr); ?></p>
</div>

<!-- Distribution Froide -->
<div class="subtitle">DISTRIBUTION FROIDE - VALEUR CIBLE : + 3°C - TOLÉRANCE : + 10°C</div>
<table>
    <tr>
        <th style="width:15%">SEMAINE N°</th>
        <th style="width:35%">Nom du plat</th>
        <th style="width:15%">Heure</th>
        <th style="width:20%">Température (°C)</th>
        <th style="width:15%">Visa</th>
    </tr>
    <?php for ($i = 0; $i < 15; $i++): ?>
    <tr style="height:25px">
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
    </tr>
    <?php endfor; ?>
</table>

<!-- Distribution Chaude -->
<div class="subtitle">DISTRIBUTION CHAUDE - VALEUR CIBLE : + 63°C - TOLÉRANCE : + 55°C</div>
<table>
    <tr>
        <th style="width:15%">SEMAINE N°</th>
        <th style="width:35%">Nom du plat</th>
        <th style="width:15%">Heure</th>
        <th style="width:20%">Température (°C)</th>
        <th style="width:15%">Visa</th>
    </tr>
    <?php for ($i = 0; $i < 15; $i++): ?>
    <tr style="height:25px">
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
    </tr>
    <?php endfor; ?>
</table>

<!-- Tableau des non-conformités -->
<div class="subtitle">TABLEAU DES NON CONFORMITÉS</div>
<table>
    <tr>
        <th style="width:15%">DATE</th>
        <th style="width:35%">ORIGINE DU PROBLÈME</th>
        <th style="width:35%">ACTIONS CORRECTIVES</th>
        <th style="width:15%">VISA</th>
    </tr>
    <?php for ($i = 0; $i < 5; $i++): ?>
    <tr style="height:30px">
        <td></td>
        <td></td>
        <td></td>
        <td></td>
    </tr>
    <?php endfor; ?>
</table>

<div class="note">
    <p><strong>Note :</strong> En cas de non-conformité (T°C hors limite), prendre immédiatement les actions correctives
        nécessaires :</p>
    <ul>
        <li>Plats chauds : Remise en température si < 63°C</li>
        <li>Plats froids : Mise au froid si > 3°C</li>
        <li>Si impossibilité de correction : Élimination du produit</li>
    </ul>
</div>