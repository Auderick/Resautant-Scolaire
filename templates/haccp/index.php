<?php
require_once __DIR__ . '/../../includes/header.php';
require_once __DIR__ . '/../../includes/auth_check.php';
?>

<div class="container">
    <h1 class="text-center mb-4">Gestion HACCP</h1>

    <?php if (isset($_SESSION['success_message'])): ?>
    <div class="alert alert-success">
        <?php
            echo $_SESSION['success_message'];
        unset($_SESSION['success_message']);
        ?>
    </div>
    <?php endif; ?>

    <?php if (isset($_SESSION['error_message'])): ?>
    <div class="alert alert-danger">
        <?php
        echo $_SESSION['error_message'];
        unset($_SESSION['error_message']);
        ?>
    </div>
    <?php endif; ?>

    <div class="alert alert-info">
        <h4>Comment utiliser le système HACCP ?</h4>
        <ol>
            <li><strong>Modèles de documents :</strong>
                <div class="alert alert-info">
                    <h6 class="mb-0"><i class="fas fa-info-circle"></i> Comment utiliser les modèles :</h6>
                    <ol class="mb-0 small">
                        <li>Cliquez sur "Ouvrir pour imprimer"</li>
                        <li>Le document s'ouvrira dans un nouvel onglet</li>
                        <li>Une fenêtre d'impression s'ouvrira automatiquement</li>
                        <li>Imprimez directement ou enregistrez en PDF</li>
                    </ol>
                </div>
            </li>
            <li><strong>Pour ajouter un document :</strong>
                <ul>
                    <li>Choisissez la catégorie appropriée</li>
                    <li>Sélectionnez votre fichier PDF</li>
                    <li>Cliquez sur "Téléverser"</li>
                </ul>
            </li>
        </ol>
    </div>

    <div class="row mb-4">
        <!-- Bouton pour téléverser un nouveau document -->
        <div class="col-md-4">
            <div class="card border-primary">
                <div class="card-body">
                    <h5 class="card-title text-primary">Ajouter un nouveau document</h5>
                    <form action="upload.php" method="post" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="category" class="form-label">Catégorie</label> <select class="form-select"
                                name="category" id="category" required>
                                <option value="distribution">Contrôle Distribution</option>
                                <option value="temperatures">Relevés de températures</option>
                                <option value="refroidissement">Refroidissement et remise en T°</option>
                                <option value="nettoyage">Plan de nettoyage</option>
                                <option value="tracabilite">Traçabilité</option>
                                <option value="autres">Autres documents</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="file" class="form-label">Fichier</label>
                            <input type="file" class="form-control" name="file" id="file" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Téléverser</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modèles de documents -->
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Modèles de documents</h5>
                    <div class="list-group">
                        <div class="list-group-item">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <i class="fas fa-thermometer-half"></i> Relevé des Températures
                                </div>
                                <div>
                                    <a href="templates/temperature.html" class="btn btn-sm btn-primary" target="_blank">
                                        <i class="fas fa-print"></i> Ouvrir pour imprimer
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="list-group-item">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <i class="fas fa-temperature-high"></i> Refroidissement et remise en T°
                                </div>
                                <div>
                                    <a href="templates/refroidissement.html" class="btn btn-sm btn-primary"
                                        target="_blank">
                                        <i class="fas fa-print"></i> Ouvrir pour imprimer
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="list-group-item">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <i class="fas fa-utensils"></i> Contrôle Distribution
                                </div>
                                <div>
                                    <a href="templates/distribution.html" class="btn btn-sm btn-primary"
                                        target="_blank">
                                        <i class="fas fa-print"></i> Ouvrir pour imprimer
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="list-group-item">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <i class="fas fa-broom"></i> Plan de Nettoyage
                                </div>
                                <div>
                                    <a href="templates/nettoyage.html" class="btn btn-sm btn-primary" target="_blank">
                                        <i class="fas fa-print"></i> Ouvrir pour imprimer
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="list-group-item">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <i class="fas fa-search"></i> Fiche de Traçabilité
                                </div>
                                <div>
                                    <a href="templates/tracabilite.html" class="btn btn-sm btn-primary" target="_blank">
                                        <i class="fas fa-print"></i> Ouvrir pour imprimer
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- Liste des documents -->
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Documents HACCP enregistrés</h5>

            <!-- Filtres -->
            <div class="row mb-3 align-items-end">
                <div class="col-md-4">
                    <label for="filterCategory" class="form-label">Filtrer par catégorie :</label>
                    <select class="form-select" id="filterCategory">
                        <option value="">Toutes les catégories</option>
                        <option value="temperatures">Relevés de températures</option>
                        <option value="refroidissement">Refroidissement et remise en T°</option>
                        <option value="distribution">Contrôle Distribution</option>
                        <option value="nettoyage">Plan de nettoyage</option>
                        <option value="tracabilite">Traçabilité</option>
                        <option value="autres">Autres documents</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="filterDate" class="form-label">Filtrer par date :</label>
                    <input type="month" class="form-control" id="filterDate">
                </div>
                <div class="col-md-4">
                    <button class="btn btn-outline-secondary" onclick="loadDocuments()">
                        <i class="fas fa-sync-alt"></i> Actualiser la liste
                    </button>
                </div>
            </div>

            <!-- Tableau des documents -->
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Nom du document</th>
                            <th>Catégorie</th>
                            <th>Date d'ajout</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="documentsTable">
                        <!-- Les documents seront chargés ici via JavaScript -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal de prévisualisation -->
