<?php
require_once __DIR__ . '/functions.php';
require_once __DIR__ . '/../auth/auth_functions.php';  // Ajout de l'inclusion des fonctions d'authentification

error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

// Création du dossier logs s'il n'existe pas
if (!is_dir(__DIR__ . '/../logs')) {
    mkdir(__DIR__ . '/../logs', 0777, true);
}

// Configuration de la journalisation des erreurs
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/../logs/php_error.log');

// Activation du debugging détaillé
function debug_log($message) {
    $log_file = __DIR__ . '/../logs/debug.log';
    $date = date('Y-m-d H:i:s');
    file_put_contents($log_file, "[$date] $message\n", FILE_APPEND);
}

debug_log('Début du chargement header.php');

// S'assurer que la session est démarrée
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Journaliser les informations de l'environnement
debug_log("User Agent: " . ($_SERVER['HTTP_USER_AGENT'] ?? 'Non défini'));
debug_log("Session ID: " . session_id());
debug_log("Session data: " . print_r($_SESSION, true));
debug_log("GET params: " . print_r($_GET, true));

// Détecter le mode desktop
$isDesktop = isDesktopApp();
if ($isDesktop) {
    $_SESSION['is_desktop'] = true;
    debug_log("Application en mode desktop");
} else {
    debug_log("Application en mode web");
}

// Vérification d'authentification (sauf pour les pages d'auth)
$current_file = basename($_SERVER['SCRIPT_NAME']);
$auth_pages = ['login.php', 'logout.php'];

if (!in_array($current_file, $auth_pages)) {
    debug_log("Page nécessitant une authentification");
    
    if (!isLoggedIn()) {
        debug_log("Utilisateur non connecté");
        
        if ($isDesktop) {
            debug_log("Redirection vers login (desktop)");
            header('Location: ' . getBasePath() . '/auth/login.php?app=desktop');
        } else {
            debug_log("Redirection vers login (web)");
            header('Location: ' . getBasePath() . '/auth/login.php');
        }
        exit;
    } else {
        debug_log("Utilisateur connecté - ID: " . ($_SESSION['user_id'] ?? 'Non défini'));
    }
}
?><!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restaurant Scolaire</title>
    <!-- CSS Dependencies -->
    <link rel="stylesheet"
        href="<?php echo getBasePath(); ?>/public/vendor/bootstrap/bootstrap.min.css">
    <link rel="stylesheet"
        href="<?php echo getBasePath(); ?>/public/vendor/bootstrap-icons/bootstrap-icons.css">
    <link rel="stylesheet"
        href="<?php echo getBasePath(); ?>/public/vendor/select2/select2.min.css">
    <link rel="stylesheet"
        href="<?php echo getBasePath(); ?>/public/vendor/roboto/roboto.css">

    <!-- Custom CSS -->
    <link rel="stylesheet"
        href="<?php echo getBasePath(); ?>/public/css/style.css">

    <!-- JavaScript Dependencies -->
    <script
        src="<?php echo getBasePath(); ?>/public/vendor/jquery/jquery-3.7.1.min.js">
    </script>
    <script
        src="<?php echo getBasePath(); ?>/public/vendor/select2/select2.min.js">
    </script>
</head>

<body class="d-flex flex-column min-vh-100">
    <header class="bg-primary">
        <nav class="navbar navbar-expand-lg navbar-dark">
            <div class="container">
                <a class="navbar-brand"
                    href="<?php echo getBasePath(); ?>/">Restaurant
                    Scolaire</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link"
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
    </header>
    <main class="container py-4">