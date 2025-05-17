<?php
require_once __DIR__ . '/../../includes/header.php';
require_once __DIR__ . '/../../includes/auth_check.php';
?>

<div class="container">
    <h1 class="text-center mb-4">Guide d'utilisation HACCP</h1>

    <div class="row">
        <div class="col-md-3">
            <!-- Menu de navigation -->
            <div class="list-group mb-4">
                <a href="#temperatures" class="list-group-item list-group-item-action">Relevé des températures</a>
                <a href="#refroidissement" class="list-group-item list-group-item-action">Refroidissement et remise en
                    T°</a>
                <a href="#nettoyage" class="list-group-item list-group-item-action">Plan de nettoyage</a>
                <a href="#distribution" class="list-group-item list-group-item-action">Contrôle distribution</a>
                <a href="#tracabilite" class="list-group-item list-group-item-action">Traçabilité</a>
                <a href="#archivage" class="list-group-item list-group-item-action">Archivage des documents</a>
            </div>
        </div>

        <div class="col-md-9">
            <!-- Contenu -->
            <div id="temperatures" class="mb-5">
                <h2>Relevé des températures</h2>
                <div class="card">
                    <div class="card-body">
                        <h5>Comment remplir le document ?</h5>
                        <ol>
                            <li>Notez la semaine concernée</li>
                            <li>Relevez les températures aux heures indiquées</li>
                            <li>En cas d'anomalie, notez-la dans la section "Actions correctives"</li>
                        </ol>
                        <div class="alert alert-info">
                            <strong>Rappel des normes :</strong>
                            <ul>
                                <li>Chambre froide positive : entre 0°C et +3°C</li>
                                <li>Chambre froide négative : -18°C ou moins</li>
                                <li>Plats chauds : +63°C minimum</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div id="refroidissement" class="mb-5">
                <h2>Refroidissement et remise en température</h2>
                <div class="card">
                    <div class="card-body">
                        <h5>Instructions de remplissage</h5>
                        <ol>
                            <li>Indiquez le mois et l'année</li>
                            <li>Pour chaque produit :</li>
                            <ul>
                                <li>Notez la date et le nom du produit</li>
                                <li>Relevez les températures aux étapes clés du refroidissement</li>
                                <li>Si remise en température ultérieure, utilisez la nouvelle colonne date</li>
                            </ul>
                        </ol>
                        <div class="alert alert-warning">
                            <strong>Points de vigilance :</strong>
                            <ul>
                                <li>Le refroidissement doit passer de +63°C à +10°C en moins de 2h</li>
                                <li>La remise en température doit atteindre +63°C en moins d'1h</li>
                                <li>Ne pas faire plus d'une remise en température par produit</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div id="archivage" class="mb-5">
                <h2>Archivage des documents</h2>
                <div class="card">
                    <div class="card-body">
                        <h5>Comment archiver vos documents ?</h5>
                        <ol>
                            <li>Scannez le document rempli</li>
                            <li>Dans l'interface HACCP, sélectionnez la catégorie appropriée</li>
                            <li>Téléversez le fichier PDF</li>
                            <li>Vérifiez que le document apparaît bien dans la liste</li>
                        </ol>
                        <div class="alert alert-info">
                            <strong>Conservation des documents :</strong>
                            <p>Les documents HACCP doivent être conservés pendant 3 ans minimum.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>