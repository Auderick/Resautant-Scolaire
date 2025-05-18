# Instructions pour corriger les problèmes de stocks sur l'autre ordinateur

Mise à jour du 18 mai 2025 (v2) :

- Ajout de la méthode getListe() manquante qui causait une erreur fatale
- Reconstruction complète de la table historique_stocks avec sauvegarde des données
- Correction de toutes les structures de tables (AUTO_INCREMENT, encodage utf8mb4)
- Vérification et réparation des tables

Ce dossier contient les fichiers modifiés nécessaires pour corriger :

1. Les problèmes d'encodage (caractères accentués)
2. Les problèmes d'ajout/modification des stocks
3. L'ajout de logs pour faciliter le débogage

## Instructions d'installation

1. Sur l'autre ordinateur, créez une sauvegarde des fichiers originaux :

   ```powershell
   Copy-Item "c:\MAMP\htdocs\compte_restaurant_scolaire\src\Models\stock.php" "c:\MAMP\htdocs\compte_restaurant_scolaire\src\Models\stock.php.bak"
   ```

2. Copiez les fichiers de ce dossier vers les emplacements correspondants :

   - `src/Models/stock.php` -> `c:\MAMP\htdocs\compte_restaurant_scolaire\src\Models\stock.php`
   - `includes/debug.php` -> `c:\MAMP\htdocs\compte_restaurant_scolaire\includes\debug.php`

3. Vérifiez que la configuration de la base de données dans `config/database.php` est correcte :

   ```php
   <?php
   return [
       'host' => 'localhost',
       'dbname' => 'compte_restaurant_scolaire',
       'user' => 'root',  // Votre utilisateur MAMP
       'password' => 'root', // Votre mot de passe MAMP
       'port' => '3306'  // Le port MySQL de MAMP
   ];
   ```

4. Importez les corrections de la base de données :

   - **IMPORTANT** : Faites d'abord une sauvegarde complète de votre base de données
   - Ouvrez phpMyAdmin
   - Sélectionnez la base de données `compte_restaurant_scolaire`
   - Allez dans l'onglet "SQL"
   - Copiez et collez le contenu du fichier `database/fix_tables.sql`
   - Cliquez sur "Exécuter"
   - En cas d'erreur, restaurez la sauvegarde et contactez le support

5. Redémarrez MAMP après avoir fait ces modifications

## En cas de problème

Les erreurs seront maintenant enregistrées dans le fichier `php_error.log` de MAMP avec beaucoup plus de détails pour faciliter le débogage.
