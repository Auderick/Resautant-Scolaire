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

- Arrêt propre de MySQL avant la sauvegarde
- Sauvegarde directe des fichiers de données
- Compression en ZIP
- Conservation des 5 sauvegardes les plus récentes
- Redémarrage automatique de MySQL

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
