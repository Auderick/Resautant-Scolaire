/**
 * Gestion des impressions pour les synthèses mensuelles et annuelles
 */

/**
 * Imprime la synthèse mensuelle à partir des cartes existantes
 * @param {number} mois - Le mois à imprimer (1-12)
 * @param {number} annee - L'année à imprimer
 */
function imprimerSyntheseMensuelle(mois, annee) {
    console.log("Impression synthèse mensuelle pour", mois, annee);

    // Obtenir le nom du mois en français
    const nomsMois = [
        'Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin',
        'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'
    ];
    const nomMois = nomsMois[mois - 1];

    try {
        // Récupérer les données depuis les cartes de la page
        const cartes = document.querySelectorAll('.card-body');
        let donnees = {};

        // Parcourir toutes les cartes pour extraire les données
        cartes.forEach(carte => {
            const titre = carte.querySelector('.card-title');
            const valeur = carte.querySelector('.card-text');
            if (titre && valeur) {
                const texte = titre.textContent.trim();
                donnees[texte] = valeur.textContent.trim();
            }
        });

        // Créer le contenu HTML à imprimer
        const html = `
            <!DOCTYPE html>
            <html>
            <head>
                <title>Synthèse Mensuelle - ${nomMois} ${annee}</title>
                <meta charset="UTF-8">
                <style>
                    body { 
                        font-family: Arial, sans-serif; 
                        padding: 20px;
                        margin: 0;
                    }
                    h1, h2 { 
                        text-align: center;
                        margin-bottom: 20px;
                    }
                    .header {
                        margin-bottom: 30px;
                    }
                    table {
                        width: 90%;
                        margin: 0 auto 30px;
                        border-collapse: collapse;
                    }
                    th, td {
                        border: 1px solid #ddd;
                        padding: 10px;
                        text-align: left;
                    }
                    th {
                        background-color: #f5f5f5;
                        font-weight: bold;
                    }
                    .item {
                        font-weight: bold;
                    }
                    .footer {
                        margin-top: 30px;
                        text-align: center;
                        font-size: 12px;
                        color: #666;
                    }
                    @media print {
                        @page {
                            margin: 0.5cm;
                            size: portrait;
                        }
                        html {
                            height: 99%;
                        }
                    }
                </style>
            </head>
            <body>
                <div class="header">
                    <h1>Restaurant Scolaire de Leignes sur Fontaine</h1>
                    <h2>Synthèse Mensuelle - ${nomMois} ${annee}</h2>
                </div>
                
                <table>
                    <tr>
                        <td class="item">Total Ventes</td>
                        <td>${donnees["Total Ventes"] || "N/A"}</td>
                        <td class="item">Total Achats</td>
                        <td>${donnees["Total Achats"] || "N/A"}</td>
                    </tr>
                    <tr>
                        <td class="item">Valeur Stock</td>
                        <td>${donnees["Valeur Stock"] || "N/A"}</td>
                        <td class="item">Nombre de Couverts</td>
                        <td>${donnees["Nombre de Couverts"] || "N/A"}</td>
                    </tr>
                    <tr>
                        <td class="item">Coût par Couvert</td>
                        <td>${donnees["Coût par Couvert"] || "N/A"}</td>
                        <td class="item">Résultat Total</td>
                        <td>${donnees["Résultat Total"] || "N/A"}</td>
                    </tr>
                </table>
                
                <div class="footer">
                    Document généré le ${new Date().toLocaleDateString('fr-FR')}
                </div>
                
                <script>
                    window.onload = function() {
                        setTimeout(function() {
                            window.print();
                        }, 500);
                    };
                </script>
            </body>
            </html>
        `;

        // Créer une nouvelle fenêtre pour l'impression
        const printWindow = window.open('', '_blank');
        if (!printWindow) {
            alert("Le navigateur a bloqué l'ouverture de la fenêtre d'impression. Veuillez autoriser les popups pour ce site.");
            return;
        }

        // Écrire le contenu dans la nouvelle fenêtre et l'imprimer
        printWindow.document.write(html);
        printWindow.document.close();
    } catch (error) {
        console.error("Erreur lors de l'impression:", error);
        alert("Une erreur est survenue lors de la préparation de l'impression.");
    }
}

