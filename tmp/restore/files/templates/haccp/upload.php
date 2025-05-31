<?php
require_once __DIR__ . '/../../includes/auth_check.php';
require_once __DIR__ . '/../../config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Vérifier si un fichier a été uploadé
        if (!isset($_FILES['file']) || $_FILES['file']['error'] !== UPLOAD_ERR_OK) {
            throw new Exception('Erreur lors du téléversement du fichier: ' . error_get_last()['message']);
        }        $file = $_FILES['file'];
        $category = $_POST['category'] ?? 'autres';

        // Vérifier le type et l'extension du fichier
        $fileName = $file['name'];
        $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        
        if ($fileExtension !== 'pdf') {
            throw new Exception('Seuls les fichiers PDF sont acceptés. Extension détectée : ' . $fileExtension);
        }

        // Vérification supplémentaire du type MIME en lisant les premiers octets
        $f = fopen($file['tmp_name'], 'rb');
        if ($f) {
            $header = fread($f, 4);
            fclose($f);
            
            // Vérifier la signature PDF (%PDF)
            if (bin2hex($header) !== '25504446') {
                throw new Exception('Le fichier ne semble pas être un PDF valide');
            }
        }

        // Créer le dossier de destination s'il n'existe pas
        $uploadDir = __DIR__ . '/documents/' . $category . '/';
        if (!file_exists($uploadDir)) {
            if (!@mkdir($uploadDir, 0755, true)) {
                throw new Exception('Impossible de créer le dossier de destination: ' . error_get_last()['message']);
            }
            // S'assurer que le serveur web a les droits d'écriture
            chmod($uploadDir, 0755);
        }

        // Générer un nom de fichier unique
        $fileName = uniqid() . '_' . basename($file['name']);
        $filePath = $uploadDir . $fileName;

        // Déplacer le fichier
        if (!@move_uploaded_file($file['tmp_name'], $filePath)) {
            $error = error_get_last();
            throw new Exception('Erreur lors du déplacement du fichier: ' . ($error ? $error['message'] : 'Raison inconnue'));
        }

        // Définir les permissions du fichier
        chmod($filePath, 0644);

        // Enregistrer dans la base de données
        $stmt = $db->prepare("INSERT INTO haccp_documents (name, category, file_path, uploaded_by) VALUES (?, ?, ?, ?)");
        $relativePath = 'documents/' . $category . '/' . $fileName;
        $stmt->execute([
            $file['name'],
            $category,
            $relativePath,
            $_SESSION['user_id']
        ]);

        // Rediriger vers la page principale avec un message de succès
        $_SESSION['success_message'] = 'Document téléversé avec succès';
        header('Location: index.php');
        exit;

    } catch (PDOException $e) {
        error_log('Erreur PDO dans upload.php: ' . $e->getMessage());
        $_SESSION['error_message'] = 'Erreur de base de données: ' . $e->getMessage();
        header('Location: index.php');
        exit;
    } catch (Exception $e) {
        error_log('Erreur dans upload.php: ' . $e->getMessage());
        $_SESSION['error_message'] = $e->getMessage();
        header('Location: index.php');
        exit;
    }
}

// Si ce n'est pas une requête POST, rediriger vers la page principale
header('Location: index.php');
exit;
