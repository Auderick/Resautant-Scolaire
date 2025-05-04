/**
 * Fonction pour imprimer un menu
 * 
 * @param {number} id - L'identifiant de la semaine de menu à imprimer
 */
function imprimerMenu(id) {
    // Récupérer les données du menu
    fetch(`/compte_restaurant_scolaire/api/menus.php?id=${id}`)
        .then(response => response.json())
        .then(data => {
            const printWindow = window.open('', '_blank');

            // Préparer les jours et options pour affichage
            const jours = ['lundi', 'mardi', 'jeudi', 'vendredi'];
            const joursNoms = ['Lundi', 'Mardi', 'Jeudi', 'Vendredi'];

            // Générer les conteneurs des jours
            let joursHTML = '';

            jours.forEach((jour, index) => {
                if (data.menus[jour] && data.menus[jour].plat) {
                    // Calculer la date pour ce jour
                    const jourDate = new Date(data.semaine.date_debut);
                    jourDate.setDate(jourDate.getDate() + index);
                    const dateStr = jourDate.toLocaleDateString('fr-FR', { day: '2-digit', month: '2-digit' });

                    let jourContenu = '';

                    // Entrée
                    if (data.menus[jour].entree) {
                        let entreeIcons = '';
                        let allergenes = '';
                        if (data.menus[jour].options && data.menus[jour].options.entree) {
                            if (data.menus[jour].options.entree.includes('vegetarien')) entreeIcons += '🥬 ';
                            if (data.menus[jour].options.entree.includes('local')) entreeIcons += '🌟 ';
                            if (data.menus[jour].options.entree.includes('bio')) entreeIcons += '🌱 ';
                            if (data.menus[jour].options.entree.includes('allergenes')) {
                                entreeIcons += '⚠️ ';
                                if (data.menus[jour].allergenes && data.menus[jour].allergenes.entree) {
                                    allergenes = `<span class="allergenes">⚠️: ${data.menus[jour].allergenes.entree.join(', ')}</span>`;
                                }
                            }
                        }
                        jourContenu += `
                            <div class="plat">
                                🍽️ Entrée: ${data.menus[jour].entree} ${entreeIcons}
                                ${allergenes}
                            </div>
                        `;
                    }

                    // Plat principal
                    if (data.menus[jour].plat) {
                        let platIcons = '';
                        let allergenes = '';
                        if (data.menus[jour].options && data.menus[jour].options.plat) {
                            if (data.menus[jour].options.plat.includes('vegetarien')) platIcons += '🥬 ';
                            if (data.menus[jour].options.plat.includes('local')) platIcons += '🌟 ';
                            if (data.menus[jour].options.plat.includes('bio')) platIcons += '🌱 ';
                            if (data.menus[jour].options.plat.includes('allergenes')) {
                                platIcons += '⚠️ ';
                                if (data.menus[jour].allergenes && data.menus[jour].allergenes.plat) {
                                    allergenes = `<span class="allergenes">⚠️: ${data.menus[jour].allergenes.plat.join(', ')}</span>`;
                                }
                            }
                        }
                        jourContenu += `
                            <div class="plat">
                                🍲 Plat: ${data.menus[jour].plat} ${platIcons}
                                ${allergenes}
                            </div>
                        `;
                    }

                    // Accompagnement
                    if (data.menus[jour].accompagnement) {
                        let accompIcons = '';
                        let allergenes = '';
                        if (data.menus[jour].options && data.menus[jour].options.accompagnement) {
                            if (data.menus[jour].options.accompagnement.includes('vegetarien')) accompIcons += '🥬 ';
                            if (data.menus[jour].options.accompagnement.includes('local')) accompIcons += '🌟 ';
                            if (data.menus[jour].options.accompagnement.includes('bio')) accompIcons += '🌱 ';
                            if (data.menus[jour].options.accompagnement.includes('allergenes')) {
                                accompIcons += '⚠️ ';
                                if (data.menus[jour].allergenes && data.menus[jour].allergenes.accompagnement) {
                                    allergenes = `<span class="allergenes">⚠️: ${data.menus[jour].allergenes.accompagnement.join(', ')}</span>`;
                                }
                            }
                        }
                        jourContenu += `
                            <div class="plat">
                                🥗 Accompagnement: ${data.menus[jour].accompagnement} ${accompIcons}
                                ${allergenes}
                            </div>
                        `;
                    }

                    // Laitage
                    if (data.menus[jour].laitage) {
                        let laitageIcons = '';
                        let allergenes = '';
                        if (data.menus[jour].options && data.menus[jour].options.laitage) {
                            if (data.menus[jour].options.laitage.includes('vegetarien')) laitageIcons += '🥬 ';
                            if (data.menus[jour].options.laitage.includes('local')) laitageIcons += '🌟 ';
                            if (data.menus[jour].options.laitage.includes('bio')) laitageIcons += '🌱 ';
                            if (data.menus[jour].options.laitage.includes('allergenes')) {
                                laitageIcons += '⚠️ ';
                                if (data.menus[jour].allergenes && data.menus[jour].allergenes.laitage) {
                                    allergenes = `<span class="allergenes">⚠️: ${data.menus[jour].allergenes.laitage.join(', ')}</span>`;
                                }
                            }
                        }
                        jourContenu += `
                            <div class="plat">
                                🥛 Laitage: ${data.menus[jour].laitage} ${laitageIcons}
                                ${allergenes}
                            </div>
                        `;
                    }

                    // Dessert
                    if (data.menus[jour].dessert) {
                        let dessertIcons = '';
                        let allergenes = '';
                        if (data.menus[jour].options && data.menus[jour].options.dessert) {
                            if (data.menus[jour].options.dessert.includes('vegetarien')) dessertIcons += '🥬 ';
                            if (data.menus[jour].options.dessert.includes('local')) dessertIcons += '🌟 ';
                            if (data.menus[jour].options.dessert.includes('bio')) dessertIcons += '🌱 ';
                            if (data.menus[jour].options.dessert.includes('allergenes')) {
                                dessertIcons += '⚠️ ';
                                if (data.menus[jour].allergenes && data.menus[jour].allergenes.dessert) {
                                    allergenes = `<span class="allergenes">⚠️: ${data.menus[jour].allergenes.dessert.join(', ')}</span>`;
                                }
                            }
                        }
                        jourContenu += `
                            <div class="plat dessert">
                                🍰 Dessert: ${data.menus[jour].dessert} ${dessertIcons}
                                ${allergenes}
                            </div>
                        `;
                    }

                    // Construire le jour complet
                    joursHTML += `
                        <div id="${jour}" class="jour">
                            <h2>${joursNoms[index]} ${dateStr}</h2>
                            ${jourContenu}
                        </div>
                    `;
                }
            });

            // Construire le HTML avec votre CSS personnalisé
            const html = `
                <!DOCTYPE html>
                <html lang="fr">
                <head>
                    <meta charset="UTF-8">
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                    <title>Menu Restaurant Scolaire - Semaine ${data.semaine.numero_semaine}</title>
                    <style>
                        ${getYourCSS()}
                    </style>
                </head>
                <body>
                    <div class="menu-container">
                        <!-- En-tête -->
                        <div class="header">
                            <h1>🏫 École de Leignes sur Fontaine</h1>
                            <p>📞 Tél: 05.49.56.90.10</p>
                            <p>⏰ Service: 11h30 - 13h30</p>
                            <button onclick="window.print()">🖨️ Imprimer le menu</button>
                        </div>
                        
                        <h1>🍽️ Menu de la Semaine ${data.semaine.numero_semaine} du ${new Date(data.semaine.date_debut).toLocaleDateString('fr-FR')} au ${new Date(data.semaine.date_fin).toLocaleDateString('fr-FR')}</h1>
                        <h2>👨‍🍳 Le Chef vous propose 🍽️ 🥗 🍝 🥩 🥕 🍎</h2>
                        
                        <!-- Conteneurs des jours -->
                        ${joursHTML}
                        
                        <!-- Légende -->
                        <div class="legende">
                            <h3>Légende</h3>
                            <div class="symboles">
                                <span>🥬 Végétarien</span>
                                <span>⚠️ Contient des allergènes</span>
                                <span>🌟 Produit local</span>
                                <span>🌱 Bio</span>
                            </div>
                        </div>
                        
                        <div class="note">
                            Menu sous réserve de modifications selon les approvisionnements
                        </div>
                    </div>
                </body>
                </html>
            `;

            printWindow.document.write(html);
            printWindow.document.close();
        })
        .catch(error => {
            console.error('Erreur:', error);
            alert('Erreur lors de la récupération du menu.');
        });
}

