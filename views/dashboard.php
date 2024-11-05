<?php
session_start();
require_once '../config/db.php'; // Inclure la connexion à la base de données

// Vérifier si l'utilisateur est connecté
$isLoggedIn = isset($_SESSION['user_id']);
$user = [];

if ($isLoggedIn) {
    // Récupérer l'ID de l'utilisateur
    $user_id = $_SESSION['user_id'];

    // Requête pour récupérer les informations de l'utilisateur
    $sql = "SELECT first_name FROM users WHERE id = :user_id"; // Utiliser un paramètre nommé
    $stmt = $conn->prepare($sql);

    // Exécuter la requête avec le paramètre
    $stmt->execute([':user_id' => $user_id]);

    // Récupérer les résultats
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Vérifier si l'utilisateur existe
    if (!$user) {
        // Si aucun utilisateur trouvé
        echo "Utilisateur non trouvé.";
    }
} else {
    // Rediriger vers la page de connexion si l'utilisateur n'est pas connecté
    header('Location: ../views/login.php');
    exit;
}

// Titre de la page
$title = "Dashboard";
require_once '../includes/header.php';
?>

<!-- Contenu de la page -->
<div class="container mt-5">
    <h1 class="text-center">Bienvenue, <?php echo htmlspecialchars($user['first_name'] ?? ''); ?>!</h1>
    <p class="text-center">Vous êtes connecté avec succès.</p>
    <div class="text-center">
        <a href="visa.php" class="btn btn-danger">Demande de VISA</a>
    </div>
</div>

<?php include_once('../includes/footer.php'); ?>
