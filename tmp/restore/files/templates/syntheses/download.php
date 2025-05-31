<?php

setlocale(LC_TIME, 'fr_FR.UTF-8', 'fra');
date_default_timezone_set('Europe/Paris');

require_once __DIR__ . '/../../includes/auth_check.php';
require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../../config/db.php';
require_once __DIR__ . '/../../includes/functions.php';
require_once __DIR__ . '/../../src/Models/synthese.php';

// Récupération des paramètres
$mois = isset($_GET['mois']) ? intval($_GET['mois']) : intval(date('m'));
$annee = isset($_GET['annee']) ? intval($_GET['annee']) : intval(date('Y'));

// Initialisation de mPDF
$mpdf = new \Mpdf\Mpdf([
    'margin_left' => 5,
    'margin_right' => 5,
    'margin_top' => 5,
    'margin_bottom' => 2,
    'format' => [210, 280]
]);

// Création d'une instance de Synthese
$synthese = new Synthese($db);
$donnees_mois = $synthese->getSyntheseMensuelle($mois, $annee);
$resultats_annee = $synthese->getSyntheseAnnuelle($annee);
$donnees_annee = end($resultats_annee); // Le dernier élément contient les totaux annuels

// Calcul des moyennes mensuelles si nombre_couverts > 0
$prix_moyen_couvert = $donnees_mois['nombre_couverts'] > 0 ?
    $donnees_mois['total_ventes'] / $donnees_mois['nombre_couverts'] : 0;
$cout_moyen_couvert = $donnees_mois['cout_par_couvert'];

// Calcul des moyennes annuelles
$prix_moyen_couvert_annuel = $donnees_annee['nombre_couverts'] > 0 ?
    $donnees_annee['total_ventes'] / $donnees_annee['nombre_couverts'] : 0;
$cout_moyen_couvert_annuel = $donnees_annee['cout_par_couvert'];

// En-tête du document
$html = '
<style>    body { font-family: Arial, sans-serif; margin: 0; padding: 0; }
    .container { padding: 0; max-width: 100%; margin: 0 auto; }
    .header { text-align: center; margin-bottom: 10px; padding-bottom: 4px; border-bottom: 2px solid #333; }
    .header h1 { margin: 0; color: #333; font-size: 24px; }
    .periode { color: #666; font-size: 20px; margin-top: 2px; }
    .section { margin-bottom: 10px; }
    .section-title { color: #333; font-size: 20px; margin-bottom: 8px; padding-bottom: 2px; border-bottom: 1px solid #ddd; }
    .grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 6px; margin-bottom: 10px; }
    .card { background: #f8f9fa; padding: 15px; border-radius: 4px; }
    .card-label { color: #666; font-size: 14px; margin-bottom: 2px; }
    .card-value { color: #333; font-size: 20px; font-weight: bold; }
    .divider { border-top: 1px dashed #ddd; margin: 10px 0; }
</style>

<div class="container">
    <div class="header">
        <h1>Synthèse Financière</h1>
        <div class="periode">' . strftime('%B %Y', mktime(0, 0, 0, $mois, 1, $annee)) . '</div>
    </div>

    <div class="section">
        <div class="section-title">Données Mensuelles</div>
        <div class="grid">
            <div class="card">
                <div class="card-label">Total Ventes</div>
                <div class="card-value">' . formatMontant($donnees_mois['total_ventes']) . '</div>
            </div>
            <div class="card">
                <div class="card-label">Total Achats</div>
                <div class="card-value">' . formatMontant($donnees_mois['total_achats']) . '</div>
            </div>
            <div class="card">
                <div class="card-label">Valeur Stock</div>
                <div class="card-value">' . formatMontant($donnees_mois['valeur_stock_mensuelle']) . '</div>
            </div>
            <div class="card">
                <div class="card-label">Nombre de Couverts</div>
                <div class="card-value">' . formatNombre($donnees_mois['nombre_couverts']) . '</div>
            </div>
            <div class="card">
                <div class="card-label">Prix Moyen par Couvert</div>
                <div class="card-value">' . formatMontant($prix_moyen_couvert) . '</div>
            </div>
            <div class="card">
                <div class="card-label">Coût Moyen par Couvert</div>
                <div class="card-value">' . formatMontant($cout_moyen_couvert) . '</div>
            </div>
        </div>
    </div>

    <div class="divider"></div>

    <div class="section">
        <div class="section-title">Synthèse Annuelle ' . $annee . '</div>
        <div class="grid">
            <div class="card">
                <div class="card-label">Total Ventes Annuel</div>
                <div class="card-value">' . formatMontant($donnees_annee['total_ventes']) . '</div>
            </div>
            <div class="card">
                <div class="card-label">Total Achats Annuel</div>
                <div class="card-value">' . formatMontant($donnees_annee['total_achats']) . '</div>
            </div>
            <div class="card">
                <div class="card-label">Couverts Annuels</div>
                <div class="card-value">' . formatNombre($donnees_annee['nombre_couverts']) . '</div>
            </div>
            <div class="card">
                <div class="card-label">Prix Moyen Annuel</div>
                <div class="card-value">' . formatMontant($prix_moyen_couvert_annuel) . '</div>
            </div>
            <div class="card">
                <div class="card-label">Coût Moyen Annuel</div>
                <div class="card-value">' . formatMontant($cout_moyen_couvert_annuel) . '</div>
            </div>
        </div>
    </div>
</div>';

// Génération du PDF
$mpdf->WriteHTML($html);

// Nom du fichier
$filename = 'Synthese_' . strftime('%B_%Y', mktime(0, 0, 0, $mois, 1, $annee)) . '.pdf';

// Envoi du PDF
$mpdf->Output($filename, 'D');
