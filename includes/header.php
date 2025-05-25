<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Démarrage de la session
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Inclure les fonctions d'authentification si elles existent
$auth_functions_file = __DIR__ . '/../auth/auth_functions.php';
if (file_exists($auth_functions_file)) {
    require_once $auth_functions_file;
} else {
    // Fonction temporaire uniquement si les fonctions d'auth ne sont pas disponibles
    if (!function_exists('isLoggedIn')) {
        function isLoggedIn()
        {
            return isset($_SESSION['user_id']);
        }
    }
}

// Vérification d'authentification (sauf pour les pages d'auth)
$current_file = basename($_SERVER['SCRIPT_NAME']);
$auth_pages = ['login.php', 'logout.php'];

if (!in_array($current_file, $auth_pages)) {
    // Redirection vers la page de login si l'utilisateur n'est pas connecté
    if (!isLoggedIn() && $current_file !== 'login.php') {
        header('Location: /compte_restaurant_scolaire/auth/login.php');
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restaurant Scolaire</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Changez le chemin CSS ici -->
    <link rel="stylesheet" href="/compte_restaurant_scolaire/public/css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
</head>

<body class="d-flex flex-column min-vh-100">
    <header class="bg-primary">
        <nav class="navbar navbar-expand-lg navbar-dark">
            <div class="container">
                <a class="navbar-brand" href="/">Restaurant Scolaire</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item"> <a class="nav-link" href="/">Accueil</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/templates/menus/">Menus</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/templates/commandes/">Commandes</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/templates/ventes/">Ventes</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/templates/achats/">Achats</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/templates/stocks/">Stocks</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/templates/syntheses/">Synthèse</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/templates/presences/">Présences</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/templates/haccp/">HACCP</a>
                        </li>
                        <!-- Lien de gestion des utilisateurs uniquement pour les administrateurs -->
                        <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="/templates/utilisateurs/index.php">
                                <i class="fas fa-users"></i> Gestion utilisateurs
                            </a>
                        </li>
                        <?php endif; ?>
                    </ul>
                    <?php if (isLoggedIn()): ?>
                    <div class="d-flex align-items-center">
                        <span class="navbar-text me-3 mb-0 text-light">
                            Bonjour,
                            <?= htmlspecialchars($_SESSION['nom_complet'] ?? $_SESSION['username']) ?>
                        </span>
                        <a href="/auth/logout.php" class="btn btn-outline-light btn-sm">
                            Déconnexion
                        </a>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </nav>
    </header>
    <main class="flex-grow-1 py-4">