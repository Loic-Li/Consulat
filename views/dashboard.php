<?php
session_start();
// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    header('Location: ../views/login.php');
    exit;
}

// Ici, tu peux récupérer des informations sur l'utilisateur depuis la base de données si besoin
require_once '../config/db.php';

try {
    $db = new PDO('mysql:host=localhost;dbname=consulat', 'loic', '');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Récupérer les informations de l'utilisateur connecté
    $stmt = $db->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->execute([$_SESSION['user_id']]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    // Gérer les erreurs de connexion ou de requête
    die("Erreur lors de la connexion à la base de données : " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de Bord</title>
    <link rel="stylesheet" href="../path/to/your/bootstrap.css"> <!-- Lien vers ton fichier CSS -->
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">Bienvenue, <?php echo htmlspecialchars($user['first_name']); ?>!</h1>
        <p class="text-center">Vous êtes connecté avec succès.</p>
        <div class="text-center">
            <a href="../views/logout.php" class="btn btn-danger">Se déconnecter</a>
        </div>
    </div>
</body>
</html>
