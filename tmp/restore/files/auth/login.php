<?php
require_once __DIR__ . '/../config/db.php';

// Fonction pour se connecter
function connectUser($username, $password)
{
    global $db;

    $query = "SELECT * FROM utilisateurs WHERE username = ?";
    $stmt = $db->prepare($query);
    $stmt->execute([$username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        // Démarrage de la session
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];
        $_SESSION['nom_complet'] = $user['prenom'] . ' ' . $user['nom'];

        return true;
    }

    return false;
}

// Vérifier si l'utilisateur est déjà connecté
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION['user_id'])) {
    header('Location: ../index.php');
    exit;
}

$error = '';


// Traitement du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = isset($_POST['username']) ? trim($_POST['username']) : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';

    if (empty($username) || empty($password)) {
        $error = 'Veuillez remplir tous les champs';    } else {
        if (connectUser($username, $password)) {
            $redirectUrl = '../index.php';
            if (isset($_GET['app']) && $_GET['app'] === 'desktop') {
                $redirectUrl .= '?app=desktop';
            }
            header('Location: ' . $redirectUrl);
            exit;
        } else {
            $error = 'Nom d\'utilisateur ou mot de passe incorrect';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - Restaurant Scolaire</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f8f9fa;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-container {
            max-width: 400px;
            width: 100%;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        }
        .login-header {
            text-align: center;
            margin-bottom: 25px;
        }
        .btn-primary {
            background-color: #0d6efd;
            border-color: #0d6efd;
            width: 100%;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-header">
            <h2>Restaurant Scolaire</h2>
            <p class="text-muted">Connexion à l'application</p>
        </div>
        
        <?php if (!empty($error)): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        
        <form method="POST">
            <div class="mb-3">
                <label for="username" class="form-label">Nom d'utilisateur</label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Mot de passe</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary mt-3">Se connecter</button>
        </form>
    </div>
</body>
</html>