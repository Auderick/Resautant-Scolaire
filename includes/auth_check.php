<?php

require_once __DIR__ . '/../auth/auth_functions.php';

require_once __DIR__ . '/functions.php';

// Vérifier si l'utilisateur est connecté
if (!isLoggedIn()) {
    // Redirection vers la page de connexion
    header('Location: ' . getBasePath() . '/auth/login.php');
    exit;
}
