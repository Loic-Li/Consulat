<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
$isOnIndex = false;
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

// Traitement du paiement si le formulaire est soumis
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Simuler le paiement (vous pouvez remplacer cette logique avec un véritable système de paiement)
    $paymentSuccess = true; // Ici, vous simulez que le paiement est toujours réussi

    if ($paymentSuccess) {
        // Connexion à la base de données
        require_once '../config/db.php'; // Assurez-vous d'inclure votre fichier de connexion

        // Convertir le montant en float
        $montant = floatval($_POST['tarifTotal']);

        try {
            // Insertion des données dans la table 'demandes' après le paiement
            $sql = "INSERT INTO demandes (montant, statut, payment_status)
                    VALUES (:montant, 'en attente', 'non payé')";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':montant' => $montant
            ]);

            // Récupérer l'ID de la dernière insertion
            $demandes_id = $pdo->lastInsertId();

            // Mise à jour du statut du paiement après insertion
            $updateSql = "UPDATE demandes SET payment_status = 'payé' WHERE id = :id";
            $updateStmt = $pdo->prepare($updateSql);
            $updateStmt->execute([
                ':id' => $demandes_id
            ]);

            // Message de succès
            $paymentMessage = "Paiement effectué avec succès ! Votre demande a été enregistrée.";

            // Redirection après paiement réussi
            header("Location: dashboard.php"); // Assurez-vous de créer cette page
            exit();
        } catch (PDOException $e) {
            // En cas d'erreur avec la base de données
            $paymentMessage = "Une erreur est survenue lors de l'enregistrement du paiement. Veuillez réessayer.";
        }
    } else {
        $paymentMessage = "Le paiement a échoué. Veuillez réessayer.";
    }
}

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
    <form action="payment.php" method="POST">
        <h4>Mode de Paiement</h4>
        <div class="mb-3">
            <label for="paymentMethod" class="form-label">Choisissez votre méthode de paiement</label>
            <select class="form-select" id="paymentMethod" name="paymentMethod" required>
                <option value="carte_credit">Carte de Crédit</option>
            </select>
        </div>

    <!-- Numéro de carte de crédit avec un masque -->
    <div class="mb-3">
        <label for="cardNumber" class="form-label">Numéro de carte de crédit</label>
        <input type="text" class="form-control" id="cardNumber" name="cardNumber" placeholder="**** **** **** ****" required pattern="\d{4} \d{4} \d{4} \d{4}" maxlength="19">
    </div>

    <!-- Sélecteur de la date d'expiration -->
    <div class="mb-3">
        <label for="expirationDate" class="form-label">Date d'expiration</label>
        <input type="text" class="form-control" id="expirationDate" name="expirationDate" placeholder="MM/AA" required maxlength="5">
    </div>

    <!-- CVV -->
    <div class="mb-3">
        <label for="cvv" class="form-label">CVV</label>
        <input type="text" class="form-control" id="cvv" name="cvv" placeholder="***" required pattern="\d{3}" maxlength="3">
    </div>

        <!-- Champ caché pour envoyer le tarif total -->
        <input type="hidden" name="tarifTotal" value="<?php echo $tarifTotal; ?>">

        <!-- Bouton de soumission -->
        <button type="submit" class="btn btn-primary w-100" id="submitBtn">Payer <?php echo $tarifTotal; ?>€</button>
    </form>

    <!-- Message de statut du paiement -->
    <?php if (isset($paymentMessage)): ?>
        <div class="alert alert-info mt-4">
            <p><?php echo $paymentMessage; ?></p>
        </div>
    <?php endif; ?>

</div>

<?php
$jsFile = 'payment';
require_once '../includes/footer.php'; ?>
