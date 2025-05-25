document.addEventListener('DOMContentLoaded', function () {
    // Initialiser Select2 pour tous les menus déroulants d'allergènes
    $('.select-allergenes').select2({
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
    });

    // Script pour calculer automatiquement les dates de début et fin de semaine
    const numeroSemaineInput = document.getElementById('numero_semaine');
    const anneeInput = document.getElementById('annee');
    const dateDebutInput = document.getElementById('date_debut');
    const dateFinInput = document.getElementById('date_fin');

    function updateDates() {
        const numeroSemaine = parseInt(numeroSemaineInput.value) || 1;
        const annee = parseInt(anneeInput.value) || new Date().getFullYear();

        console.log(`Calcul des dates pour semaine ${numeroSemaine}, année ${annee}`);

        // Implémentation correcte selon ISO 8601
        // La semaine 1 est celle qui contient le premier jeudi de l'année
        const janFourth = new Date(annee, 0, 3); // Le 3 janvier est vendredi toujours dans la semaine 1
        const janFourthDayOfWeek = janFourth.getDay() || 7; // 0 (dimanche) devient 7

        // Trouver le premier lundi de la semaine 1
        const firstMondayOfYear = new Date(annee, 0, 4 - (janFourthDayOfWeek - 1));

        // Ajouter (semaine - 1) * 7 jours pour obtenir le lundi de la semaine demandée
        const dateDebut = new Date(firstMondayOfYear);
        dateDebut.setDate(firstMondayOfYear.getDate() + (numeroSemaine - 1) * 7);

        // Calculer la date de fin (vendredi = début + 4 jours)
        const dateFin = new Date(dateDebut);
        dateFin.setDate(dateDebut.getDate() + 4);

        console.log(`Date de début calculée: ${dateDebut.toISOString().split('T')[0]}`);
        console.log(`Date de fin calculée: ${dateFin.toISOString().split('T')[0]}`);

        // Formater les dates pour l'input date (YYYY-MM-DD)
        dateDebutInput.value = dateDebut.toISOString().split('T')[0];
        dateFinInput.value = dateFin.toISOString().split('T')[0];
    }

    if (!dateDebutInput.value || !dateFinInput.value) {
        updateDates();
    }

    numeroSemaineInput.addEventListener('change', updateDates);
    anneeInput.addEventListener('change', updateDates);

    // Fonction pour afficher/masquer les détails des allergènes
    function toggleAllergenes(detailsId) {
        const detailsElement = document.getElementById(detailsId);
        if (detailsElement) {
            detailsElement.style.display = detailsElement.style.display === 'none' ? 'block' : 'none';

            // Rafraîchir uniquement ce select spécifique après l'affichage
            if (detailsElement.style.display === 'block') {
                $(detailsElement).find('.select-allergenes').select2('destroy').select2({
                    width: '100%',
                    placeholder: "Sélectionnez les allergènes",
                    allowClear: true
                });
            }
        }
    }

    // Initialiser les cases à cocher allergènes
    const allergeneCheckboxes = document.querySelectorAll('input[value="allergenes"]');
    allergeneCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function () {
            const element = this.id;
            const detailsId = element + '-details';
            toggleAllergenes(detailsId);
        });
    });
});
