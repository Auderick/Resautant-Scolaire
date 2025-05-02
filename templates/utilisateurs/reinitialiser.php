<?php
require_once __DIR__ . '/../../includes/header.php';
require_once __DIR__ . '/../../src/Models/utilisateur.php';

// Vérifier que l'utilisateur est admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: /compte_restaurant_scolaire/index.php');
    exit;
}

// Récupérer l'ID de l'utilisateur
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($id <= 0) {
    $_SESSION['message'] = 'ID utilisateur invalide';
    $_SESSION['message_type'] = 'danger';
    header('Location: index.php');
    exit;
}

$error = '';
$success = '';
$utilisateur = new Utilisateur($db);
$user = $utilisateur->getById($id);

if (!$user) {
    $_SESSION['message'] = 'Utilisateur non trouvé';
    $_SESSION['message_type'] = 'danger';
    header('Location: index.php');
    exit;
}

// Traitement du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $password = isset($_POST['password']) ? trim($_POST['password']) : '';
    $password_confirm = isset($_POST['password_confirm']) ? trim($_POST['password_confirm']) : '';

    // Validation
    if (empty($password) || empty($password_confirm)) {
        $error = 'Les deux champs sont obligatoires';
    } elseif ($password !== $password_confirm) {
        $error = 'Les mots de passe ne correspondent pas';
    } elseif (strlen($password) < 6) {
        $error = 'Le mot de passe doit contenir au moins 6 caractères';
    } else {
        // Changer le mot de passe
        if ($utilisateur->changerMotDePasse($id, $password)) {
            $_SESSION['message'] = 'Mot de passe réinitialisé avec succès';
            $_SESSION['message_type'] = 'success';
            header('Location: index.php');
            exit;
        } else {
            $error = 'Erreur lors de la réinitialisation du mot de passe';
        }
    }
}
?>

<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-info text-white">
                    <h2 class="card-title mb-0">Réinitialiser le mot de passe</h2>
                </div>
                <div class="card-body">
                    <div class="alert alert-info">
                        <strong>Utilisateur :</strong> <?= htmlspecialchars($user['username']) ?> (<?= htmlspecialchars($user['prenom'] . ' ' . $user['nom']) ?>)
                    </div>
                    
                    <?php if ($error): ?>
                        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
                    <?php endif; ?>
                    <?php if ($success): ?>
                        <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
                    <?php endif; ?>
                    
                    <form method="POST">
                        <div class="mb-3">
                            <label for="password" class="form-label">Nouveau mot de passe*</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="password_confirm" class="form-label">Confirmer le mot de passe*</label>
                            <input type="password" class="form-control" id="password_confirm" name="password_confirm" required>
                        </div>
                        
                        <div class="d-flex justify-content-between">
                            <a href="index.php" class="btn btn-secondary">Annuler</a>
                            <button type="submit" class="btn btn-info">Réinitialiser le mot de passe</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>