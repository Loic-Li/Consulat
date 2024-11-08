<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start();

// Vérifier si l'utilisateur est connecté
$isLoggedIn = isset($_SESSION['user_id']);

include_once '../config/db.php';
require '../vendor/autoload.php';
require_once '../includes/header.php';

// Simulation du paiement réussi (à remplacer par la logique de votre système de paiement réel)
$paymentSuccess = true; // On suppose que le paiement est validé ici

// Si le paiement est validé, enregistrer la demande
if ($paymentSuccess) {
    // Récupération des informations soumises par le formulaire
    $paymentMethod = $_POST['paymentMethod'];
    $cardNumber = $_POST['cardNumber'];

    // Récupération des informations de l'utilisateur depuis la session
    $userId = $_SESSION['user_id']; // L'ID utilisateur depuis la session
    $userEmail = $_SESSION['user_email']; // L'email utilisateur depuis la session

    // Récupérer les informations détaillées de l'utilisateur depuis la base de données
    $stmt = $pdo->prepare("SELECT full_name, nationality, duration_of_stay, total_price FROM users WHERE id = :user_id");
    $stmt->execute([':user_id' => $userId]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        // Enregistrer la demande dans la base de données
        $sql = "INSERT INTO demandes (payment_method, card_number, payment_status, user_id)
                VALUES (:payment_method, :card_number, :payment_status, :user_id)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':payment_method' => $paymentMethod,
            ':card_number' => $cardNumber,
            ':payment_status' => 'Payé', // Statut du paiement
            ':user_id' => $userId
        ]);

        // Création du récapitulatif dynamique
        $visaDetails = "
        <h1>Récapitulatif de votre demande de Visa</h1>
        <p><strong>Nom :</strong> {$user['full_name']}</p>
        <p><strong>Email :</strong> $userEmail</p>
        <p><strong>Nationalité :</strong> {$user['nationality']}</p>
        <p><strong>Durée du séjour :</strong> {$user['duration_of_stay']} jours</p>
        <p><strong>Tarif total :</strong> {$user['total_price']}€</p>
        <p><strong>Méthode de paiement :</strong> $paymentMethod</p>
        <p><strong>Numéro de carte :</strong> $cardNumber</p>
        ";

        $mail = new PHPMailer(true);

        try {
            // Paramétrage de PHPMailer
            $mail->isSMTP();
            $mail->Host = 'smtp.example.com'; // Définir l'hôte SMTP (ex. Gmail, SendGrid)
            $mail->SMTPAuth = true;
            $mail->Username = 'consulatoff@gmail.com'; // Votre email
            $mail->Password = 'qfsd zfmp qiid dohe'; // Votre mot de passe
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            // Destinataire
            $mail->setFrom('your_email@example.com', 'Service Visa');
            $mail->addAddress($userEmail); // Email du demandeur (provenant de la session)

            // Contenu de l'email
            $mail->isHTML(true);
            $mail->Subject = 'Confirmation de votre demande de Visa';
            $mail->Body    = $visaDetails;

            // Envoi de l'email
            $mail->send();
            echo "L'email a été envoyé avec succès.";
        } catch (Exception $e) {
            echo "L'email n'a pas pu être envoyé. Erreur : {$mail->ErrorInfo}";
        }

        // Confirmation du paiement
        echo "<h3>Paiement effectué avec succès !</h3>";
        echo "<p>Votre demande a été enregistrée. Un email de confirmation vous a été envoyé.</p>";
    } else {
        echo "<p>Erreur : Impossible de trouver les détails de l'utilisateur.</p>";
    }
} else {
    // En cas de paiement échoué (cas simulé, mais vous pouvez gérer ici de vrais cas)
    echo "<h3>Le paiement a échoué. Veuillez réessayer.</h3>";
}
?>
