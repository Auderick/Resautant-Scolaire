<?php

// Script pour générer un nouveau hachage de mot de passe
$password = 'admin123';
$hash = password_hash($password, PASSWORD_DEFAULT);
echo "Mot de passe: $password<br>";
echo "Nouveau hachage: $hash";
?>