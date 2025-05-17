<?php
require_once __DIR__ . '/../../config/db.php';

try {
    // Récupérer la liste des tables
    $tables = $db->query("SHOW TABLES")->fetchAll(PDO::FETCH_COLUMN);
    
    $schema = [];
    foreach ($tables as $table) {
        // Récupérer la structure de chaque table
        $create = $db->query("SHOW CREATE TABLE `$table`")->fetch(PDO::FETCH_ASSOC);
        $schema[$table] = $create['Create Table'];
    }
    
    // Créer le fichier de migration
    $migration = "<?php\n\n";
    $migration .= "require_once __DIR__ . '/../../config/db.php';\n\n";
    $migration .= "try {\n";
    
    // Ajouter les instructions pour supprimer les tables si elles existent
    foreach (array_reverse($tables) as $table) {
        $migration .= "    \$db->exec('DROP TABLE IF EXISTS `$table`');\n";
    }
    $migration .= "\n";
    
    // Ajouter les instructions de création des tables
    foreach ($schema as $table => $create) {
        $migration .= "    \$db->exec(\"$create\");\n\n";
    }
    
    $migration .= "    echo \"Base de données restaurée avec succès !\\n\";\n";
    $migration .= "} catch (PDOException \$e) {\n";
    $migration .= "    echo \"Erreur lors de la restauration : \" . \$e->getMessage() . \"\\n\";\n";
    $migration .= "}\n";

    // Enregistrer dans un nouveau fichier
    $filename = __DIR__ . '/00_initial_schema.php';
    file_put_contents($filename, $migration);
    
    echo "Schéma de la base de données exporté avec succès dans : $filename\n";

} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage() . "\n";
}
