<?php

function formatDateToFrench($date, $format = 'MMMM y')
{
    if (is_string($date)) {
        $date = new DateTime($date);
    }

    $mois_fr = array(
        1 => 'janvier', 'février', 'mars', 'avril', 'mai', 'juin',
        'juillet', 'août', 'septembre', 'octobre', 'novembre', 'décembre'
    );

    switch ($format) {
        case 'MMMM y':
            return ucfirst($mois_fr[$date->format('n')] . ' ' . $date->format('Y'));
        case 'd MMMM Y':
            return $date->format('j') . ' ' . $mois_fr[$date->format('n')] . ' ' . $date->format('Y');
        case 'EEEE d MMMM Y':
            $jours_fr = array(
                'Monday' => 'lundi', 'Tuesday' => 'mardi', 'Wednesday' => 'mercredi',
                'Thursday' => 'jeudi', 'Friday' => 'vendredi', 'Saturday' => 'samedi', 'Sunday' => 'dimanche'
            );
            return ucfirst($jours_fr[$date->format('l')] . ' ' . $date->format('j') . ' ' . $mois_fr[$date->format('n')] . ' ' . $date->format('Y'));
        default:
            return $date->format('d/m/Y');
    }
}


function formatMontant($valeur, $decimales = 2)
{
    if ($valeur === null) {
        return '0,00 €';
    }
    return number_format($valeur, $decimales, ',', ' ') . ' €';
}

function formatNombre($valeur)
{
    if ($valeur === null) {
        return '0';
    }
    return number_format($valeur, 0, ',', ' ');
}

/**
 * Retourne le chemin de base de l'application
 */
function getBasePath()
{
    // Détection si nous sommes dans l'app Electron
    if (isset($_GET['app']) && $_GET['app'] === 'electron') {
        return '.';
    }
    
    // Pour l'environnement web
    $scriptPath = $_SERVER['SCRIPT_NAME'];
    
    // Chercher plusieurs dossiers possibles
    $possiblePaths = ['/templates/', '/auth/', '/api/'];
    
    foreach ($possiblePaths as $path) {
        $position = strpos($scriptPath, $path);
        if ($position !== false) {
            return substr($scriptPath, 0, $position);
        }
    }
    
    // Si aucun des dossiers n'est trouvé, retourner le dossier parent
    $lastSlash = strrpos($scriptPath, '/');
    return $lastSlash !== false ? substr($scriptPath, 0, $lastSlash) : '';
    
    $position = strpos($scriptPath, '/auth/');
    if ($position !== false) {
        return substr($scriptPath, 0, $position);
    }
    
    $position = strpos($scriptPath, '/api/');
    if ($position !== false) {
        return substr($scriptPath, 0, $position);
    }
    
    return dirname($scriptPath);
}
