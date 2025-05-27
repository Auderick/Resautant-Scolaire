<?php

require_once __DIR__ . '/../auth/auth_functions.php';

require_once __DIR__ . '/functions.php';

// Vérifier si l'utilisateur est connecté
if (!isLoggedIn()) {
    // Redirection vers la page de connexion avec le paramètre app si nécessaire
    header('Location: ' . getBasePath() . '/auth/login.php' . (isset($_GET['app']) ? '?app=' . $_GET['app'] : ''));
    exit;
}
