<?php
session_start();
require_once '../config/db.php'; // Inclure le fichier de connexion à la base de données

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer les données du formulaire
    $firstName = trim($_POST['first_name']);
    $lastName = trim($_POST['last_name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $password = trim($_POST['password']);
    $confirmPassword = trim($_POST['confirm_password']);
    $errors = [];

    // Validation des champs
    if (empty($firstName)) {
        $errors['first_name'] = "Le prénom est requis.";
    }
    if (empty($lastName)) {
        $errors['last_name'] = "Le nom est requis.";
    }
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Une adresse e-mail valide est requise.";
    }
    if (empty($phone)) {
        $errors['phone'] = "Le numéro de téléphone est requis.";
    }
    if (empty($password) || strlen($password) < 8 || !preg_match('/[A-Z]/', $password) || !preg_match('/[\W_]/', $password)) {
        $errors['password'] = "Le mot de passe doit contenir au moins 8 caractères, une majuscule et un caractère spécial.";
    }
    if ($password !== $confirmPassword) {
        $errors['confirm_password'] = "Les mots de passe ne correspondent pas.";
    }

    // Si aucune erreur, enregistrer l'utilisateur dans la base de données
    if (empty($errors)) {
        // Hasher le mot de passe
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Préparer et exécuter la requête
        $stmt = $conn->prepare("INSERT INTO users (first_name, last_name, email, phone, password) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $firstName, $lastName, $email, $phone, $hashedPassword);

        if ($stmt->execute()) {
            // Redirection vers une page de succès après l'inscription réussie
            header('Location: ../views/test.php'); // Changez le chemin si nécessaire
            exit;
        } else {
            // Gérer l'erreur de la requête
            $errors['general'] = "Une erreur s'est produite lors de l'inscription : " . $stmt->error;
        }

        $stmt->close(); // Fermer la déclaration
    }

    // Si des erreurs existent, les stocker dans la session et rediriger
    $_SESSION['errors'] = $errors;
    header('Location: ../views/register.php');
    exit;
}

$conn->close(); // Fermer la connexion à la base de données