// Fonction qui retourne votre CSS personnalisé
function getYourCSS() {
    return `
        body {
            font-family: 'Comic Sans MS', cursive, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f0f9ff;
        }
        
        .menu-container {
            max-width: 800px;
            margin: 0 auto;
            background-color: white;
            padding: 20px;
            border-radius: 15px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        
        .header {
            background-color: #2b76c0;
            color: white;
            padding: 20px;
            border-radius: 15px;
            margin-bottom: 20px;
            text-align: center;
        }
        
        h1 {
            color: #70b1f2;
            text-align: center;
            font-size: 2.5em;
            margin-bottom: 30px;
        }
        
        .jour {
            margin-bottom: 30px;
            border: 2px solid #87ceeb;
            border-radius: 10px;
            padding: 15px;
        }
        
        h2 {
            color: #4a90e2;
            border-bottom: 2px dashed #87ceeb;
            padding-bottom: 5px;
        }
        
        .plat {
            margin: 10px 0;
            padding: 5px;
            transition: transform 0.2s ease-in-out;
            cursor: pointer;
        }
        
        .plat:hover {
            transform: scale(1.02);
            background-color: #f8f9fa;
        }
        
        .dessert {
            color: #e67e22;
        }
        
        .vegetarien {
            color: #27ae60;
            font-style: italic;
        }
        
        .info-nutritionnelle {
            font-size: 0.8em;
            background-color: #f0f0f0;
            padding: 5px;
            border-radius: 5px;
            margin-top: 5px;
        }
        
        .allergenes {
            color: #e74c3c;
            font-weight: bold;
            display: block;
            margin-top: 3px;
            font-size: 0.9em;
        }
        
        .legende {
            margin-top: 20px;
            padding: 10px;
            background-color: #f5f5f5;
            border-radius: 10px;
        }
        
        .symboles {
            display: flex;
            justify-content: space-around;
            flex-wrap: wrap;
            gap: 10px;
        }
        
        .symboles span {
            background-color: white;
            padding: 5px 10px;
            border-radius: 5px;
        }
        
        .note {
            text-align: center;
            font-style: italic;
            margin-top: 20px;
        }
        
        /* Styles spécifiques pour l'impression */
        @media print {
            body {
                background-color: white;
                padding: 0;
                font-size: 10pt;
                margin: 0;
            }
            
            .menu-container {
                box-shadow: none;
                max-width: 100%;
                padding: 10px;
            }
            
            .header {
                padding: 10px;
                margin-bottom: 10px;
            }
            
            .header h1 {
                font-size: 16pt;
                margin: 5px 0;
            }
            
            .header p {
                margin: 2px 0;
                font-size: 9pt;
            }
            
            h1 {
                font-size: 14pt;
                margin: 10px 0;
            }
            
            h2 {
                font-size: 12pt;
                margin: 5px 0;
                padding-bottom: 2px;
            }
            
            .jour {
                margin-bottom: 10px;
                padding: 8px;
                border-width: 1px;
            }
            
            .plat {
                margin: 3px 0;
                padding: 2px;
            }
            
            .info-nutritionnelle {
                font-size: 8pt;
                padding: 2px;
                margin-top: 2px;
            }
            
            .legende {
                margin-top: 10px;
                padding: 5px;
            }
            
            .legende h3 {
                font-size: 10pt;
                margin: 2px 0;
            }
            
            .symboles {
                gap: 5px;
            }
            
            .symboles span {
                padding: 2px 5px;
                font-size: 8pt;
            }
            
            @page {
                margin: 0.5cm;
                size: A4;
            }
            
            button {
                display: none;
            }
        }
    `;
}

/**
 * Fonction pour télécharger un menu au format PDF
 * 
 * @param {number} id - L'identifiant de la semaine de menu à télécharger
 */
function telechargerMenu(id) {
    window.location.href = `/compte_restaurant_scolaire/templates/menus/download.php?id=${id}`;
}