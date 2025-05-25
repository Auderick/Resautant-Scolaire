// @ts-nocheck
// Fonction pour afficher/masquer les détails des allergènes
function toggleAllergenes(detailsId) {
    const detailsElement = document.getElementById(detailsId);
    if (!detailsElement) return;

    // Trouver la case à cocher correspondante
    const checkbox = document.querySelector(`input[onclick*="${detailsId}"]`);
    // Vérifier si la case est cochée
    const isChecked = checkbox instanceof HTMLInputElement ? checkbox.checked : false;

    // Afficher/masquer la section des allergènes
    detailsElement.style.display = isChecked ? 'block' : 'none';

    // Réinitialiser et rafraîchir Select2 si la section est visible
    if (isChecked) {
        const select = jQuery(detailsElement).find('.select-allergenes');
        if (select.length > 0) {
            // Détruire l'instance existante de Select2 s'il y en a une
            if (select.data('select2')) {
                select.select2('destroy');
            }

            // Réinitialiser Select2
            select.select2({
                width: '100%',
                placeholder: "Sélectionnez les allergènes",
                allowClear: true,
                language: {
                    noResults: function () {
                        return "Aucun allergène trouvé";
                    }
                }
            });
        }
    }
}

document.addEventListener('DOMContentLoaded', function () {
    // Initialiser Select2 pour tous les menus déroulants d'allergènes
    jQuery('.select-allergenes').select2({
        width: '100%',
        placeholder: "Sélectionnez les allergènes",
        allowClear: true,
        language: {
            noResults: function () {
                return "Aucun allergène trouvé";
            }
        }
    });

    // Script pour calculer automatiquement les dates de début et fin de semaine
    const numeroSemaineInput = document.getElementById('numero_semaine');
    const anneeInput = document.getElementById('annee');
    const dateDebutInput = document.getElementById('date_debut');
    const dateFinInput = document.getElementById('date_fin');

    // Initialiser les cases à cocher allergènes
    document.querySelectorAll('input[value="allergenes"]').forEach(function (checkbox) {
        if (checkbox instanceof HTMLInputElement && checkbox.id && checkbox.checked) {
            const detailsId = checkbox.id + '-details';
            toggleAllergenes(detailsId);
        }

        checkbox.addEventListener('change', function (event) {
            const target = event.target;
            if (target instanceof HTMLInputElement && target.id) {
                const detailsId = target.id + '-details';
                toggleAllergenes(detailsId);
            }
        });
    });
});
