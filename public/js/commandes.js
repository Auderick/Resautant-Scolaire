// Fonction pour imprimer une commande
function imprimerCommande(id) {
    const printWindow = window.open('', '_blank');

    if (!printWindow) {
        alert("Le navigateur a bloqué l'ouverture de la fenêtre. Veuillez autoriser les popups.");
        return;
    }

    try {
        // Récupérer les données de la commande via AJAX
        fetch(`/api/commandes.php?id=${id}`)
            .then(response => response.json())
            .then(data => {
                if (!data || !data.commande) {
                    throw new Error("Données de commande invalides");
                }

                const commande = data.commande;
                const lignes = data.lignes || [];

                // Calculer le total général
                let totalGeneral = 0;
                lignes.forEach(ligne => {
                    if (ligne.prix_unitaire) {
                        totalGeneral += ligne.quantite * ligne.prix_unitaire;
                    }
                });

                // Formater le total avec le séparateur de milliers
                const totalFormate = new Intl.NumberFormat('fr-FR', {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                }).format(totalGeneral);

                // Formater la date de commande
                const dateCommande = new Date(commande.date_commande);
                const dateCommandeFormatee = dateCommande.toLocaleDateString('fr-FR');

                // Formater la date de livraison souhaitée si elle existe
                let dateLivraisonFormatee = "-";
                if (commande.date_livraison_souhaitee) {
                    const dateLivraison = new Date(commande.date_livraison_souhaitee);
                    dateLivraisonFormatee = dateLivraison.toLocaleDateString('fr-FR');
                }

                // Créer le HTML pour le tableau des produits
                let produitsHTML = '';
                if (lignes.length > 0) {
                    lignes.forEach(ligne => {
                        const prixUnitaireFormate = ligne.prix_unitaire
                            ? new Intl.NumberFormat('fr-FR', { minimumFractionDigits: 2 }).format(ligne.prix_unitaire)
                            : '-';

                        const totalLigne = ligne.prix_unitaire
                            ? new Intl.NumberFormat('fr-FR', { minimumFractionDigits: 2 }).format(ligne.prix_unitaire * ligne.quantite)
                            : '-';

                        produitsHTML += `
                            <tr>
                                <td>${ligne.produit}</td>
                                <td class="text-center">${new Intl.NumberFormat('fr-FR', { minimumFractionDigits: 2 }).format(ligne.quantite)}</td>
                                <td>${ligne.unite || '-'}</td>
                                <td class="text-end">${prixUnitaireFormate} €</td>
                                <td class="text-end">${totalLigne} €</td>
                            </tr>
                        `;
                    });
                } else {
                    produitsHTML = '<tr><td colspan="5" class="text-center">Aucun produit dans cette commande</td></tr>';
                }

                // Créer le contenu HTML complet à imprimer
                const html = `
                    <!DOCTYPE html>
                    <html>
                    <head>
                        <title>Bon de Commande N° ${commande.id}</title>
                        <meta charset="UTF-8">
                        <style>
                            body { 
                                font-family: Arial, sans-serif; 
                                padding: 10px;
                                font-size: 13px;
                                margin: 0;
                            }
                            h1, h2, h3 { 
                                margin-bottom: 12px; 
                            }
                            .header { 
                                text-align: center; 
                                margin-bottom: 15px; 
                            }
                            table {
                                width: 100%;
                                border-collapse: collapse;
                                margin-bottom: 15px;
                            }
                            th, td {
                                padding: 5px;
                                text-align: left;
                                border: 1px solid #ddd;
                            }
                            th {
                                background-color: #f5f5f5;
                            }
                            .address-block { 
                                width: 48%; 
                                float: left; 
                                margin-bottom: 20px; 
                            }
                            .supplier-block { 
                                width: 48%; 
                                float: right; 
                                text-align: right; 
                                margin-bottom: 20px; 
                            }
                            .clear { 
                                clear: both; 
                            }
                            .text-end { 
                                text-align: right; 
                            }
                            .text-center {
                                text-align: center;
                            }
                            .footer { 
                                margin-top: 20px; 
                            }
                            .reception-table {
                                width: 100%;
                                border-collapse: collapse;
                                margin-bottom: 20px;
                            }
                            .reception-table th, .reception-table td {
                                padding: 8px;
                                text-align: left;
                                border: 1px solid #ddd;
                                vertical-align: top;
                            }
                            .reception-table th {
                                background-color: #f5f5f5;
                                font-weight: bold;
                            }
                            .info-table {
                                width: 100%;
                                border: none;
                            }
                            .info-table td, .info-table th {
                                padding: 5px;
                                border: none;
                            }
                            .info-table th {
                                background-color: transparent;
                                width: 30%;
                            }
                            .print-btn {
                                display: block;
                                margin: 20px auto;
                                padding: 10px 20px;
                                background-color: #4CAF50;
                                color: white;
                                border: none;
                                border-radius: 4px;
                                cursor: pointer;
                                font-size: 16px;
                            }
                            @media print {
                                @page {
                                    margin: 0.5cm;
                                }
                                html {
                                    height: 99%;
                                }   
                                .no-print {
                                    display: none !important;
                                }
                                  tr {
                                    page-break-inside: avoid;
                                }
                                
                                table {
                                    page-break-inside: auto;
                                }
                                
                                thead {
                                    display: table-header-group;
                                }
                                
                                tfoot {
                                    display: table-footer-group;
                                }
                                
                                body {
                                    padding: 5px;
                                    font-size: 13px;
                                }
                                
                                th, td {
                                    padding: 3px;
                                }
                                
                                .reception-table tr td[height="80px"] {
                                    height: 50px;
                                }  
                            }
                        </style>
                    </head>
                    <body>
                        <div class="header">
                            <h1>Restaurant Scolaire de Leignes sur Fontaine</h1>
                            <h2>Bon de Commande N° ${commande.id}</h2>
                        </div>
                        
                        <div class="info-container">
                            <div class="address-block">
                                <strong>Restaurant Scolaire</strong><br>
                                École de Leignes sur Fontaine<br>
                                2, place de la Mairie<br>
                                86300 Leignes sur Fontaine<br>
                                Tél: 06 77 80 41 55<br>
                                Email: 
                            </div>
                            
                            <div class="supplier-block">
                                <strong>Fournisseur :</strong><br>
                                ${commande.fournisseur}<br>
                            </div>
                            
                            <div class="clear"></div>
                            
                            <table class="info-table">
                                <tr>
                                    <th>Date de commande :</th>
                                    <td>${dateCommandeFormatee}</td>
                                </tr>
                                <tr>
                                    <th>Livraison souhaitée :</th>
                                    <td>${dateLivraisonFormatee}</td>
                                </tr>
                                ${commande.notes ? `
                                <tr>
                                    <th>Notes :</th>
                                    <td>${commande.notes.replace(/\n/g, '<br>')}</td>
                                </tr>` : ''}
                            </table>
                        </div>
                        
                        <h3>Produits commandés</h3>
                        <table>
                            <thead>
                                <tr>
                                    <th>Produit</th>
                                    <th class="text-center">Quantité</th>
                                    <th>Unité</th>
                                    <th class="text-end">Prix unitaire</th>
                                    <th class="text-end">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                ${produitsHTML}
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="4" class="text-end">Total Général</th>
                                    <th class="text-end">${totalFormate} €</th>
                                </tr>
                            </tfoot>
                        </table>                       
                        <div class="footer">
                            <h3>Contrôle à réception</h3>
                            <table class="reception-table">
                                <tr>
                                    <th style="width: 20%;">Date de réception</th>
                                    <td style="width: 30%;"></td>
                                    <th style="width: 20%;">Heure de réception</th>
                                    <td style="width: 30%;"></td>
                                </tr>
                                <tr>
                                    <th colspan="4">Nom du produit contrôlé</th>
                                </tr>
                                
                                <tr>
                                    <th colspan="4">Contrôle de température d'une catégorie de produits</th>
                                </tr>
                                <tr>
                                    <td colspan="4" height="80px">
                                        <table style="width:100%; border:none;">
                                            <tr style="border:none;">
                                                <td style="border:none; width: 33%;">
                                                    <strong>Produits frais (0°C à +4°C)</strong><br>
                                                    Température relevée: ________ °C<br>
                                                    □ Conforme &nbsp; □ Non conforme
                                                </td>
                                                <td style="border:none; width: 33%;">
                                                    <strong>Produits surgelés (-18°C)</strong><br>
                                                    Température relevée: ________ °C<br>
                                                    □ Conforme &nbsp; □ Non conforme
                                                </td>
                                                <td style="border:none; width: 33%;">
                                                    <strong>Autres produits réfrigérés</strong><br>
                                                    Température relevée: ________ °C<br>
                                                    □ Conforme &nbsp; □ Non conforme
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                
                                <tr>
                                    <th colspan="4">Observations (produits manquants, substitutions, anomalies)</th>
                                </tr>
                                <tr>
                                    <td colspan="4" height="80px"></td>
                                </tr>
                                <tr>
                                    <th colspan="4">Nom et signature du réceptionnaire</th>                                   
                                </tr>                                
                            </table>
                            <div class="clear"></div>
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
            })
            .catch(error => {
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
            });
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

// Fonction pour télécharger une commande au format PDF
// Cette fonction redirige vers le script PHP qui génère le PDF
function telechargerCommande(id) {
    window.location.href = `/templates/commandes/download.php?id=${id}`;
}