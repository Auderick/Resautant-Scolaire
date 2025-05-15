<?php

require_once __DIR__ . '/../../config/db.php';

// Créer le dossier templates s'il n'existe pas
$templatesDir = __DIR__ . '/templates/';
if (!file_exists($templatesDir)) {
    mkdir($templatesDir, 0777, true);
}

// Modèle de relevé de températures
$temperatureCsv = "Date;Heure;Zone;Température relevée;Conforme;Action corrective si nécessaire;Visa\n";
$temperatureCsv .= "JJ/MM/AAAA;HH:MM;Chambre froide positive;;;;\n";
$temperatureCsv .= "JJ/MM/AAAA;HH:MM;Chambre froide négative;;;;\n";
$temperatureCsv .= "JJ/MM/AAAA;HH:MM;Vitrine réfrigérée;;;;\n";
file_put_contents($templatesDir . 'temperature.csv', $temperatureCsv);

// Modèle de plan de nettoyage
$nettoyageCsv = "Date;Zone/Équipement;Produit utilisé;Méthode;Fréquence;Réalisé par;Visa\n";
$nettoyageCsv .= "JJ/MM/AAAA;Cuisine;;;;;;\n";
$nettoyageCsv .= "JJ/MM/AAAA;Plan de travail;;;;;;\n";
$nettoyageCsv .= "JJ/MM/AAAA;Réfrigérateurs;;;;;;\n";
$nettoyageCsv .= "JJ/MM/AAAA;Sol;;;;;;\n";
file_put_contents($templatesDir . 'nettoyage.csv', $nettoyageCsv);

// Modèle de traçabilité
$tracabiliteCsv = "Date;Produit;Fournisseur;N° Lot;DLC/DDM;T°C à réception;Conforme;Visa\n";
$tracabiliteCsv .= "JJ/MM/AAAA;;;;;;;;\n";
$tracabiliteCsv .= "JJ/MM/AAAA;;;;;;;;\n";
file_put_contents($templatesDir . 'tracabilite.csv', $tracabiliteCsv);

echo "Les modèles ont été créés avec succès dans le dossier templates/";
