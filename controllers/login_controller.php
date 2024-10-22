<?php
session_start();
require_once '../config/db.php'; // Inclure le fichier de connexion à la base de données

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer les données du formulaire
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Validation des champs
    if (empty($email) || empty($password)) {
        $_SESSION['error'] = "Veuillez remplir tous les champs.";
        header('Location: ../views/login.php');
        exit;
    }

    try {
        $db = new PDO('mysql:host=localhost;dbname=consulat', 'loic', ''); // Remplace par tes informations
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Vérifier si l'utilisateur existe
        $stmt = $db->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Vérifier le mot de passe
        if ($user && password_verify($password, $user['password'])) {
            // Connexion réussie
            $_SESSION['user_id'] = $user['id']; // Assumes 'id' is the primary key
            header('Location: ../views/dashboard.php'); // Rediriger vers la page de tableau de bord ou une autre page
            exit;
        } else {
            $_SESSION['error'] = "Identifiants invalides.";
            header('Location: ../views/login.php');
            exit;
        }
    } catch (PDOException $e) {
        $_SESSION['error'] = "Une erreur s'est produite : " . $e->getMessage();
        header('Location: ../views/login.php');
        exit;
    }
}
