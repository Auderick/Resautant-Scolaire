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

