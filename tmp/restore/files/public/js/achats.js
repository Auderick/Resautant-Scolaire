// Fonction pour calculer le montant total dans le formulaire d'ajout
function calculerMontantTotal() {
    const quantite = parseFloat(document.getElementById('quantite').value) || 0;
    const prix = parseFloat(document.getElementById('prix_unitaire').value) || 0;
    const montant = quantite * prix;
    document.getElementById('montant').value = montant.toFixed(2);
}

// Fonction pour calculer le montant total dans le formulaire de modification
function calculerMontantTotalModif() {
    const quantite = parseFloat(document.getElementById('modif_quantite').value) || 0;
    const prix = parseFloat(document.getElementById('modif_prix_unitaire').value) || 0;
    const montant = quantite * prix;
    document.getElementById('modif_montant').value = montant.toFixed(2);
}

// Vérifier si l'utilisateur a les droits d'édition
function modifierAchat(id) {
    try {
        // Vérifier les droits d'édition
        if (typeof window.hasEditPermission !== 'undefined' && !window.hasEditPermission) {
            alert("Vous n'avez pas les droits nécessaires pour modifier les achats.");
            return;
        }

        // Ajouter des logs pour déboguer
        console.log("Récupération de l'achat ID:", id);

        fetch(`/api/achats.php?id=${id}`)
            .then(response => {
                console.log("Réponse de l'API reçue");
                if (!response.ok) {
                    throw new Error('Erreur réseau ou serveur');
                }
                return response.json();
            })
            .then(data => {
                console.log("Données reçues:", data);
                console.log("Éléments HTML trouvés :");
                console.log("modif_id:", document.getElementById('modif_id'));
                console.log("modif_fournisseur:", document.getElementById('modif_fournisseur'));
                console.log("modif_description:", document.getElementById('modif_description'));
                console.log("modif_quantite:", document.getElementById('modif_quantite'));
                console.log("modif_unite:", document.getElementById('modif_unite'));
                console.log("modif_prix_unitaire:", document.getElementById('modif_prix_unitaire'));
                console.log("modif_montant:", document.getElementById('modif_montant'));
                console.log("modif_date_achat:", document.getElementById('modif_date_achat'));

                // Vérifier que tous les champs sont remplis correctement
                document.getElementById('modif_id').value = data.id;
                document.getElementById('modif_fournisseur').value = data.fournisseur || '';
                document.getElementById('modif_description').value = data.description || '';

                // Nouveaux champs - utiliser des valeurs par défaut si null
                document.getElementById('modif_quantite').value = data.quantite !== null ? data.quantite : '0';
                document.getElementById('modif_unite').value = data.unite !== null ? data.unite : '';
                document.getElementById('modif_prix_unitaire').value = data.prix_unitaire !== null ? data.prix_unitaire : '0';

                // Utilisez le montant_total de la base ou calculez-le
                document.getElementById('modif_montant').value = data.montant_total !== null ?
                    parseFloat(data.montant_total).toFixed(2) :
                    (parseFloat(data.quantite || 0) * parseFloat(data.prix_unitaire || 0)).toFixed(2);

                // Formater la date pour l'input datetime-local
                if (data.date_achat) {
                    try {
                        const date = new Date(data.date_achat);
                        if (!isNaN(date.getTime())) {
                            // Format YYYY-MM-DDTHH:MM (requis pour input datetime-local)
                            const dateString = date.toISOString().substring(0, 16);
                            document.getElementById('modif_date_achat').value = dateString;
                        }
                    } catch (e) {
                        console.error("Erreur de formatage de date:", e);
                    }
                }

                // Afficher le modal
                const modalModifier = new bootstrap.Modal(document.getElementById('modalModifier'));
                modalModifier.show();
            })
            .catch(error => {
                console.error("Erreur lors de la récupération des données:", error);
                alert("Une erreur s'est produite lors de la récupération des données.");
            });
    } catch (error) {
        console.error("Erreur dans modifierAchat:", error);
        alert("Une erreur s'est produite dans la fonction de modification.");
    }
}


function supprimerAchat(id) {
    // Vérifier les droits d'édition
    if (typeof window.hasEditPermission !== 'undefined' && !window.hasEditPermission) {
        alert("Vous n'avez pas les droits nécessaires pour supprimer les achats.");
        return;
    }

    if (confirm('Êtes-vous sûr de vouloir supprimer cet achat ?')) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.innerHTML = `
            <input type="hidden" name="action" value="supprimer">
            <input type="hidden" name="id" value="${id}">
        `;
        document.body.appendChild(form);
        form.submit();
    }
}

