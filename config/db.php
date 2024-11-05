<?php
$servername = "localhost";
$username = "loic"; // Nom d'utilisateur MySQL
$password = ""; // Mot de passe MySQL
$dbname = "consulat"; // Nom de la base de données

try {
    // Création d'une connexion à la base de données
    $conn = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8", $username, $password);
    // Configure le mode d'erreur de PDO pour qu'il lance des exceptions
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // Optionnel : Afficher un message de connexion réussie (pour débogage)
    // echo "Connexion réussie à la base de données.";
} catch (PDOException $e) {
    die("Échec de la connexion à la base de données: " . $e->getMessage());
}
?>
