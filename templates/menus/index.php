<?php

require_once __DIR__ . '/../../includes/header.php';
require_once __DIR__ . '/../../src/Models/menu.php';

$menuModel = new Menu();
$semaines = $menuModel->getSemaines();
$semaineActive = $menuModel->getSemaineActive();

// Gestion des actions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        if ($_POST['action'] === 'delete' && isset($_POST['id'])) {
            $menuModel->deleteSemaine($_POST['id']);
            header('Location: index.php?message=La semaine a été supprimée');
            exit;
        } elseif ($_POST['action'] === 'activate' && isset($_POST['id'])) {
            $menuModel->setActive($_POST['id']);
            header('Location: index.php?message=La semaine a été activée');
            exit;
        }
    }
}

$message = isset($_GET['message']) ? $_GET['message'] : null;
?>

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Gestion des Menus</h1>
        <a href="editer.php" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Nouveau Menu
        </a>
    </div>

    <?php if ($message): ?>
    <div class="alert alert-success">
        <?= htmlspecialchars($message) ?>
    </div>
    <?php endif; ?>

    <div class="card mb-4">
        <div class="card-header">
            <h2 class="card-title h5 mb-0">Semaines de menus</h2>
        </div>
        <div class="card-body">
            <?php if (empty($semaines)): ?>
            <p class="text-center text-muted">Aucun menu n'a encore été créé.</p>
            <?php else: ?>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Semaine</th>
                            <th>Période</th>
                            <th>Statut</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($semaines as $semaine): ?>
                        <tr>
                            <td>Semaine
                                <?= htmlspecialchars($semaine['numero_semaine']) ?>
                                de
                                <?= htmlspecialchars($semaine['annee']) ?>
                            </td>
                            <td>
                                <?= date('d/m/Y', strtotime($semaine['date_debut'])) ?>
                                au
                                <?= date('d/m/Y', strtotime($semaine['date_fin'])) ?>
                            </td>
                            <td>
                                <?php if ($semaine['active']): ?>
                                <span class="badge bg-success">Actif</span>
                                <?php else: ?>
                                <span class="badge bg-secondary">Inactif</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <div class="btn-group">
                                    <a href="editer.php?id=<?= $semaine['id'] ?>"
                                        class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-pencil"></i> Éditer
                                    </a>
                                    <!-- Ajoutez ces deux boutons ici -->
                                    <button type="button" class="btn btn-sm btn-outline-info"
                                        onclick="imprimerMenu(<?= $semaine['id'] ?>)">
                                        <i class="bi bi-printer"></i> Imprimer
                                    </button>
                                    <button type="button" class="btn btn-sm btn-outline-success"
                                        onclick="telechargerMenu(<?= $semaine['id'] ?>)">
                                        <i class="bi bi-download"></i> PDF
                                    </button>
                                    <!-- Fin des boutons ajoutés -->
                                    <?php if (!$semaine['active']): ?>
                                    <form method="post" class="d-inline">
                                        <input type="hidden" name="action" value="activate">
                                        <input type="hidden" name="id"
                                            value="<?= $semaine['id'] ?>">
                                        <button type="submit" class="btn btn-sm btn-outline-success">
                                            <i class="bi bi-check-circle"></i> Activer
                                        </button>
                                    </form>
                                    <?php endif; ?>
                                    <form method="post" class="d-inline"
                                        onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette semaine de menu ?')">
                                        <input type="hidden" name="action" value="delete">
                                        <input type="hidden" name="id"
                                            value="<?= $semaine['id'] ?>">
                                        <button type="submit" class="btn btn-sm btn-outline-danger">
                                            <i class="bi bi-trash"></i> Supprimer
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <?php endif; ?>
        </div>
    </div>

    <div class="card">
        <div class="card-header bg-light">
            <h3 class="card-title h5 mb-0">Aperçu du menu courant</h3>
        </div>
        <div class="card-body">
            <p>Visualisez le menu actif tel qu'il sera imprimé.</p>
            <?php if ($semaineActive): ?>
            <button class="btn btn-info"
                onclick="imprimerMenu(<?= $semaineActive['id'] ?>)">
                <i class="bi bi-eye"></i> Voir le menu actif
            </button>
            <?php else: ?>
            <p class="text-muted">Aucun menu actif actuellement.</p>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>