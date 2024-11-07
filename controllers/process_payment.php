<?php
session_start();
$isLoggedIn = isset($_SESSION['user_id']);

include_once '../config/db.php';

require_once '../includes/header.php';
// Simulation du paiement réussi
$paymentSuccess = true; // On suppose que le paiement est validé ici

// Si le paiement est validé, enregistrer la demande
if ($paymentSuccess) {
    // Récupération des informations soumises par le formulaire
    $paymentMethod = $_POST['paymentMethod'];
    $cardNumber = $_POST['cardNumber'];

    // Enregistrer la demande dans la base de données
    $sql = "INSERT INTO demandes (payment_method, card_number, payment_status)
            VALUES (:payment_method, :card_number, :payment_status)";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':payment_method' => $paymentMethod,
        ':card_number' => $cardNumber,
        ':payment_status' => 'Payé' // Statut du paiement
    ]);

    // Confirmation du paiement
    echo "<h3>Paiement effectué avec succès !</h3>";
    echo "<p>Votre demande a été enregistrée. Un email de confirmation vous a été envoyé.</p>";

    // Vous pouvez rediriger l'utilisateur vers une autre page après un paiement réussi
    // header('Location: confirmation.php');
} else {
    // En cas de paiement échoué (cas simulé, mais vous pouvez gérer ici de vrais cas)
    echo "<h3>Le paiement a échoué. Veuillez réessayer.</h3>";
}
?>
