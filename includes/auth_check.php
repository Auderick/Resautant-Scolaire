<?php

require_once __DIR__ . '/../auth/auth_functions.php';

// Vérifier si l'utilisateur est connecté
if (!isLoggedIn()) {
    // Redirection vers la page de connexion
    header('Location: ' . '/compte_restaurant_scolaire/auth/login.php');
    exit;
}
