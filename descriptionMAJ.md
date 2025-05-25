# Guide des Mises à Jour - Restaurant Scolaire

## Structure du Projet

Le projet est composé de deux applications distinctes mais complémentaires :

### 1. Application Web (gestion_restaurant_scolaire)

- Application PHP principale
- Contient toute la logique métier
- Base de données et structure
- Interface utilisateur
- Fichiers statiques

### 2. Application Desktop (gestion_restaurant_desktop)

- Application Electron
- Embarque l'application web
- Fournit un environnement local
- Gère PHP et MySQL

## Processus de Mise à Jour

### Mise à jour de l'Application Web

Dossier concerné : `c:\MAMP\htdocs\gestion_restaurant_scolaire`

Types de modifications :

1. Code PHP

   - Modèles dans `src/Models/`
   - Contrôleurs dans `src/Controllers/`
   - Utilitaires dans `src/Utils/`

2. Interface utilisateur

   - Templates dans `templates/`
   - CSS dans `public/css/`
   - JavaScript dans `public/js/`

3. Base de données
   - Migrations dans `database/migrations/`
   - Sauvegardes dans `backups/database/`

### Mise à jour de l'Application Desktop

Dossier concerné : `c:\MAMP\htdocs\gestion_restaurant_desktop`

Types de modifications :

1. Configuration Electron

   - Fichiers dans `src/main/`
   - Configuration dans `config/`

2. Services embarqués

   - MySQL dans `resources/mysql/`
   - Logs dans `resources/logs/`

3. Build et déploiement
   - Scripts dans `scripts/`
   - Ressources dans `resources/`

## Bonnes Pratiques

1. Avant toute modification :

   ```powershell
   # Sauvegarde de la base de données
   .\scripts\sauvegarde_auto.ps1

   # Sauvegarde des fichiers
   Copy-Item -Path "c:\MAMP\htdocs\gestion_restaurant_scolaire" -Destination "backups\files\" -Recurse
   ```

2. Pendant les modifications :

   - Tester dans un environnement de développement
   - Documenter les changements dans les CHANGELOG.md
   - Suivre les conventions de code

3. Après les modifications :
   - Tester toutes les fonctionnalités
   - Vérifier les logs
   - Mettre à jour la documentation

## Déploiement

### Application Web

```powershell
# Copier les fichiers mis à jour
Copy-Item -Path "c:\MAMP\htdocs\gestion_restaurant_scolaire\*" -Destination "chemin_production" -Recurse

# Appliquer les migrations
php scripts\check_and_update_table.php
```

### Application Desktop

```powershell
# Dans le dossier gestion_restaurant_desktop
npm version patch
npm run build
# Distribution dans le dossier build/
```

## Maintenance

1. Sauvegardes régulières :

   - Base de données : quotidienne
   - Fichiers : hebdomadaire

2. Logs :

   - Vérifier `logs/app.log`
   - Nettoyer les anciens logs

3. Mises à jour de sécurité :
   - PHP et MySQL
   - Dépendances npm
   - Composer packages

## Support

Pour toute question ou problème :

1. Consulter la documentation
2. Vérifier les logs
3. Contacter le support technique

## Rollback

En cas de problème :

1. Restaurer la dernière sauvegarde
2. Revenir à la version précédente
3. Documenter l'incident
