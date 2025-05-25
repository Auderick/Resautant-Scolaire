<?php
require_once __DIR__ . '/../../includes/header.php';
require_once __DIR__ . '/../../src/Models/utilisateur.php';

// Vérifier que l'utilisateur est admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: /index.php');
    exit;
}

// Récupérer l'ID de l'utilisateur à modifier
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
    $nom = isset($_POST['nom']) ? trim($_POST['nom']) : '';
    $prenom = isset($_POST['prenom']) ? trim($_POST['prenom']) : '';
    $role = isset($_POST['role']) ? trim($_POST['role']) : 'user';

    // Validation
    if (empty($nom) || empty($prenom)) {
        $error = 'Les champs Nom et Prénom sont obligatoires';
    } else {
        // Modifier l'utilisateur
        if ($utilisateur->modifier($id, $nom, $prenom, $role)) {
            $_SESSION['message'] = 'Utilisateur modifié avec succès';
            $_SESSION['message_type'] = 'success';
            header('Location: index.php');
            exit;
        } else {
            $error = 'Erreur lors de la modification de l\'utilisateur';
        }
    }
}
?>

<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-warning text-dark">
                    <h2 class="card-title mb-0">Modifier l'utilisateur</h2>
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
                            <label class="form-label">Nom d'utilisateur</label>
                            <input type="text" class="form-control" value="<?= htmlspecialchars($user['username']) ?>" disabled>
                            <div class="form-text">Le nom d'utilisateur ne peut pas être modifié</div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col">
                                <label for="nom" class="form-label">Nom*</label>
                                <input type="text" class="form-control" id="nom" name="nom" value="<?= htmlspecialchars($user['nom']) ?>" required>
                            </div>
                            <div class="col">
                                <label for="prenom" class="form-label">Prénom*</label>
                                <input type="text" class="form-control" id="prenom" name="prenom" value="<?= htmlspecialchars($user['prenom']) ?>" required>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="role" class="form-label">Rôle*</label>
                            <select class="form-select" id="role" name="role" required>
                                <option value="user" <?= $user['role'] === 'user' ? 'selected' : '' ?>>Utilisateur</option>
                                <option value="admin" <?= $user['role'] === 'admin' ? 'selected' : '' ?>>Administrateur</option>
                            </select>
                        </div>
                        
                        <div class="d-flex justify-content-between">
                            <a href="index.php" class="btn btn-secondary">Annuler</a>
                            <button type="submit" class="btn btn-warning">Modifier l'utilisateur</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>