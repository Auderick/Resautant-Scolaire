<?php

require_once __DIR__ . '/../config/db.php';

// Fonction de journalisation
function logDebug($message) {
    $logFile = __DIR__ . '/../logs/auth_debug.log';
    $timestamp = date('Y-m-d H:i:s');
    file_put_contents($logFile, "[$timestamp] $message\n", FILE_APPEND);
}

function connectUser($username, $password)
{
    global $db;
    logDebug("Tentative de connexion pour l'utilisateur: $username");

    $query = "SELECT * FROM utilisateurs WHERE username = ?";
    $stmt = $db->prepare($query);
    $stmt->execute([$username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        // Démarrage de la session si pas déjà fait
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        // Stockage des informations utilisateur en session
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];
        $_SESSION['nom_complet'] = $user['prenom'] . ' ' . $user['nom'];

        // Sauvegarder explicitement le mode desktop dans la session
        if (isset($_GET['app']) && $_GET['app'] === 'desktop') {
            $_SESSION['is_desktop'] = true;
            logDebug("Mode desktop détecté et sauvegardé en session");
        }

        return true;
    }

    return false;
}

// On vérifie que la fonction n'est pas déjà déclarée
if (!function_exists('isLoggedIn')) {
    function isLoggedIn()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        // Propager le mode desktop depuis la session
        if (isset($_SESSION['is_desktop']) && $_SESSION['is_desktop'] === true) {
            $_GET['app'] = 'desktop';
        }
        // Ou depuis le paramètre GET
        elseif (isset($_GET['app']) && $_GET['app'] === 'desktop') {
            $_SESSION['is_desktop'] = true;
        }

        return isset($_SESSION['user_id']);
    }
}

// On vérifie que la fonction n'est pas déjà déclarée
if (!function_exists('isAdmin')) {
    function isAdmin()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        return isset($_SESSION['role']) && $_SESSION['role'] == 'admin';
    }
}

// On vérifie que la fonction n'est pas déjà déclarée
if (!function_exists('logout')) {
    function logout()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        // Destruction des variables de session
        $_SESSION = array();

        // Destruction du cookie de session
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params["path"],
                $params["domain"],
                $params["secure"],
                $params["httponly"]
            );
        }

        // Destruction de la session
        session_destroy();
    }
    // On vérifie que la fonction n'est pas déjà déclarée
    if (!function_exists('hasEditPermission')) {
        function hasEditPermission()
        {
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }

            return isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
        }
    }
}
