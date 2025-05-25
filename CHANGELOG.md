# Changelog Application Web Restaurant Scolaire

Toutes les modifications notables de l'application web seront documentées dans ce fichier.

## [1.0.0] - 2025-05-25

### Ajouté

- Interface de gestion des menus
- Système de gestion des commandes
- Gestion des stocks
- Interface des ventes
- Système de présences
- Gestion HACCP
- Système d'authentification
- Rapports et synthèses
- Gestion des utilisateurs

### Modifié

- Amélioration du style CSS pour le footer
- Optimisation de la mise en page responsive

### Technique

- Structure MVC
- Base de données MySQL
- PHP 8.2
- Bootstrap 5.3.6
- Interface responsive
- Système de sauvegarde automatique

## Comment mettre à jour

1. Code PHP/Templates :

   - Modifier les fichiers dans les dossiers appropriés
   - Tester localement
   - Sauvegarder la base de données si nécessaire

2. Base de données :

   ```powershell
   # Faire une sauvegarde avant toute modification
   .\scripts\sauvegarde_auto.ps1

   # Appliquer les migrations si nécessaire
   php scripts\check_and_update_table.php
   ```

3. Assets (CSS/JS) :
   - Modifier les fichiers dans `public/css/` ou `public/js/`
   - Vérifier la compatibilité avec les fonctionnalités existantes
