// Vérifier si l'utilisateur a les droits d'édition
function modifierAchat(id) {
    // Vérifier les droits d'édition
    if (typeof window.hasEditPermission !== 'undefined' && !window.hasEditPermission) {
        alert("Vous n'avez pas les droits nécessaires pour modifier les achats.");
        return;
    }

    fetch(`/compte_restaurant_scolaire/api/achats.php?id=${id}`)
        .then(response => response.json())
        .then(data => {
            document.getElementById('modif_id').value = data.id;
            document.getElementById('modif_description').value = data.description;
            document.getElementById('modif_montant').value = data.montant;
            const date = new Date(data.date_achat);
            const dateString = date.toISOString().slice(0, 16);
            document.getElementById('modif_date_achat').value = dateString;
            new bootstrap.Modal(document.getElementById('modalModifier')).show();
        });
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
        // En mode utilisateur, cette colonne peut être absente ou différente
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

        // Calculer le total général
        let totalGeneral = 0;
        const rows = tableau.querySelectorAll('tbody tr');

        // Détecter automatiquement la colonne du montant (elle contient généralement le symbole '€')
        let montantColumnIndex = 3; // Valeur par défaut

        if (rows.length > 0) {
            const firstRow = rows[0];
            for (let i = 0; i < firstRow.cells.length; i++) {
                const cellText = firstRow.cells[i].textContent.trim();
                if (cellText.includes('€')) {
                    montantColumnIndex = i;
                    break;
                }
            }
        }

        rows.forEach(row => {
            if (row.cells.length > montantColumnIndex) {
                const montantText = row.cells[montantColumnIndex].textContent;
                const montant = parseFloat(montantText.replace(/[^\d.,]/g, '').replace(',', '.'));

                if (!isNaN(montant)) {
                    totalGeneral += montant;
                }
            }
        });

        // Formater le total avec le séparateur de milliers
        const totalFormate = new Intl.NumberFormat('fr-FR', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        }).format(totalGeneral);

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
                    .total-general {
                        margin-top: 20px;
                        font-weight: bold;
                        font-size: 1.2em;
                        text-align: right;
                        padding-right: 20px;
                    }
                    h1 {
                        text-align: center;
                        margin-bottom: 20px;
                    }
                    .print-btn {
                        display: block;
                        margin: 20px auto;
                        padding: 10px 20px;
                    }
                    @media print {
                        .no-print { 
                            display: none; 
                        }
                    }
                </style>
            </head>
            <body>
                <h1>Liste des Achats</h1>
                ${tableau.outerHTML}
                <div class="total-general">
                    Total Général : ${totalFormate} €
                </div>
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