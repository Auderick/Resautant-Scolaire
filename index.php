<?php
require_once __DIR__ . '/includes/header.php';

?>

<div class="container">
    <h1 class="text-center mb-5">Gestion Restaurant Scolaire</h1>

    <div class="row justify-content-center g-4">
        <div class="col-md-4">
            <a href="templates/ventes/index.php" class="card h-100 text-decoration-none">
                <div class="card-body text-center">
                    <h2 class="card-title">Ventes</h2>
                    <p class="card-text">Gérer les ventes de repas</p>
                </div>
            </a>
        </div>

        <div class="col-md-4">
            <a href="templates/achats/index.php" class="card h-100 text-decoration-none">
                <div class="card-body text-center">
                    <h2 class="card-title">Achats</h2>
                    <p class="card-text">Gérer les achats fournisseurs</p>
                </div>
            </a>
        </div>

        <div class="col-md-4">
            <a href="templates/stocks/index.php" class="card h-100 text-decoration-none">
                <div class="card-body text-center">
                    <h2 class="card-title">Stocks</h2>
                    <p class="card-text">Gérer les stocks</p>
                </div>
            </a>
        </div>
        <div class="col-md-4">
            <a href="templates/syntheses/index.php" class="card h-100 text-decoration-none">
                <div class="card-body text-center">
                    <h2 class="card-title">Synthèse</h2>
                    <p class="card-text">Voir les rapports</p>
                </div>
            </a>
        </div>
        <div class="col-md-4">
            <a href="menus/index.html" class="card h-100 text-decoration-none" target="_blank">
                <div class="card-body text-center">
                    <h2 class="card-title">Menus</h2>
                    <p class="card-text">Voir les menus</p>
                </div>
            </a>
        </div>
        <div class="col-md-4">
            <a href="templates/commandes/index.php" class="card h-100 text-decoration-none">
                <div class="card-body text-center">
                    <h2 class="card-title">Commandes</h2>
                    <p class="card-text">Gérer les commandes fournisseurs</p>
                </div>
            </a>
        </div>
    </div>
</div>
<?php require_once __DIR__ . '/includes/footer.php'; ?>