/**
 * Imprime la synthèse annuelle à partir du tableau existant
 * @param {number} annee - L'année à imprimer
 */
function imprimerSyntheseAnnuelle(annee) {
    console.log("Impression synthèse annuelle pour", annee);

    try {
        // Sélectionner le tableau annuel (c'est le tableau à l'intérieur du dernier card-body de la page)
        const cardBodies = document.querySelectorAll('.card-body');
        const lastCardBody = cardBodies[cardBodies.length - 1];

        if (!lastCardBody) {
            console.error("Impossible de trouver le contenu de la synthèse annuelle");
            alert("Erreur: Impossible de trouver le tableau de synthèse annuelle");
            return;
        }

        const tableau = lastCardBody.querySelector('table');
        if (!tableau) {
            console.error("Tableau de synthèse annuelle non trouvé");
            alert("Erreur: Impossible de trouver le tableau de synthèse annuelle");
            return;
        }

        // Cloner le tableau pour l'impression
        const tableauClone = tableau.cloneNode(true);

        // Ajouter une classe à la dernière ligne (ligne de total) pour la mise en forme
        const lignes = tableauClone.querySelectorAll('tbody tr');
        if (lignes.length > 0) {
            lignes[lignes.length - 1].classList.add('total-row');
        }

        // Créer le contenu HTML à imprimer
        const html = `
            <!DOCTYPE html>
            <html>
            <head>
                <title>Synthèse Annuelle ${annee}</title>
                <meta charset="UTF-8">
                <style>
                    body { 
                        font-family: Arial, sans-serif; 
                        padding: 20px;
                        margin: 0;
                    }
                    h1, h2 { 
                        text-align: center;
                        margin-bottom: 20px;
                    }
                    table {
                        width: 100%;
                        border-collapse: collapse;
                        margin-bottom: 30px;
                    }
                    th, td {
                        border: 1px solid #ddd;
                        padding: 8px;
                        text-align: left;
                        font-size: 11px;
                    }
                    th {
                        background-color: #f5f5f5;
                        font-weight: bold;
                    }
                    .total-row {
                        font-weight: bold;
                        background-color: #e9ecef;
                    }
                    .footer {
                        margin-top: 30px;
                        text-align: center;
                        font-size: 12px;
                        color: #666;
                    }
                    @media print {
                        @page {
                            margin: 0.5cm;
                            size: landscape; /* Format paysage pour la synthèse annuelle */
                        }
                        html {
                            height: 99%;
                        }
                        tr {
                            page-break-inside: avoid;
                        }
                    }
                </style>
            </head>
            <body>
                <h1>Restaurant Scolaire de Leignes sur Fontaine</h1>
                <h2>Synthèse Annuelle ${annee}</h2>
                
                ${tableauClone.outerHTML}
                
                <div class="footer">
                    Document généré le ${new Date().toLocaleDateString('fr-FR')}
                </div>
                
                <script>
                    window.onload = function() {
                        setTimeout(function() {
                            window.print();
                        }, 500);
                    };
                </script>
            </body>
            </html>
        `;

        // Créer une nouvelle fenêtre pour l'impression
        const printWindow = window.open('', '_blank');
        if (!printWindow) {
            alert("Le navigateur a bloqué l'ouverture de la fenêtre d'impression. Veuillez autoriser les popups pour ce site.");
            return;
        }

        // Écrire le contenu dans la nouvelle fenêtre et l'imprimer
        printWindow.document.write(html);
        printWindow.document.close();
    } catch (error) {
        console.error("Erreur lors de l'impression:", error);
        alert("Une erreur est survenue lors de la préparation de l'impression.");
    }
}