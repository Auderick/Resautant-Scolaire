<?php
require_once __DIR__ . '/../../includes/header.php';
require_once __DIR__ . '/../../src/Models/utilisateur.php';

// Vérifier que l'utilisateur est admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: /compte_restaurant_scolaire/index.php');
    exit;
}

$utilisateur = new Utilisateur($db);
$utilisateurs = $utilisateur->getAll();

// Message de succès/erreur
$message = isset($_SESSION['message']) ? $_SESSION['message'] : '';
$message_type = isset($_SESSION['message_type']) ? $_SESSION['message_type'] : '';
unset($_SESSION['message']);
unset($_SESSION['message_type']);
?>

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Gestion des utilisateurs</h1>
        <a href="ajouter.php" class="btn btn-primary">
            <i class="fas fa-plus"></i> Ajouter un utilisateur
        </a>
    </div>
    
    <?php if ($message): ?>
        <div class="alert alert-<?= $message_type ?> alert-dismissible fade show">
            <?= htmlspecialchars($message) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>
    
    <div class="card">
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nom d'utilisateur</th>
                        <th>Nom</th>
                        <th>Prénom</th>
                        <th>Rôle</th>
                        <th>Date de création</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($utilisateurs as $user): ?>
                    <tr>
                        <td><?= htmlspecialchars($user['id']) ?></td>
                        <td><?= htmlspecialchars($user['username']) ?></td>
                        <td><?= htmlspecialchars($user['nom']) ?></td>
                        <td><?= htmlspecialchars($user['prenom']) ?></td>
                        <td>
                            <span class="badge <?= $user['role'] === 'admin' ? 'bg-danger' : 'bg-primary' ?>">
                                <?= htmlspecialchars($user['role']) ?>
                            </span>
                        </td>
                        <td><?= htmlspecialchars($user['created_at']) ?></td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <a href="modifier.php?id=<?= $user['id'] ?>" class="btn btn-warning">
                                    <i class="fas fa-edit"></i> Modifier
                                </a>
                                <a href="reinitialiser.php?id=<?= $user['id'] ?>" class="btn btn-info">
                                    <i class="fas fa-key"></i> Réinitialiser MDP
                                </a>
                                <?php if ($user['id'] != $_SESSION['user_id']): ?>
                                <a href="supprimer.php?id=<?= $user['id'] ?>" class="btn btn-danger">
                                    <i class="fas fa-trash"></i> Supprimer
                                </a>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>