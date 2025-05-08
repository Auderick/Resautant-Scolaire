function modifierStock(id) {
    fetch(`/compte_restaurant_scolaire/api/stocks.php?id=${id}`)
        .then(response => response.json())
        .then(data => {
            document.getElementById('modif_id').value = data.id;
            document.getElementById('modif_produit').value = data.produit;
            document.getElementById('modif_quantite').value = data.quantite;
            document.getElementById('modif_prix_unitaire').value = data.prix_unitaire;
            document.getElementById('modif_unite').value = data.unite;
            document.getElementById('modif_seuil_alerte').value = data.seuil_alerte;
            document.getElementById('modif_date_mouvement').value = data.date_mouvement ?
                data.date_mouvement.slice(0, 16) :
                new Date().toISOString().slice(0, 16);
            new bootstrap.Modal(document.getElementById('modalModifier')).show();
        })
        .catch(error => {
            console.error('Erreur:', error);
        });
}

function supprimerStock(id) {
    if (confirm('Êtes-vous sûr de vouloir supprimer ce produit ?')) {
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

function ajusterStock(id) {
    // Créer une boîte de dialogue personnalisée
    const dialog = document.createElement('div');
    dialog.innerHTML = `
        <div class="modal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Ajuster le stock</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="ajustement" class="form-label">Quantité à ajouter (négatif pour retirer)</label>
                            <input type="number" class="form-control" id="ajustement" step="any">
                        </div>
                        <div class="mb-3">
                            <label for="date_mouvement" class="form-label">Date du mouvement</label>
                            <input type="datetime-local" class="form-control" id="date_mouvement" 
                                   value="${new Date().toISOString().slice(0, 16)}">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                        <button type="button" class="btn btn-primary" id="confirmerAjustement">Confirmer</button>
                    </div>
                </div>
            </div>
        </div>
    `;

    document.body.appendChild(dialog);
    const modal = new bootstrap.Modal(dialog.querySelector('.modal'));
    modal.show();

    // Gérer la confirmation
    dialog.querySelector('#confirmerAjustement').addEventListener('click', () => {
        const ajustement = dialog.querySelector('#ajustement').value;
        const dateMouvement = dialog.querySelector('#date_mouvement').value;

        const form = document.createElement('form');
        form.method = 'POST';
        form.innerHTML = `
            <input type="hidden" name="action" value="ajuster">
            <input type="hidden" name="id" value="${id}">
            <input type="hidden" name="ajustement" value="${ajustement}">
            <input type="hidden" name="date_mouvement" value="${dateMouvement}">
        `;
        document.body.appendChild(form);
        form.submit();
    });

    // Nettoyer le DOM après fermeture
    dialog.querySelector('.modal').addEventListener('hidden.bs.modal', () => {
        dialog.remove();
    });
}

function imprimerStocks() {
    const printWindow = window.open('', '_blank');
    const tableau = document.querySelector('.table').cloneNode(true);

    // Calculer le total avant de supprimer la colonne Actions
    let totalStock = 0;
    const rows = tableau.querySelectorAll('tbody tr');
    rows.forEach(row => {
        const valeurStock = parseFloat(row.cells[3].textContent.replace('€', '').trim());
        if (!isNaN(valeurStock)) {
            totalStock += valeurStock;
        }
    });

    // Masquer la colonne des actions
    const actionCells = tableau.querySelectorAll('th:last-child, td:last-child');
    actionCells.forEach(cell => cell.remove());

    const html = `
        <!DOCTYPE html>
        <html>
        <head>
            <title>État des Stocks</title>
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
            <style>
                body { 
                    padding: 20px;
                    font-family: Arial, sans-serif;
                }
                @media print {
                    .no-print { display: none; }
                    table { width: 100%; border-collapse: collapse; }
                    th, td { padding: 12px; border: 1px solid #ddd; }
                    th { background-color: #f5f5f5 !important; }
                    .total-stock {
                        margin-top: 20px;
                        font-size: 1.2em;
                        font-weight: bold;
                        text-align: right;
                    }
                    @page {
                        margin: 0.5cm;
                        size: portrait; /* Format portrait pour économiser du papier */
                    }
                     html {
                        height: 99%; /* Cette ligne est la clé pour masquer l'URL */
                    }
                }
            </style>
        </head>
        <body>
            <h1 class="text-center mb-4">État des Stocks</h1>
            <div class="table-responsive">
                ${tableau.outerHTML}
            </div>
            <div class="total-stock">
                Valeur totale du stock : ${totalStock.toFixed(2)} €
            </div>
            <div class="text-center mt-4 no-print">
                <button class="btn btn-primary" onclick="window.print()">Imprimer</button>
            </div>
        </body>
        </html>
    `;

    printWindow.document.write(html);
    printWindow.document.close();
}