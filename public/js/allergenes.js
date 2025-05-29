/** @type {Window & typeof globalThis & { jQuery: any, $: any, toggleAllergenes: Function }} */
var w = window;

'use strict';

// Configuration globale de Select2 pour les allergènes
const SELECT2_CONFIG = {
    width: '100%',
    placeholder: "Sélectionnez les allergènes",
    allowClear: true,
    language: {
        noResults: function () {
            return "Aucun allergène trouvé";
        },
        searching: function () {
            return "Recherche en cours...";
        },
        loadingMore: function () {
            return "Chargement de résultats supplémentaires...";
        },
        inputTooShort: function (args) {
            return "Veuillez entrer " + args.minimum + " caractères ou plus";
        }
    }
};

// Namespace pour les fonctions des allergènes
window.GestionAllergenes = {
    // Initialiser Select2 pour un élément
    initSelect2: function ($select) {
        if (!$select || !$select.length) return;

        // Détruire l'instance existante si elle existe
        if ($select.hasClass('select2-hidden-accessible')) {
            $select.select2('destroy');
        }

        // Initialiser Select2 avec la configuration
        $select.select2(SELECT2_CONFIG);
    },

    // Afficher/masquer les détails des allergènes
    toggleAllergenes: function (detailsId) {
        const detailsElement = document.getElementById(detailsId);
        if (!detailsElement) return;

        // Toggle l'affichage
        const isVisible = detailsElement.style.display !== 'none';
        detailsElement.style.display = isVisible ? 'none' : 'block';

        if (!isVisible) {
            // Réinitialiser Select2 quand on affiche le conteneur
            const $select = $(detailsElement).find('.select-allergenes');
            this.initSelect2($select);
        }
    },

    // Initialiser les gestionnaires d'événements
    init: function () {
        if (this.initialized) return;
        this.initialized = true;

        // Initialiser Select2 pour les menus visibles
        $('.select-allergenes').each((_, element) => {
            const $select = $(element);
            if ($select.closest('[id$="-allergenes-details"]').css('display') !== 'none') {
                this.initSelect2($select);
            }
        });

        // Gestionnaire d'événements pour les cases à cocher d'allergènes
        $(document).on('change', 'input[value="allergenes"]', (event) => {
            const detailsId = event.target.id + '-details';
            this.toggleAllergenes(detailsId);
        });

        console.log('GestionAllergenes initialisé');
    }
};

document.addEventListener('DOMContentLoaded', () => {
    // Vérifier que jQuery et Select2 sont chargés
    if (typeof jQuery === 'undefined') {
        console.error('jQuery nest pas chargé');
        return;
    }
    if (typeof jQuery.fn.select2 === 'undefined') {
        console.error('Select2 nest pas chargé');
        return;
    }

    window.GestionAllergenes.init();
});

// Script pour calculer automatiquement les dates de début et fin de semaine
/** @type {HTMLInputElement} */
var numeroSemaineInput = document.getElementById('numero_semaine');
/** @type {HTMLInputElement} */
var anneeInput = document.getElementById('annee');
/** @type {HTMLInputElement} */
var dateDebutInput = document.getElementById('date_debut');
/** @type {HTMLInputElement} */
var dateFinInput = document.getElementById('date_fin');

function updateDates() {
    if (!numeroSemaineInput || !anneeInput || !dateDebutInput || !dateFinInput) return;

    var numeroSemaine = parseInt(numeroSemaineInput.value || '1');
    var annee = parseInt(anneeInput.value || String(new Date().getFullYear()));

    // Implémentation selon ISO 8601
    var janFourth = new Date(annee, 0, 3);
    var janFourthDayOfWeek = janFourth.getDay() || 7;
    var firstMondayOfYear = new Date(annee, 0, 4 - (janFourthDayOfWeek - 1));
    var dateDebut = new Date(firstMondayOfYear);
    dateDebut.setDate(firstMondayOfYear.getDate() + (numeroSemaine - 1) * 7);
    var dateFin = new Date(dateDebut);
    dateFin.setDate(dateDebut.getDate() + 4);

    dateDebutInput.value = dateDebut.toISOString().split('T')[0];
    dateFinInput.value = dateFin.toISOString().split('T')[0];
}

if (dateDebutInput && dateFinInput && (!dateDebutInput.value || !dateFinInput.value)) {
    updateDates();
}

if (numeroSemaineInput) {
    numeroSemaineInput.addEventListener('change', updateDates);
}
if (anneeInput) {
    anneeInput.addEventListener('change', updateDates);
}
