# Présentation du Système de Gestion de Restaurant Scolaire

## Introduction

Le Système de Gestion de Restaurant Scolaire est une application web complète développée pour répondre aux besoins du restaurant scolaire de Leignes-sur-Fontaine. Cette solution intégrée permet de gérer l'ensemble des opérations quotidiennes du restaurant, de la vente des repas à la gestion des stocks, en passant par les commandes fournisseurs.

## Fonctionnalités principales

### 1. Gestion des ventes

- Enregistrement des repas vendus quotidiennement
- Suivi par type de repas (enfant)

### 2. Gestion des achats

- Enregistrement détaillé des dépenses
- Catégorisation des achats
- Suivi budgétaire
- Historique complet des transactions

### 3. Gestion des stocks

- Inventaire en temps réel des produits
- Suivi des mouvements de stock
- Alertes de niveau bas
- Suggestions de réapprovisionnement

### 4. Commandes fournisseurs

- Création de bons de commande professionnels
- Impression et export PDF
- Suivi des statuts de commande
- Historique des commandes par fournisseur

### 5. Synthèses et rapports

- Tableaux de bord interactifs
- Analyses financières mensuelles et annuelles
- Rapports personnalisables
- Exports pour la comptabilité

### 6. Gestion des utilisateurs

- Contrôle d'accès par rôles (administrateur, utilisateur)
- Authentification sécurisée
- Traçabilité des actions

### 7. Gestion des menus

- Planification des menus hebdomadaires
- Publication automatique pour les parents
- Gestion des allergènes

### 8. Gestion HACCP

- Création et gestion des documents HACCP
- Générateur de fiches de traçabilité personnalisables
- Archivage automatique des documents
- Export des fiches au format Excel
- Système de classement par type de document
- Rappel des tâches HACCP à effectuer
- Conservation de l'historique des contrôles

## Aspects techniques

- Développé en PHP 8.2 avec architecture MVC
- Base de données MySQL optimisée
- Interface responsive compatible mobile
- Export de documents au format PDF
- Sécurité renforcée contre les injections SQL et XSS
- Système de sauvegarde automatique

### Système de sauvegarde automatique

L'application inclut un système de sauvegarde automatique qui :

1. **Sauvegarde la base de données**

   - Dump quotidien de la base MySQL
   - Compression automatique des fichiers SQL
   - Conservation des sauvegardes pendant 30 jours

2. **Sauvegarde des fichiers critiques**

   - Documents HACCP (documents, templates, archives)
   - Menus hebdomadaires
   - Bons de commande
   - Documents stocks et synthèses
   - Documents achats et ventes
   - Fichiers de configuration
   - Code source essentiel

3. **Configuration requise**

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
   # - Déclencheur : Tous les jours à 8h00
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

## Démonstration

La démonstration présentera les principaux flux de travail :

1. Enregistrement des ventes quotidiennes
2. Création d'un bon de commande fournisseur
3. Gestion des stocks et inventaire
4. Génération de rapports de synthèse

## Bénéfices pour l'établissement

- Gain de temps significatif dans les tâches administratives
- Réduction des erreurs de gestion
- Meilleure visibilité sur les coûts et les budgets
- Simplification du processus de commande
- Communication facilitée avec les fournisseurs
- Suivi précis de l'activité du restaurant

## À propos du développeur

Cette application a été entièrement développée par WebTransform, agence spécialisée dans le développement d'applications web sur mesure pour les collectivités et établissements publics.

Pour plus d'informations ou pour une démonstration personnalisée :

- Site web : [https://webtransform.fr](https://webtransform.fr)
- Contact : contact@webtransform.fr

---

© 2025 WebTransform - Tous droits réservés
