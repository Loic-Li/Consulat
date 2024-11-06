<?php
$servername = "localhost";
$username = "loic";
$password = "";
$dbname = "consulat";

try {
    // Création d'une connexion à la base de données avec le nom `$pdo` pour correspondre au reste du code
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Échec de la connexion à la base de données: " . $e->getMessage());
}
?>
