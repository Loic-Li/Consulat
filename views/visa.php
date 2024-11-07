<?php
session_start();
$title = "Demande de VISA";

$cssFiles = 'visa';
$isLoggedIn = isset($_SESSION['user_id']);

require_once '../includes/header.php';

// Tarifs en fonction de la nationalité
$tarifsNationalites = [
    'Française' => 50,
    'Allemande' => 55,
    'Américaine' => 70,
    'Autre' => 60,
    // Pas de tarif pour les Chinois
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
        <form action="submit_visa_request.php" method="post" enctype="multipart/form-data">
            <!-- Formulaire des informations personnelles -->
            <div class="mb-3">
                <label for="firstName" class="form-label">Prénom</label>
                <input type="text" class="form-control" id="firstName" name="firstName" required>
            </div>
            <div class="mb-3">
                <label for="lastName" class="form-label">Nom</label>
                <input type="text" class="form-control" id="lastName" name="lastName" required>
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
                    <option value="Chinoise">Chinoise</option>
                    <option value="Autre">Autre</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="passportNumber" class="form-label">Numéro de Passeport</label>
                <input type="text" class="form-control" id="passportNumber" name="passportNumber" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="mb-3">
                <label for="phone" class="form-label">Numéro de Téléphone</label>
                <input type="tel" class="form-control" id="phone" name="phone" required>
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

            <button type="submit" class="btn btn-primary w-100">Soumettre la Demande</button>
        </form>

        <!-- Affichage du tarif calculé -->
        <div class="alert alert-success mt-4">
            <h5>Coût de votre demande : <strong><?php echo $tarifTotal; ?>€</strong></h5>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const nationalitySelect = document.getElementById('nationality');
        const sejourSelect = document.getElementById('sejour');
        const tarifDiv = document.querySelector('.alert-success h5');

        function updateTarif() {
            const nationality = nationalitySelect.value;
            const sejour = sejourSelect.value;
            let tarifTotal = 0;

            // Tarifs en fonction de la nationalité
            const tarifsNationalites = {
                'Française': 50,
                'Allemande': 55,
                'Américaine': 70,
                'Autre': 60,
            };

            // Tarifs en fonction de la durée de séjour
            const tarifDureeSejour = {
                '30': 50,
                '60': 75,
                '90': 100,
                '180': 150,
                '365': 200,
            };

            // Si la nationalité est chinoise, on applique 0€
            if (nationality === 'Chinoise') {
                tarifTotal = 0;
            } else {
                // Calcul du tarif en fonction de la nationalité et de la durée du séjour
                tarifTotal = tarifsNationalites[nationality] || tarifsNationalites['Autre'];
                tarifTotal += tarifDureeSejour[sejour] || tarifDureeSejour['30'];
            }

            // Mettre à jour le coût de la demande affiché
            tarifDiv.innerHTML = `Coût de votre demande : <strong>${tarifTotal}€</strong>`;
        }

        // Mettre à jour le tarif dès qu'un des champs est modifié
        nationalitySelect.addEventListener('change', updateTarif);
        sejourSelect.addEventListener('change', updateTarif);

        // Initialiser le tarif au chargement de la page
        updateTarif();
    });
</script>

<?php
include_once('../includes/footer.php');
?>
