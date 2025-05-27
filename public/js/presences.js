function updateAbsenceCheckbox(presenceCheckbox) {
    // Trouver la case absence correspondante dans la même ligne
    const row = presenceCheckbox.closest('tr');
    const absenceCheckbox = row.querySelector('.absence-checkbox');

    // Si présent est coché, décocher absent
    absenceCheckbox.checked = false;
}

function updatePresenceCheckbox(absenceCheckbox) {
    // Trouver la case présence correspondante dans la même ligne
    const row = absenceCheckbox.closest('tr');
    const presenceCheckbox = row.querySelector('.presence-checkbox');

    // Si absent est coché, décocher présent
    presenceCheckbox.checked = false;
}

// Ajouter des écouteurs d'événements à toutes les cases à cocher
document.addEventListener('DOMContentLoaded', function () {
    const form = document.querySelector('form');
    const presenceCheckboxes = document.querySelectorAll('.presence-checkbox');
    const absenceCheckboxes = document.querySelectorAll('.absence-checkbox');

    presenceCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function () {
            updateAbsenceCheckbox(this);
        });
    });

    absenceCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function () {
            updatePresenceCheckbox(this);
        });
    });
});
