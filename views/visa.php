<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
$isOnIndex = false;
$title = "Demande de VISA";

$cssFiles = 'visa';
$isLoggedIn = isset($_SESSION['user_id']);

require_once '../includes/header.php';
require_once '../config/db.php';

$user_id = $_SESSION['user_id'];
// Préparer et exécuter la requête pour récupérer les informations de l'utilisateur
$stmt = $pdo->prepare("SELECT first_name, last_name, email, phone FROM users WHERE id = :user_id");
$stmt->execute([':user_id' => $user_id]);

// Vérifier si l'utilisateur existe
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($user) {
    // Affichage des informations de l'utilisateur
    $first_name = $user['first_name'];
    $last_name = $user['last_name'];
    $email = $user['email'];
    $phone = $user['phone'];
} else {
    // Si l'utilisateur n'est pas trouvé dans la base de données
    echo "Aucun utilisateur trouvé.";
}

// Tarifs en fonction de la nationalité
$tarifsNationalites = [
    'Française' => 50,
    'Allemande' => 55,
    'Américaine' => 70,
    'Autre' => 60,
];

// Tarifs en fonction de la durée de séjour (en jours)
$tarifDureeSejour = [
    '30' => 50,    // Séjour de 30 jours
    '60' => 75,    // Séjour de 60 jours
    '90' => 100,   // Séjour de 90 jours
    '180' => 150,  // Séjour de 180 jours
    '365' => 200   // Séjour d'un an
];

$tarifTotal = 0;  // Initialisation du tarif total

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nationality = $_POST['nationality'] ?? 'Autre';
    $sejour = $_POST['sejour'] ?? '30';  // Séjour de 30 jours par défaut

    // Si la nationalité est chinoise, on applique 0€ pour le tarif
    if ($nationality == 'Chinoise') {
        $tarifTotal = 0;
    } else {
        // Calcul du tarif en fonction de la nationalité et de la durée du séjour
        $tarifTotal = $tarifsNationalites[$nationality] ?? $tarifsNationalites['Autre'];
        $tarifTotal += $tarifDureeSejour[$sejour];
    }

    // On passe le tarif total à la page suivante (payment.php)
    $_SESSION['tarifTotal'] = $tarifTotal;

    // Redirection vers la page de paiement
    header("Location: payment.php");
    exit();
}


?>

<div class="container mt-5">
    <h2 class="text-center">Demande de VISA</h2>

    <!-- Informations sur la demande de visa -->
    <div class="alert alert-info">
        <h4>Documents nécessaires pour la demande :</h4>
        <ul>
            <li>Pièce d'identité (carte d'identité, passeport, etc.)</li>
            <li>Justificatif de domicile</li>
            <li>Photo passeport récente</li>
            <li>Formulaire de demande rempli</li>
        </ul>
        <h4>Tarifs :</h4>
        <p><strong>Le tarif varie selon la nationalité et la durée du séjour :</strong></p>
        <ul>
            <li>Nationalité : <strong>Française - 50€</strong>, Allemande - 55€, Américaine - 70€, Autre - 60€</li>
            <li>Durée du séjour :
                <ul>
                    <li>30 jours : 50€</li>
                    <li>60 jours : 75€</li>
                    <li>90 jours : 100€</li>
                    <li>180 jours : 150€</li>
                    <li>1 an : 200€</li>
                </ul>
            </li>
        </ul>
    </div>

    <div class="form-container">
        <!-- Formulaire de demande -->
        <form action="visa.php" method="post" enctype="multipart/form-data">
            <!-- Formulaire des informations personnelles -->
            <div class="mb-3">
                <label for="firstName" class="form-label">Prénom</label>
                <input type="text" class="form-control" id="firstName" name="firstName" value="<?php echo htmlspecialchars($first_name); ?>" readonly required>
            </div>

            <div class="mb-3">
                <label for="lastName" class="form-label">Nom</label>
                <input type="text" class="form-control" id="lastName" name="lastName" value="<?php echo htmlspecialchars($last_name); ?>" readonly required>
            </div>
            <div class="mb-3">
                <label for="dob" class="form-label">Date de Naissance</label>
                <input type="date" class="form-control" id="dob" name="dob" required>
            </div>
            <div class="mb-3">
                <label for="nationality" class="form-label">Nationalité</label>
                <select class="form-select" id="nationality" name="nationality" required>
                    <option value="Française">Française</option>
                    <option value="Allemande">Allemande</option>
                    <option value="Américaine">Américaine</option>
                    <option value="Autre">Autre</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="passportNumber" class="form-label">Numéro de passeport</label>
                <input type="text" class="form-control" id="passportNumber" name="passportNumber" placeholder="AB1234567" required maxlength="9">
            </div>
            <!-- Email pré-rempli -->
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" readonly required>
            </div>

            <!-- Téléphone pré-rempli -->
            <div class="mb-3">
                <label for="phone" class="form-label">Numéro de téléphone</label>
                <input type="text" class="form-control" id="phone" name="phone" value="<?php echo htmlspecialchars($phone); ?>" readonly required>
            </div>

            <!-- Sélection de la durée du séjour -->
            <div class="mb-3">
                <label for="sejour" class="form-label">Durée du Séjour (en jours)</label>
                <select class="form-select" id="sejour" name="sejour" required>
                    <option value="30">30 jours</option>
                    <option value="60">60 jours</option>
                    <option value="90">90 jours</option>
                    <option value="180">180 jours</option>
                    <option value="365">1 an</option>
                </select>
            </div>

            <!-- Champs de téléchargement des documents -->
            <div class="mb-3">
                <label for="identityDocument" class="form-label">Pièce d'Identité</label>
                <input type="file" class="form-control" id="identityDocument" name="identityDocument" accept=".jpg,.jpeg,.png,.pdf" required>
            </div>
            <div class="mb-3">
                <label for="addressProof" class="form-label">Justificatif de Domicile</label>
                <input type="file" class="form-control" id="addressProof" name="addressProof" accept=".jpg,.jpeg,.png,.pdf" required>
            </div>
            <div class="mb-3">
                <label for="passportPhoto" class="form-label">Photo Passeport</label>
                <input type="file" class="form-control" id="passportPhoto" name="passportPhoto" accept=".jpg,.jpeg,.png" required>
            </div>

            <!-- Champ caché pour envoyer le tarif calculé -->
            <input type="hidden" id="tarifTotal" name="tarifTotal" value="0">


            <button type="submit" class="btn btn-primary w-100" id="submitBtn">Soumettre la Demande</button>
        </form>

        <!-- Affichage du tarif calculé -->
        <div class="alert alert-success mt-4">
            <h5>Coût de votre demande : <strong id="tarifDisplay">0€</strong></h5>
        </div>
    </div>
</div>

<?php
$jsFile = 'visa';
require_once '../includes/footer.php'; ?>
