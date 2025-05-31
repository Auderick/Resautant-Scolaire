<<<<<<< HEAD
# 📁 Scripts de l'Application Restaurant Scolaire

Ce dossier contient les scripts essentiels pour gérer l'application. Voici les principaux outils à votre disposition :

## 🔄 Scripts Principaux

### 1. Initialisation de la Base de Données (`init_db.php`)

```bash
php init_db.php
```

Ce script crée la base de données et configure toutes les tables nécessaires. Il s'exécute automatiquement au premier démarrage, mais vous pouvez aussi le lancer manuellement si besoin.

### 2. Sauvegarde (`backup_mysql.ps1`)

```powershell
.\backup_mysql.ps1
```

Fait une copie de sécurité de :

- La base de données
- Les fichiers importants
- Les configurations

Les sauvegardes sont stockées dans le dossier `backups/`.
=======
# Scripts de Sauvegarde et Restauration

Ce dossier contient les scripts permettant de gérer les sauvegardes et restaurations de l'application de gestion du restaurant scolaire.

## 📂 Structure des Sauvegardes

Les sauvegardes sont stockées dans le dossier `backups/` avec la structure suivante :

```
backups/
├── database/               # Sauvegardes MySQL
│   └── mysql_DATE.zip     # Ex: mysql_2025-05-29_10-04.zip
└── files/                 # Sauvegardes des fichiers (optionnel)
    └── files_backup_DATE.zip
```

## 🔄 Scripts Actifs

### 1. Sauvegarde MySQL Simplifiée (`backup_mysql_simple.ps1`)

Pour effectuer une sauvegarde de la base de données :

```powershell
.\scripts\backup_mysql_simple.ps1
```

Caractéristiques :
>>>>>>> b006509d20750be4d540e20c450a0bb6c837a15e

- Arrêt propre de MySQL avant la sauvegarde
- Sauvegarde directe des fichiers de données
- Compression en ZIP
- Conservation des 5 sauvegardes les plus récentes
- Redémarrage automatique de MySQL

<<<<<<< HEAD
### 3. Restauration (`restore_backup.ps1`)

```powershell
.\restore_backup.ps1 -BackupDate "2025-05-29_14-47"
```

Pour restaurer une ancienne version, utilisez la date de la sauvegarde que vous voulez récupérer.

### 4. Vérification des Tables (`check_and_update_table.php`)

```bash
php check_and_update_table.php
```

Vérifie que la structure de la base de données est correcte et la répare si nécessaire.

## 🗂️ Organisation des Sauvegardes

Les sauvegardes sont rangées comme ceci :

```
backups/
├── database/           # Sauvegardes de la base de données
│   └── mysql_DATE.zip
└── files/             # Sauvegardes des fichiers
    └── files_backup_DATE.zip
```

## ❗ En Cas de Problème

1. **La sauvegarde ne marche pas ?**

   - Vérifiez que l'application est démarrée
   - Regardez dans le dossier `logs/` pour voir les erreurs

2. **Erreur lors de la restauration ?**
   - Fermez l'application avant de restaurer
   - Vérifiez que le fichier de sauvegarde existe bien

## 🆘 Besoin d'Aide ?

Si vous avez besoin d'aide :

1. Consultez les logs dans `logs/`
2. Contactez le support :
   - Email : support@webtransform.fr
   - Site : https://webtransform.fr

## 📝 Notes pour les Développeurs

- Les anciens scripts sont archivés dans `scripts/archive/`
- Pour le développement/test, utilisez `clone_database.ps1` pour créer une copie de la base
- Les logs d'erreurs sont dans `logs/php_error.log`
=======
### 2. Restauration (`restore_backup.ps1`)

Pour restaurer une sauvegarde spécifique :

```powershell
.\scripts\restore_backup.ps1 -BackupDate "2025-05-29_10-00"
```

Le script de restauration :

- Validation des fichiers de sauvegarde
- Restauration de la base de données
- Restauration des fichiers de l'application (si sauvegardés)
- Nettoyage automatique

### 3. Configuration des Sauvegardes (`setup_backup_task.ps1`)

Pour configurer les sauvegardes automatiques :

```powershell
# Exécuter en tant qu'administrateur
.\scripts\setup_backup_task.ps1
```

## 🛠️ Scripts de Configuration

### 1. Configuration PHP (`configure_mamp_php.ps1`)

Configure l'environnement PHP avec les paramètres optimaux :

- Configuration de PHP.ini
- Réglage des performances
- Configuration des logs
- Gestion des sessions

### 2. Base de Test (`clone_database.ps1`)

Crée une copie de la base de données pour les tests :

- Clonage de la base de production
- Utile pour le développement

## ⚠️ Points Importants

1. Toujours vérifier que la sauvegarde a été créée avec succès
2. Tester régulièrement le processus de restauration
3. Les anciens scripts ont été archivés dans `scripts/archive/`
4. Ne pas modifier les fichiers pendant une sauvegarde
5. Ne pas supprimer manuellement les sauvegardes

## 🛠️ Dépannage

1. **La sauvegarde échoue** :

   - Vérifier les droits d'accès
   - S'assurer que MySQL est accessible
   - Vérifier l'espace disque disponible

2. **La restauration échoue** :

   - Vérifier l'intégrité des fichiers
   - Consulter les logs pour plus de détails
   - S'assurer que MySQL est arrêté avant la restauration

## 📞 Support

En cas de problème :

1. Consulter les logs dans le dossier `logs/`
2. Vérifier les permissions des dossiers
3. Contacter le support technique :
   - Email : support@webtransform.fr
   - Site : https://webtransform.fr
>>>>>>> b006509d20750be4d540e20c450a0bb6c837a15e
