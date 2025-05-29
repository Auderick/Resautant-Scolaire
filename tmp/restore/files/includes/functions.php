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
 * Vérifie si l'application est exécutée depuis Electron
 */
function isDesktopApp()
{
    // Vérifier d'abord dans la session
    if (isset($_SESSION['is_desktop']) && $_SESSION['is_desktop'] === true) {
        debug_log("Mode desktop détecté depuis la session");
        return true;
    }

    // Vérifier le paramètre GET
    if (isset($_GET['app']) && $_GET['app'] === 'desktop') {
        debug_log("Mode desktop détecté depuis GET");
        return true;
    }

    // Vérifier l'User-Agent pour Electron
    if (isset($_SERVER['HTTP_USER_AGENT']) && (
        strpos($_SERVER['HTTP_USER_AGENT'], 'Electron') !== false ||
        strpos($_SERVER['HTTP_USER_AGENT'], 'RestaurantScolaireDesktop') !== false
    )) {
        debug_log("Mode desktop détecté depuis User-Agent: " . $_SERVER['HTTP_USER_AGENT']);
        $_SESSION['is_desktop'] = true;
        return true;
    }

    debug_log("Mode web détecté");
    return false;
}

/**
 * Retourne le chemin de base de l'application
 */
function getBasePath()
{
    // Si nous sommes dans l'application Electron
    if (isDesktopApp()) {
        return '';
    }

    // Pour l'application web
    $scriptDir = dirname($_SERVER['SCRIPT_NAME']);
    $basePath = str_replace('/auth', '', $scriptDir);
    $basePath = str_replace('/includes', '', $basePath);
    $basePath = str_replace('/templates', '', $basePath);
    return rtrim($basePath, '/');
}

/**
 * Génère l'URL complète avec le paramètre app=desktop si nécessaire
 */
function getFullUrl($path) 
{
    $base = getBasePath();
    $url = $base . '/' . ltrim($path, '/');
    
    if (isDesktopApp()) {
        $separator = (strpos($url, '?') !== false) ? '&' : '?';
        $url .= $separator . 'app=desktop';
    }
    
    return $url;
}
