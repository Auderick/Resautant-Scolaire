<?php
require_once __DIR__ . '/../../includes/header.php';
require_once __DIR__ . '/../../src/Models/utilisateur.php';

// Vérifier que l'utilisateur est admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: /index.php');
    exit;
}

$error = '';
$success = '';

// Traitement du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = isset($_POST['username']) ? trim($_POST['username']) : '';
    $password = isset($_POST['password']) ? trim($_POST['password']) : '';
    $password_confirm = isset($_POST['password_confirm']) ? trim($_POST['password_confirm']) : '';
    $nom = isset($_POST['nom']) ? trim($_POST['nom']) : '';
    $prenom = isset($_POST['prenom']) ? trim($_POST['prenom']) : '';
    $role = isset($_POST['role']) ? trim($_POST['role']) : 'user';

    // Validation
    if (empty($username) || empty($password) || empty($password_confirm) || empty($nom) || empty($prenom)) {
        $error = 'Tous les champs sont obligatoires';
    } elseif ($password !== $password_confirm) {
        $error = 'Les mots de passe ne correspondent pas';
    } else {
        $utilisateur = new Utilisateur($db);

        // Vérifier si le nom d'utilisateur existe déjà
        if ($utilisateur->usernameExiste($username)) {
            $error = 'Ce nom d\'utilisateur existe déjà';
        } else {
            // Ajouter l'utilisateur
            if ($utilisateur->ajouter($username, $password, $nom, $prenom, $role)) {
                $_SESSION['message'] = 'Utilisateur ajouté avec succès';
                $_SESSION['message_type'] = 'success';
                header('Location: index.php');
                exit;
            } else {
                $error = 'Erreur lors de l\'ajout de l\'utilisateur';
            }
        }
    }
}
?>

<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h2 class="card-title mb-0">Ajouter un utilisateur</h2>
                </div>
                <div class="card-body">
                    <?php if ($error): ?>
                        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
                    <?php endif; ?>
                    <?php if ($success): ?>
                        <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
                    <?php endif; ?>
                    
                    <form method="POST">
                        <div class="mb-3">
                            <label for="username" class="form-label">Nom d'utilisateur*</label>
                            <input type="text" class="form-control" id="username" name="username" required>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col">
                                <label for="nom" class="form-label">Nom*</label>
                                <input type="text" class="form-control" id="nom" name="nom" required>
                            </div>
                            <div class="col">
                                <label for="prenom" class="form-label">Prénom*</label>
                                <input type="text" class="form-control" id="prenom" name="prenom" required>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="role" class="form-label">Rôle*</label>
                            <select class="form-select" id="role" name="role" required>
                                <option value="user">Utilisateur</option>
                                <option value="admin">Administrateur</option>
                            </select>
                        </div>
                        
                        <div class="mb-3">
                            <label for="password" class="form-label">Mot de passe*</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="password_confirm" class="form-label">Confirmer le mot de passe*</label>
                            <input type="password" class="form-control" id="password_confirm" name="password_confirm" required>
                        </div>
                        
                        <div class="d-flex justify-content-between">
                            <a href="index.php" class="btn btn-secondary">Annuler</a>
                            <button type="submit" class="btn btn-primary">Ajouter l'utilisateur</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>