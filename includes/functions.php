<?php

function formatDateToFrench($date, $format = 'MMMM y')
{
    $formatter = new IntlDateFormatter(
        'fr_FR',
        IntlDateFormatter::FULL,
        IntlDateFormatter::FULL,
        'Europe/Paris',
        IntlDateFormatter::GREGORIAN,
        $format
    );

    if (is_string($date)) {
        $date = new DateTime($date);
    }

    return ucfirst($formatter->format($date));
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
