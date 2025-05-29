<?php

function formatDateToFrench($date, $format = 'MMMM y')
{
    // Tableau de correspondance des mois en français
    static $moisFr = [
        1 => 'janvier', 'février', 'mars', 'avril', 'mai', 'juin',
        'juillet', 'août', 'septembre', 'octobre', 'novembre', 'décembre'
    ];

    if (is_string($date)) {
        $date = new DateTime($date);
    }

    // Format personnalisé basé sur le paramètre format
    if ($format === 'MMMM y') {
        $mois = $moisFr[(int)$date->format('n')];
        $annee = $date->format('Y');
        return ucfirst($mois . ' ' . $annee);
    } elseif ($format === 'd MMMM y') {
        $mois = $moisFr[(int)$date->format('n')];
        return $date->format('d') . ' ' . $mois . ' ' . $date->format('Y');
    } else {
        // Format par défaut si non reconnu
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
    // Si nous sommes dans l'application Electron
    if (isset($_GET['app']) && $_GET['app'] === 'electron') {
        return '';
    }

    // Pour le développement web standard
    return '';
}
