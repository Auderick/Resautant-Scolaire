function modifierVente(id) {
    // Vérifier les droits d'édition
    if (typeof window.hasEditPermission !== 'undefined' && !window.hasEditPermission) {
        alert("Vous n'avez pas les droits nécessaires pour modifier les ventes.");
        return;
    }
    console.log('Tentative de modification de la vente:', id);
    // Utilisation du chemin absolu depuis la racine du site
    fetch(`/api/ventes.php?id=${id}`)
        .then(response => {
            console.log('Statut de la réponse:', response.status);
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            console.log('Données reçues:', data);
            if (!data) {
                throw new Error('Aucune donnée trouvée');
            }

            // Remplissage des champs du formulaire
            const fields = {
                'modif_id': data.id,
                'modif_nb_repas': data.nb_repas,
                'modif_prix_unitaire': data.prix_unitaire,
                'modif_date_vente': data.date_vente
            };

            // Vérification de l'existence des champs avant remplissage
            for (const [id, value] of Object.entries(fields)) {
                const element = document.getElementById(id);
                if (element) {
                    console.log(`Remplissage du champ ${id}:`, value);
                    element.value = value;
                } else {
                    console.error(`Élément non trouvé: ${id}`);
                }
            }

            // Formatage de la date si elle existe
            if (data.date_vente) {
                const date = new Date(data.date_vente);
                if (!isNaN(date.getTime())) {
                    const dateString = date.toISOString().slice(0, 16);
                    const dateElement = document.getElementById('modif_date_vente');
                    if (dateElement) {
                        dateElement.value = dateString;
                    }
                }
            }

            // Vérification de l'existence du modal
            const modalElement = document.getElementById('modalModifier');
            if (!modalElement) {
                throw new Error('Modal non trouvé dans le DOM');
            }

            // Affichage du modal
            const modalModifier = new bootstrap.Modal(modalElement);
            modalModifier.show();
        })
        .catch(error => {
            console.error('Erreur détaillée:', error);
            console.error('Stack trace:', error.stack);
            alert('Erreur lors de la modification de la vente: ' + error.message);
        });
}

function supprimerVente(id) {
    // Vérifier les droits d'édition
    if (typeof window.hasEditPermission !== 'undefined' && !window.hasEditPermission) {
        alert("Vous n'avez pas les droits nécessaires pour modifier les ventes.");
        return;
    }
    if (!id || isNaN(id)) {
        alert('ID de vente invalide');
        return;
    }

    if (confirm('Êtes-vous sûr de vouloir supprimer cette vente ?')) {
        try {
            const form = document.createElement('form');
            form.method = 'POST';
            form.innerHTML = `
                <input type="hidden" name="action" value="supprimer">
                <input type="hidden" name="id" value="${parseInt(id)}">
            `;
            document.body.appendChild(form);
            form.submit();
        } catch (error) {
            console.error('Erreur lors de la suppression:', error);
            alert('Erreur lors de la suppression de la vente');
        }
    }
}

function imprimerVentes() {
    // Créer une nouvelle fenêtre pour l'impression
    const printWindow = window.open('', '_blank');

    // Récupérer le tableau des ventes
    const tableau = document.querySelector('.table').cloneNode(true);

    // Masquer la colonne des actions pour l'impression
    const actionCells = tableau.querySelectorAll('th:last-child, td:last-child');
    actionCells.forEach(cell => cell.remove());

    // Calculer le total général
    let totalGeneral = 0;
    const rows = tableau.querySelectorAll('tbody tr');
    rows.forEach(row => {
        const nbRepas = parseFloat(row.cells[1].textContent.replace(/[^\d.-]/g, ''));
        const prixUnitaire = parseFloat(row.cells[2].textContent.replace(/[^\d.-]/g, ''));
        if (!isNaN(nbRepas) && !isNaN(prixUnitaire)) {
            totalGeneral += nbRepas * prixUnitaire;
        }
    });

    // Formater le total avec le séparateur de milliers
    const totalFormate = new Intl.NumberFormat('fr-FR', {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2
    }).format(totalGeneral);

    // Obtenir le mois courant en français
    const date = new Date();
    const mois = new Intl.DateTimeFormat('fr-FR', { month: 'long' }).format(date);
    const annee = date.getFullYear();

    // Mettre la première lettre en majuscule
    const moisCapitalized = mois.charAt(0).toUpperCase() + mois.slice(1);

    // Créer le contenu HTML à imprimer
    const html = `
        <!DOCTYPE html>
        <html>
        <head>
            <title>Liste des Ventes - ${moisCapitalized} ${annee}</title>
            <!-- Bootstrap est déjà chargé globalement -->
            <style>
                body { 
                    padding: 20px;
                    font-family: Arial, sans-serif;
                }
                @media print {
                    @page {
                        margin: 0.5cm;
                        size: portrait; /* Format portrait pour économiser du papier */
                    }
                    html {
                        height: 99%; /* Cette ligne est la clé pour masquer l'URL */
                    }
                    .no-print { 
                        display: none; 
                    }
                    table { 
                        width: 100%;
                        border-collapse: collapse;
                        margin-bottom: 20px;
                    }
                    th, td { 
                        padding: 12px;
                        border: 1px solid #ddd;
                        text-align: left;
                    }
                    th { 
                        background-color: #f5f5f5 !important;
                        font-weight: bold;
                    }
                    .total-general {
                        margin-top: 20px;
                        font-weight: bold;
                        font-size: 1.2em;
                    }
                }
            </style>
        </head>
        <body>
            <div class="container">
                <h1 class="text-center mb-4">Liste des Ventes - ${moisCapitalized} ${annee}</h1>
                <div class="table-responsive">
                    ${tableau.outerHTML}
                </div>
                <div class="total-general text-end">
                    Total Général : ${totalFormate} €
                </div>
                <div class="text-center mt-4 no-print">
                    <button class="btn btn-primary" onclick="window.print();return false;">
                        Imprimer
                    </button>
                </div>
            </div>
            <script>
                // Imprimer automatiquement
                window.onload = function() {
                    setTimeout(function() {
                        window.print();
                    }, 500);
                };
            </script>
        </body>
        </html>
    `;

    // Écrire le contenu dans la nouvelle fenêtre
    printWindow.document.write(html);
    printWindow.document.close();
}