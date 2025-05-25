# Créer la base de test
& "C:\MAMP\bin\mysql\bin\mysql.exe" -u root -proot -e "DROP DATABASE IF EXISTS compte_restaurant_scolaire_test; CREATE DATABASE compte_restaurant_scolaire_test CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"

# Copier la structure et les données depuis la base existante
& "C:\MAMP\bin\mysql\bin\mysqldump.exe" -u root -proot compte_restaurant_scolaire | & "C:\MAMP\bin\mysql\bin\mysql.exe" -u root -proot compte_restaurant_scolaire_test