<div class="modal fade" id="previewModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Prévisualisation du document</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <iframe id="previewFrame" style="width: 100%; height: 600px;"></iframe>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Chargement initial des documents
        loadDocuments();

        // Gestionnaire des filtres
        document.getElementById('filterCategory').addEventListener('change', loadDocuments);
        document.getElementById('filterDate').addEventListener('change', loadDocuments);

        function loadDocuments() {
            const category = document.getElementById('filterCategory').value;
            const date = document.getElementById('filterDate').value; // Appel AJAX pour charger les documents
            fetch(`list_documents.php?category=${category}&date=${date}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Erreur réseau');
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('Documents reçus:', data); // Pour le débogage
                    const tbody = document.getElementById('documentsTable');
                    tbody.innerHTML = '';

                    data.forEach(doc => {
                        const tr = document.createElement('tr');
                        const docPath = encodeURI(doc.path);
                        tr.innerHTML = `
                        <td>${doc.name}</td>
                        <td>${doc.category}</td>
                        <td>${doc.date}</td>
                        <td>
                            <button class="btn btn-sm btn-primary preview-btn" data-path="${docPath}" title="Prévisualiser">
                                <i class="fas fa-eye"></i> Voir
                            </button>
                            <a href="${docPath}" class="btn btn-sm btn-success" download title="Télécharger">
                                <i class="fas fa-download"></i> Télécharger
                            </a>
                            <button class="btn btn-sm btn-danger delete-btn" data-id="${doc.id}" title="Supprimer">
                                <i class="fas fa-trash"></i> Supprimer
                            </button>
                        </td>
                    `;
                        tbody.appendChild(tr);
                    });

                    // Gestionnaire de prévisualisation
                    document.querySelectorAll('.preview-btn').forEach(btn => {
                        btn.addEventListener('click', function() {
                            const path = this.dataset.path;
                            document.getElementById('previewFrame').src = path;
                            new bootstrap.Modal(document.getElementById('previewModal'))
                                .show();
                        });
                    }); // Gestionnaire de suppression
                    document.querySelectorAll('.delete-btn').forEach(btn => {
                        btn.addEventListener('click', function() {
                            if (confirm('Voulez-vous vraiment supprimer ce document ?')) {
                                const id = this.dataset.id;

                                const formData = new FormData();
                                formData.append('_method', 'DELETE');

                                fetch(`delete_document.php?id=${id}`, {
                                        method: 'POST',
                                        body: formData
                                    })
                                    .then(response => {
                                        if (!response.ok) {
                                            throw new Error(
                                                'Erreur lors de la suppression');
                                        }
                                        return response.json();
                                    })
                                    .then(data => {
                                        if (data.success) {
                                            loadDocuments();
                                        } else {
                                            alert(data.error ||
                                                'Erreur lors de la suppression');
                                        }
                                    })
                                    .catch(error => {
                                        console.error('Erreur:', error);
                                        alert(
                                            'Erreur lors de la suppression du document'
                                            );
                                    });
                            }
                        });
                    });
                });
        }
    });
</script>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>