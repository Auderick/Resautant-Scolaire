# Système de Gestion de Restaurant Scolaire

## À propos

Application web de gestion complète développée pour le restaurant scolaire de Leignes-sur-Fontaine. Cette solution permet la gestion des présences, des ventes de repas, des stocks, et des commandes fournisseurs.

## Technologies utilisées

- PHP 8.2 avec architecture MVC
- Base de données MySQL
- Interface responsive (Bootstrap)
- Exports PDF (mPDF)
- Sécurité : protection contre les injections SQL et XSS
- Sauvegarde automatique hebdomadaire

## Fonctionnalités détaillées

### 1. Gestion des présences
- Suivi quotidien des présences par catégorie (CM2, CE2-CM1, etc.)
- Récapitulatif mensuel avec statistiques
- Impression des listes de présence personnalisables
- Interface intuitive de saisie des présences
- Export des données au format Excel/PDF
- Historique complet des présences

### 2. Gestion des ventes
- Enregistrement des repas vendus quotidiennement
- Suivi détaillé par type de repas (enfant, adulte)
- Statistiques de vente avancées
- Génération automatique des factures
- Suivi des paiements
- Historique des transactions

### 3. Gestion des stocks
- Inventaire en temps réel des produits
- Système d'alertes paramétrable :
  - Niveau bas de stock
  - Dates de péremption
  - Ruptures prévisionnelles
- Suivi détaillé des mouvements de stock
- Suggestions de réapprovisionnement
- Gestion des fournisseurs préférés
- Historique complet des mouvements

### 4. Commandes fournisseurs
- Création de bons de commande professionnels
- Export automatique en PDF
- Modèles personnalisables
- Suivi du statut des commandes :
  - En attente
  - Validée
  - En cours de livraison
  - Réceptionnée
- Historique détaillé par fournisseur
- Gestion des prix et des remises

### 5. Synthèses et rapports
- Tableaux de bord interactifs
- Analyses financières détaillées :
  - Coûts par repas
  - Marges par produit
  - Évolution des dépenses
- Rapports personnalisables
- Exports comptables automatisés
- Statistiques mensuelles et annuelles

### 6. Gestion des menus
- Planification hebdomadaire des menus
- Gestion avancée des allergènes
- Calcul automatique des valeurs nutritionnelles
- Publication automatique sur le site web
- Rotation intelligente des menus
- Gestion des régimes spéciaux

### 7. HACCP
- Création et gestion des documents HACCP
- Modèles de documents personnalisables
- Système de suivi des tâches :
  - Contrôles de température
  - Nettoyage
  - Maintenance
- Export des fiches au format Excel
- Système de classement intelligent
- Rappels automatiques des tâches
- Archivage sécurisé des documents
- Conservation de l'historique des contrôles

## Configuration technique détaillée

### Prérequis système
- MAMP avec MySQL 5.7+
- PHP 8.2 minimum avec extensions :
  - PDO MySQL
  - GD
  - ZIP
  - mbstring
- PowerShell Windows 5.1+
- Droits administrateur Windows
- 2 Go d'espace disque minimum

### Installation complète

1. **Préparation**
   ```powershell
   # Cloner le dépôt
   git clone https://github.com/webtransform/compte_restaurant_scolaire.git C:\MAMP\htdocs\compte_restaurant_scolaire
   ```

2. **Configuration de la base de données**
   ```powershell
   # Copier le fichier de configuration
   Copy-Item C:\MAMP\htdocs\compte_restaurant_scolaire\config\database.example.php C:\MAMP\htdocs\compte_restaurant_scolaire\config\database.php
   
   # Éditer database.php avec vos paramètres
   notepad C:\MAMP\htdocs\compte_restaurant_scolaire\config\database.php
   ```

3. **Import de la base de données**
   ```powershell
   # Via phpMyAdmin ou en ligne de commande
   mysql -u root -p restaurant_scolaire < C:\MAMP\htdocs\compte_restaurant_scolaire\compte_restaurant_scolaire.sql
   ```

4. **Permissions des dossiers**
   ```powershell
   # Configurer les permissions
   icacls "C:\MAMP\htdocs\compte_restaurant_scolaire\backups" /grant "IIS_IUSRS:(OI)(CI)M"
   icacls "C:\MAMP\htdocs\compte_restaurant_scolaire\logs" /grant "IIS_IUSRS:(OI)(CI)M"
   ```

### Système de sauvegarde

Le système effectue automatiquement :

1. **Sauvegarde de la base de données**
   - Dump complet chaque vendredi à 20h00
   - Compression automatique en ZIP
   - Rotation des fichiers après 30 jours

