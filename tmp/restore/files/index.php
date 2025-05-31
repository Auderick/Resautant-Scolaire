<?php
require_once __DIR__ . '/includes/header.php';
?>

<div class="container">
    <h1 class="text-center mb-5">Gestion Restaurant Scolaire</h1>

    <div class="row justify-content-center g-4">
        <!-- Menus -->
        <div class="col-md-4">
            <a href="<?php echo getFullUrl('templates/menus/index.php'); ?>" class="card h-100 text-decoration-none">
                <div class="card-body text-center">
                    <h2 class="card-title">Menus</h2>
                    <p class="card-text">Gérer les menus</p>
                </div>
            </a>
        </div>

        <!-- Commandes -->
        <div class="col-md-4">
            <a href="<?php echo getFullUrl('templates/commandes/index.php'); ?>" class="card h-100 text-decoration-none">
                <div class="card-body text-center">
                    <h2 class="card-title">Commandes</h2>
                    <p class="card-text">Gérer les commandes fournisseurs</p>
                </div>
            </a>
        </div>

        <!-- Ventes -->
        <div class="col-md-4">
            <a href="<?php echo getFullUrl('templates/ventes/index.php'); ?>" class="card h-100 text-decoration-none">
                <div class="card-body text-center">
                    <h2 class="card-title">Ventes</h2>
                    <p class="card-text">Gérer les ventes de repas</p>
                </div>
            </a>
        </div>

        <!-- Achats -->
        <div class="col-md-4">
            <a href="<?php echo getFullUrl('templates/achats/index.php'); ?>" class="card h-100 text-decoration-none">
                <div class="card-body text-center">
                    <h2 class="card-title">Achats</h2>
                    <p class="card-text">Gérer les achats fournisseurs</p>
                </div>
            </a>
        </div>

        <!-- Stocks -->
        <div class="col-md-4">
            <a href="<?php echo getFullUrl('templates/stocks/index.php'); ?>" class="card h-100 text-decoration-none">
                <div class="card-body text-center">
                    <h2 class="card-title">Stocks</h2>
                    <p class="card-text">Gérer les stocks</p>
                </div>
            </a>
        </div>

        <!-- Synthèses -->
        <div class="col-md-4">
            <a href="<?php echo getFullUrl('templates/syntheses/index.php'); ?>" class="card h-100 text-decoration-none">
                <div class="card-body text-center">
                    <h2 class="card-title">Synthèses</h2>
                    <p class="card-text">Voir les rapports</p>
                </div>
            </a>
        </div>

        <!-- Présences -->
        <div class="col-md-4">
            <a href="<?php echo getFullUrl('templates/presences/index.php'); ?>" class="card h-100 text-decoration-none">
                <div class="card-body text-center">
                    <h2 class="card-title">Présences</h2>
                    <p class="card-text">Gérer les présences quotidiennes</p>
                </div>
            </a>
        </div>

        <!-- Gestion des utilisateurs -->
        <div class="col-md-4">
            <a href="<?php echo getFullUrl('templates/utilisateurs/index.php'); ?>" class="card h-100 text-decoration-none">
                <div class="card-body text-center">
                    <h2 class="card-title">Utilisateurs</h2>
                    <p class="card-text">Gérer les utilisateurs</p>
                </div>
            </a>
        </div>

        <!-- HACCP -->
        <div class="col-md-4">
            <a href="<?php echo getFullUrl('templates/haccp/index.php'); ?>" class="card h-100 text-decoration-none">
                <div class="card-body text-center">
                    <h2 class="card-title">HACCP</h2>
                    <p class="card-text">Gestion des documents HACCP</p>
                </div>
            </a>
        </div>
    </div>
</div>
<?php require_once __DIR__ . '/includes/footer.php'; ?>