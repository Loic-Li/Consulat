<?php
session_start();

$title = "Page de Paiement";
$cssFiles = 'payment';
$isLoggedIn = isset($_SESSION['user_id']);

require_once '../includes/header.php';

// Vérifie si les informations nécessaires sont disponibles dans la session
if (!isset($_SESSION['tarifTotal'])) {
    // Si l'une des informations est manquante, redirige vers la page de demande de visa
    header("Location: visa.php");
    exit();
}

$tarifTotal = $_SESSION['tarifTotal'];  // Récupère le tarif total depuis la session
$nationality = $_SESSION['nationality'];  // Récupère la nationalité depuis la session
$sejour = $_SESSION['sejour'];  // Récupère la durée du séjour depuis la session
?>

<div class="container mt-5">
    <h2 class="text-center">Page de Paiement</h2>

    <!-- Section de résumé de la commande -->
    <div class="alert alert-info">
        <h4>La somme de votre demande (en €) :</h4>
        <ul>
            <li><strong>Coût total de votre demande :</strong> <?php echo $tarifTotal; ?>€</li>
        </ul>
    </div>

    <!-- Formulaire de paiement -->
    <form action="../controllers/process_payment.php" method="POST">
        <h4>Mode de Paiement</h4>
        <div class="mb-3">
            <label for="paymentMethod" class="form-label">Choisissez votre méthode de paiement</label>
            <select class="form-select" id="paymentMethod" name="paymentMethod" required>
                <option value="carte_credit">Carte de Crédit</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="cardNumber" class="form-label">Numéro de carte de crédit</label>
            <input type="text" class="form-control" id="cardNumber" name="cardNumber" placeholder="**** **** **** ****" required>
        </div>

        <div class="mb-3">
            <label for="expirationDate" class="form-label">Date d'expiration</label>
            <input type="month" class="form-control" id="expirationDate" name="expirationDate" required>
        </div>

        <div class="mb-3">
            <label for="cvv" class="form-label">CVV</label>
            <input type="text" class="form-control" id="cvv" name="cvv" placeholder="***" required>
        </div>

        <!-- Champ caché pour envoyer le tarif total -->
        <input type="hidden" name="tarifTotal" value="<?php echo $tarifTotal; ?>">

        <!-- Bouton de soumission -->
        <button type="submit" class="btn btn-primary w-100" id="submitBtn">Payer <?php echo $tarifTotal; ?>€</button>
    </form>

    <!-- Si un utilisateur n'a pas encore payé, afficher un message indiquant qu'il doit effectuer le paiement -->
    <div class="alert alert-warning mt-4" id="paymentStatus">
        <p>Votre paiement est nécessaire pour finaliser votre demande de VISA.</p>
    </div>
</div>

<?php require_once '../includes/footer.php'; ?>
