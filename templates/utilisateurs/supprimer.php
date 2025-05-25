<?php
require_once __DIR__ . '/../../includes/header.php';
require_once __DIR__ . '/../../src/Models/utilisateur.php';

// Vérifier que l'utilisateur est admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: /index.php');
    exit;
}

// Vérifier qu'on ne supprime pas son propre compte
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($id <= 0) {
    $_SESSION['message'] = 'ID utilisateur invalide';
    $_SESSION['message_type'] = 'danger';
    header('Location: index.php');
    exit;
}

if ($id === $_SESSION['user_id']) {
    $_SESSION['message'] = 'Vous ne pouvez pas supprimer votre propre compte';
    $_SESSION['message_type'] = 'danger';
    header('Location: index.php');
    exit;
}

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
    $confirmation = isset($_POST['confirmation']) ? $_POST['confirmation'] : '';

    if ($confirmation === 'oui') {
        // Supprimer l'utilisateur
        if ($utilisateur->supprimer($id)) {
            $_SESSION['message'] = 'Utilisateur supprimé avec succès';
            $_SESSION['message_type'] = 'success';
            header('Location: index.php');
            exit;
        } else {
            $_SESSION['message'] = 'Erreur lors de la suppression de l\'utilisateur. Si c\'est le dernier administrateur, il ne peut pas être supprimé.';
            $_SESSION['message_type'] = 'danger';
            header('Location: index.php');
            exit;
        }
    } else {
        header('Location: index.php');
        exit;
    }
}
?>

<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-danger text-white">
                    <h2 class="card-title mb-0">Supprimer l'utilisateur</h2>
                </div>
                <div class="card-body">
                    <div class="alert alert-warning">
                        <h4 class="alert-heading">Attention !</h4>
                        <p>Vous êtes sur le point de supprimer l'utilisateur :</p>
                        <p><strong><?= htmlspecialchars($user['username']) ?></strong> (<?= htmlspecialchars($user['prenom'] . ' ' . $user['nom']) ?>)</p>
                        <p>Cette action est irréversible.</p>
                    </div>
                    
                    <form method="POST">
                        <input type="hidden" name="confirmation" value="oui">
                        
                        <div class="d-flex justify-content-between">
                            <a href="index.php" class="btn btn-secondary">Annuler</a>
                            <button type="submit" class="btn btn-danger">Confirmer la suppression</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>