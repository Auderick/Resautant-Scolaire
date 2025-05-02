"use strict";

// Module principal
(function () {
    // Variables
    let semaineActuelle = 1;

    // Vérifiez si menuData est défini
    if (!menuData) {
        console.error('Erreur: Les données du menu ne sont pas définies.');
        return;
    }

    // Définition des semaines
    const semaines = [
        { id: 1, date: "05 au 09 avril 2025" },
        { id: 2, date: "12 au 16 mai 2025" },
        { id: 3, date: "19 au 23 mai 2025" },
        { id: 4, date: "26 au 30 mai 2025" },
        { id: 5, date: "02 au 06 juin 2025" },
        { id: 6, date: "09 au 13 juin 2025" }
    ];

    // Fonctions
    function initialiserSelecteurSemaines() {
        const select = document.querySelector('select');
        if (!select) return;

        semaines.forEach(semaine => {
            const option = document.createElement('option');
            option.value = semaine.id;
            option.textContent = `Semaine du ${semaine.date}`;
            select.appendChild(option);
        });
    }

    function changerSemaine(direction) {
        if (direction === 'suivante' && semaineActuelle < 6) {
            semaineActuelle++;
        } else if (direction === 'precedente' && semaineActuelle > 1) {
            semaineActuelle--;
        }
        updateAffichage();
    }

    function updateAffichage() {
        const select = document.querySelector('select');
        if (!select) return;

        select.value = semaineActuelle;
        chargerMenuSemaine(semaineActuelle);

        const btnPrecedent = document.querySelector('.semaine-nav button:first-child');
        const btnSuivant = document.querySelector('.semaine-nav button:last-child');

        if (btnPrecedent) btnPrecedent.disabled = semaineActuelle <= 1;
        if (btnSuivant) btnSuivant.disabled = semaineActuelle >= 6;
    }

    function chargerMenuSemaine(semaine) {
        const menuSemaine = menuData.semaines.find(s => s.id === parseInt(semaine, 10));

        if (menuSemaine) {
            afficherMenuSemaine(menuSemaine);
        } else {
            afficherErreur('Menu non trouvé pour cette semaine');
        }
    }

    function afficherMenuSemaine(menuSemaine) {
        ['lundi', 'mardi', 'jeudi', 'vendredi'].forEach(jour => {
            const jourElement = document.querySelector(`#${jour}`);
            if (!jourElement) return;

            const menuJour = menuSemaine.jours[jour];
            if (menuJour) {
                jourElement.innerHTML = `
                    <h2>${jour.charAt(0).toUpperCase() + jour.slice(1)}</h2>
                    ${genererHTMLPlat(menuJour)}
                `;
            }
        });
    }

    function genererHTMLPlat(menuJour) {
        const afficherAllergenes = (item) => {
            return item.allergenes?.length && item.allergenes[0] !== "" ?
                `<span class="allergenes">⚠️: ${item.allergenes.join(', ')}</span>`
                : '';
        };

        const estComplete = (item) => {
            return item && item.nom && item.nom.trim() !== "";
        };

        return `
            ${estComplete(menuJour.entree) ? `
                <div class="plat">
                    ${menuJour.entree.emoji || '🍽️'} Entrée: ${menuJour.entree.nom}
                    ${afficherAllergenes(menuJour.entree)}
                    ${menuJour.entree.local ? '<span class="local">🌟</span>' : ''}
                </div>
            ` : ''}

            ${estComplete(menuJour.plat_principal) ? `
                <div class="plat">
                    ${menuJour.plat_principal.emoji || '🍽️'} Plat: ${menuJour.plat_principal.nom}
                    ${afficherAllergenes(menuJour.plat_principal)}
                    ${menuJour.plat_principal.local ? '<span class="local">🌟</span>' : ''}
                </div>
            ` : ''}

            ${estComplete(menuJour.option_vegetarienne) ? `
                <div class="plat vegetarien">
                    ${menuJour.option_vegetarienne.emoji || '🌱'} Végétarien: ${menuJour.option_vegetarienne.nom}
                    ${afficherAllergenes(menuJour.option_vegetarienne)}
                </div>
            ` : ''}

            ${estComplete(menuJour.fromage_laitage) ? `
                <div class="plat">
                    ${menuJour.fromage_laitage.emoji || '🥛'} Laitage: ${menuJour.fromage_laitage.nom}
                    ${afficherAllergenes(menuJour.fromage_laitage)}
                    ${menuJour.fromage_laitage.bio ? '<span class="bio">🌱</span>' : ''}
                    ${menuJour.fromage_laitage.local ? '<span class="local">🌟</span>' : ''}
                </div>
            ` : ''}

            ${estComplete(menuJour.dessert) ? `
                <div class="plat">
                    ${menuJour.dessert.emoji || '🍰'} Dessert: ${menuJour.dessert.nom}
                    ${afficherAllergenes(menuJour.dessert)}
                    ${menuJour.dessert.bio ? '<span class="bio">🌱</span>' : ''}
                    ${menuJour.dessert.local ? '<span class="local">🌟</span>' : ''}
                </div>
            ` : ''}
        `;
    }

    function afficherErreur(message) {
        document.querySelectorAll('.jour').forEach(jour => {
            jour.innerHTML = `<div class="erreur">❌ ${message}</div>`;
        });
    }

    // Initialisation au chargement de la page
    document.addEventListener('DOMContentLoaded', () => {
        initialiserSelecteurSemaines();
        updateAffichage();

        // Ajout des écouteurs d'événements
        const select = document.querySelector('select');
        if (select) {
            select.addEventListener('change', (e) => {
                semaineActuelle = parseInt(e.target.value, 10);
                updateAffichage();
            });
        }

        const btnPrecedent = document.querySelector('.semaine-nav button:first-child');
        const btnSuivant = document.querySelector('.semaine-nav button:last-child');

        if (btnPrecedent) {
            btnPrecedent.addEventListener('click', () => changerSemaine('precedente'));
        }
        if (btnSuivant) {
            btnSuivant.addEventListener('click', () => changerSemaine('suivante'));
        }
    });
})();
