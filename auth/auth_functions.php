<?php

require_once __DIR__ . '/../config/db.php';

function connectUser($username, $password)
{
    global $db;

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