// La fonction d'impression des achats
// La fonction d'impression reste disponible pour tous les utilisateurs
function imprimerAchats() {
    const printWindow = window.open('', '_blank');

    if (!printWindow) {
        alert("Le navigateur a bloqué l'ouverture de la fenêtre. Veuillez autoriser les popups.");
        return;
    }

    try {
        // Récupérer le tableau des achats
        const tableau = document.querySelector('.table').cloneNode(true);

        // Supprimer la colonne d'actions si elle existe
        const headers = tableau.querySelectorAll('thead th');
        let actionColumnIndex = -1;

        // Rechercher la colonne d'actions
        for (let i = 0; i < headers.length; i++) {
            const headerText = headers[i].textContent.trim();
            if (headerText === 'Actions' || headers[i].querySelector('.btn') !== null) {
                actionColumnIndex = i;
                break;
            }
        }

        // Si une colonne d'actions est trouvée, la supprimer
        if (actionColumnIndex !== -1) {
            // Supprimer l'en-tête
            headers[actionColumnIndex].remove();

            // Supprimer les cellules correspondantes dans le corps du tableau
            const rows = tableau.querySelectorAll('tbody tr');
            rows.forEach(row => {
                if (row.cells.length > actionColumnIndex) {
                    row.cells[actionColumnIndex].remove();
                }
            });
        }

        // IMPORTANT : Ne pas recalculer le total, utiliser celui déjà présent
        // Chercher la ligne avec total général dans le tableau
        const totalRow = tableau.querySelector('tr.table-dark');
        let totalGeneral = '0.00';

        if (totalRow) {
            // Extraire le total du tableau existant
            const totalCell = totalRow.querySelector('td.fw-bold');
            if (totalCell) {
                totalGeneral = totalCell.textContent.trim();
            }
        }

        // Créer le contenu HTML à imprimer
        const html = `
            <!DOCTYPE html>
            <html>
            <head>
                <title>Liste des Achats</title>
                <meta charset="UTF-8">
                <style>
                    body { 
                        padding: 20px;
                        font-family: Arial, sans-serif;
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
                        background-color: #f5f5f5;
                        font-weight: bold;
                    }
                    .commande-header td {
                        background-color: #e9ecef;
                        font-weight: bold;
                    }
                    .from-commande td:first-child {
                        padding-left: 20px;
                    }
                    .table-info td {
                        background-color: #cff4fc;
                    }
                    .table-dark td {
                        background-color: #212529;
                        color: white;
                    }
                    .print-btn {
                        display: block;
                        margin: 20px auto;
                        padding: 10px 20px;
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
                        body {
                            padding: 5px;
                            font-size: 13px;
                        }
                    }
                </style>
            </head>
            <body>
                <h1>Liste des Achats</h1>
                ${tableau.outerHTML}
                <button onclick="window.print()" class="print-btn no-print">
                    Imprimer
                </button>
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

    } catch (error) {
        // Afficher l'erreur dans la fenêtre d'impression
        printWindow.document.write(`
            <html>
            <head><title>Erreur</title></head>
            <body>
                <h1>Une erreur s'est produite lors de l'impression</h1>
                <p>${error.message}</p>
                <button onclick="window.close()">Fermer</button>
            </body>
            </html>
        `);
        printWindow.document.close();
        console.error('Erreur lors de l\'impression:', error);
    }
}
// Initialisation des écouteurs d'événements au chargement de la page
document.addEventListener('DOMContentLoaded', function () {
    // Pour le formulaire d'ajout
    const quantiteInput = document.getElementById('quantite');
    const prixInput = document.getElementById('prix_unitaire');

    if (quantiteInput && prixInput) {
        quantiteInput.addEventListener('input', calculerMontantTotal);
        prixInput.addEventListener('input', calculerMontantTotal);
    }

    // Pour le formulaire de modification
    const modifQuantiteInput = document.getElementById('modif_quantite');
    const modifPrixInput = document.getElementById('modif_prix_unitaire');

    if (modifQuantiteInput && modifPrixInput) {
        modifQuantiteInput.addEventListener('input', calculerMontantTotalModif);
        modifPrixInput.addEventListener('input', calculerMontantTotalModif);
    }
});