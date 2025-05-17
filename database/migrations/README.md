# Guide des Migrations de Base de Données

## Structure des fichiers

- `00_initial_schema.php` : Structure complète de la base de données
- `get_schema.php` : Script pour mettre à jour le schéma initial
- `XX_description.php` : Fichiers de migration numérotés

## Commandes principales

### 1. Réinitialiser la base de données

```powershell
# Exécuter le schéma initial (recrée toutes les tables)
php database/migrations/00_initial_schema.php
```

### 2. Créer une nouvelle migration

a) Créer un nouveau fichier dans `database/migrations/` avec un numéro séquentiel, par exemple `04_add_comment_to_ventes.php`

b) Utiliser ce modèle :

```php
<?php
require_once __DIR__ . '/../../config/db.php';

try {
    // 1. Vérifier si la modification est nécessaire
    $checkColumn = $db->query("SHOW COLUMNS FROM ma_table LIKE 'ma_colonne'");
    if ($checkColumn->rowCount() == 0) {
        // 2. Appliquer la modification
        $db->exec("ALTER TABLE ma_table ADD COLUMN ma_colonne TYPE DEFAULT VALUE");
        echo "Modification effectuée avec succès !\n";
    } else {
        echo "La modification existe déjà.\n";
    }
} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage() . "\n";
}
```

c) Exécuter la migration :

```powershell
# Appliquer la nouvelle migration
php database/migrations/04_add_comment_to_ventes.php
```

d) Mettre à jour le schéma initial :

```powershell
# Mettre à jour 00_initial_schema.php avec les changements
php database/migrations/get_schema.php
```

## Exemples de Migrations

### 1. Ajouter une colonne commentaire aux ventes

```php
<?php
// 04_add_comment_to_ventes.php
require_once __DIR__ . '/../../config/db.php';

try {
    $checkColumn = $db->query("SHOW COLUMNS FROM ventes LIKE 'commentaire'");
    if ($checkColumn->rowCount() == 0) {
        $db->exec("ALTER TABLE ventes ADD COLUMN commentaire TEXT DEFAULT NULL");
        echo "Colonne 'commentaire' ajoutée à la table 'ventes' avec succès !\n";
    } else {
        echo "La colonne 'commentaire' existe déjà dans la table 'ventes'.\n";
    }
} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage() . "\n";
}
```

### 2. Ajouter une colonne JSON aux menus

```php
<?php
// 05_add_allergenes_to_menus.php
require_once __DIR__ . '/../../config/db.php';

try {
    $checkColumn = $db->query("SHOW COLUMNS FROM menus_jours LIKE 'allergenes'");
    if ($checkColumn->rowCount() == 0) {
        $db->exec("ALTER TABLE menus_jours ADD COLUMN allergenes JSON DEFAULT NULL");
        echo "Colonne 'allergenes' ajoutée à la table 'menus_jours' avec succès !\n";
    } else {
        echo "La colonne 'allergenes' existe déjà dans la table 'menus_jours'.\n";
    }
} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage() . "\n";
}
```

## Bonnes pratiques

1. Toujours vérifier si la modification est nécessaire avant de l'appliquer
2. Donner des noms explicites aux fichiers de migration
3. Mettre à jour le schéma initial après chaque migration
4. Conserver tous les fichiers de migration pour garder l'historique
5. Tester les migrations sur un environnement de développement avant la production
