<?php
$host = 'localhost';
$user = 'root';
$password = 'root';
$database = 'qualitedev';

$conn = new mysqli($host, $user, $password, $database);

// Vérifier la connexion
if ($conn->connect_error) {
    die("Échec de la connexion : " . $conn->connect_error);
}
echo "Connexion réussie à MySQL !";
