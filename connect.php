<?php
$host = 'localhost';   // Serveur MySQL (localhost)
$username = 'root';    // Nom d'utilisateur MySQL (par défaut 'root')
$password = 'root';        // Mot de passe (par défaut vide)
$dbname = 'pharmacie';   // Nom de la base de données

// Créer une connexion
$conn = new mysqli($host, $username, $password, $dbname);

?>