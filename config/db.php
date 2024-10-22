<?php
$servername = "localhost";
$username = "loic"; // votre nom d'utilisateur MySQL
$password = ""; // votre mot de passe MySQL
$dbname = "consulat"; // le nom de votre base de données

// Créer la connexion
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("Échec de la connexion : " . $conn->connect_error);
}
?>