2. **Sauvegarde des fichiers critiques**
   - Documents HACCP
   - Menus hebdomadaires
   - Bons de commande
   - Configuration système
   - Logs d'application

3. **Structure des sauvegardes**
   ```
   backups/
   ├── database/     # Dumps SQL compressés
   ├── files/        # Archives des documents
   └── logs/         # Journaux de backup
   ```

4. **Sécurité**
   - Vérification automatique de l'intégrité
   - Surveillance de l'espace disque
   - Logs détaillés des opérations
   - Rotation automatique > 30 jours

   - MAMP installé avec MySQL
   - PowerShell Windows
   - Droits administrateur pour la configuration initiale

4. **Installation du système de sauvegarde**

   ```powershell
   # 1. Vérifier les informations de connexion dans config/database.php

   # 2. Tester le script manuellement
   cd C:\MAMP\htdocs\compte_restaurant_scolaire\scripts
   .\sauvegarde_auto.ps1

   # 3. Configurer la tâche planifiée
   # Ouvrir le Planificateur de tâches (taskschd.msc)
   # Créer une nouvelle tâche :
   # - Nom : "Sauvegarde Restaurant Scolaire"
   # - Déclencheur : Tous les vendredis à 20h00
   # - Action : powershell.exe
   # - Arguments : -NoProfile -ExecutionPolicy Bypass -File "C:\MAMP\htdocs\compte_restaurant_scolaire\scripts\sauvegarde_auto.ps1"
   ```

5. **Structure des sauvegardes**

   ```
   backups/
   ├── database/          # Sauvegardes SQL compressées
   ├── files/            # Archives ZIP des fichiers
   └── logs/             # Journaux de sauvegarde
   ```

6. **Vérification des sauvegardes**

   - Les fichiers de sauvegarde sont datés (YYYY-MM-DD_HH-mm)
   - Les logs détaillent chaque opération
   - Rotation automatique des fichiers > 30 jours
   - Surveillance de l'espace disque disponible

7. **Procédure de restauration**

   ```powershell
   # 1. Arrêter MAMP

   # 2. Noter la date de la sauvegarde à restaurer (format: YYYY-MM-DD_HH-mm)
   # Exemple : 2025-05-19_06-44

   # 3. Lancer la restauration avec le script fourni
   cd C:\MAMP\htdocs\compte_restaurant_scolaire\scripts
   .\restore_backup.ps1 -BackupDate "2025-05-19_06-44"

   # 4. Redémarrer MAMP après la restauration

   # 2. Restauration des fichiers
   # Créer un dossier temporaire pour la restauration
   New-Item -ItemType Directory -Path "C:\MAMP\htdocs\compte_restaurant_scolaire\backups\restore" -Force

   # Décompresser l'archive des fichiers
   Expand-Archive -Path "C:\MAMP\htdocs\compte_restaurant_scolaire\backups\files\files_backup_YYYY-MM-DD_HH-mm.zip" -DestinationPath "C:\MAMP\htdocs\compte_restaurant_scolaire\backups\restore"

   # 3. Copier les fichiers restaurés vers leur emplacement d'origine
   # (Remplacer YYYY-MM-DD_HH-mm par la date de la sauvegarde à restaurer)
   Copy-Item -Path "C:\MAMP\htdocs\compte_restaurant_scolaire\backups\restore\*" -Destination "C:\MAMP\htdocs\compte_restaurant_scolaire" -Recurse -Force

   # 4. Nettoyage des fichiers temporaires
   Remove-Item -Path "C:\MAMP\htdocs\compte_restaurant_scolaire\backups\temp" -Recurse -Force
   Remove-Item -Path "C:\MAMP\htdocs\compte_restaurant_scolaire\backups\restore" -Recurse -Force
   ```

   **Important** :

   - Arrêtez MAMP avant la restauration
   - Notez la date exacte de la sauvegarde à restaurer
   - Faites une copie de sécurité avant la restauration
   - Redémarrez MAMP après la restauration

## Scripts de maintenance

1. **Tester la sauvegarde manuellement**
   ```powershell
   cd C:\MAMP\htdocs\compte_restaurant_scolaire\scripts
   .\sauvegarde_auto.ps1
   ```

2. **Restaurer une sauvegarde**
   ```powershell
   # Remplacer YYYY-MM-DD_HH-mm par la date souhaitée
   .\restore_backup.ps1 -BackupDate "YYYY-MM-DD_HH-mm"
   ```

## Contact & Support

Développé par WebTransform
- [https://webtransform.fr](https://webtransform.fr)
- contact@webtransform.fr

---
© 2025 WebTransform
