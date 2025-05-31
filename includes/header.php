<?php
require_once __DIR__ . '/functions.php';

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
        header('Location: ' . getBasePath() . '/auth/login.php' . (isset($_GET['app']) ? '?app=' . $_GET['app'] : ''));
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="fr" class="h-100">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Application de gestion du restaurant scolaire">
    <title>Restaurant Scolaire</title>    <!-- CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
    <link href="<?php echo getBasePath(); ?>/public/vendor/roboto/roboto.css" type="text/css" rel="stylesheet">
    <link href="<?php echo getBasePath(); ?>/public/css/style.css" type="text/css" rel="stylesheet">
        
    <!-- JavaScript Dependencies -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
</head>

<body class="d-flex flex-column min-vh-100">    <header>
        <nav class="navbar navbar-expand-lg navbar-dark bg-primary fixed-top">
            <div class="container">
                <a class="navbar-brand d-flex align-items-center" href="<?php echo getBasePath(); ?>/">
                    <i class="bi bi-building me-2"></i>
                    <span>Restaurant Scolaire</span>
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link px-3 active"
                                href="<?php echo getBasePath(); ?>/">Accueil</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link"
                                href="<?php echo getBasePath(); ?>/templates/menus/">Menus</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link"
                                href="<?php echo getBasePath(); ?>/templates/commandes/">Commandes</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link"
                                href="<?php echo getBasePath(); ?>/templates/ventes/">Ventes</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link"
                                href="<?php echo getBasePath(); ?>/templates/achats/">Achats</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link"
                                href="<?php echo getBasePath(); ?>/templates/stocks/">Stocks</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link"
                                href="<?php echo getBasePath(); ?>/templates/syntheses/">Synthèse</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link"
                                href="<?php echo getBasePath(); ?>/templates/presences/">Présences</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link"
                                href="<?php echo getBasePath(); ?>/templates/haccp/">HACCP</a>
                        </li>
                        <!-- Lien de gestion des utilisateurs uniquement pour les administrateurs -->
                        <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                        <li class="nav-item">
                            <a class="nav-link"
                                href="<?php echo getBasePath(); ?>/templates/utilisateurs/index.php">
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
                        <a href="<?php echo getBasePath(); ?>/auth/logout.php"
                            class="btn btn-outline-light btn-sm">
                            Déconnexion
                        </a>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </nav>
    </header>    <main class="flex-shrink-0 mt-5 pt-3">
        <div class="container py-4">