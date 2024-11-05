<?php
session_start();
$title = "Demande de VISA";

$cssFiles = 'visa';
$isLoggedIn = isset($_SESSION['user_id']);

require_once '../includes/header.php';
?>

<div class="container">
    <div class="form-container">
        <h2 class="text-center">Demande de VISA</h2>
        <form action="submit_visa_request.php" method="post" enctype="multipart/form-data"> <!-- Ajout de enctype -->
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
                <input type="text" class="form-control" id="nationality" name="nationality" required>
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

            <!-- Champs de téléchargement pour chaque document -->
            <div class="mb-3">
                <label for="identityDocument" class="form-label">Pièce d'Identité</label>
                <input type="file" class="form-control" id="identityDocument" name="identityDocument" accept=".jpg,.jpeg,.png,.pdf" required>
                <div class="form-text">Format accepté : JPG, JPEG, PNG, PDF.</div>
            </div>

            <div class="mb-3">
                <label for="addressProof" class="form-label">Justificatif de Domicile</label>
                <input type="file" class="form-control" id="addressProof" name="addressProof" accept=".jpg,.jpeg,.png,.pdf" required>
                <div class="form-text">Format accepté : JPG, JPEG, PNG, PDF.</div>
            </div>

            <div class="mb-3">
                <label for="passportPhoto" class="form-label">Photo Passeport</label>
                <input type="file" class="form-control" id="passportPhoto" name="passportPhoto" accept=".jpg,.jpeg,.png" required>
                <div class="form-text">Format accepté : JPG, JPEG, PNG.</div>
            </div>

            <div class="mb-3">
                <label for="photo" class="form-label">Photo</label>
                <input type="file" class="form-control" id="Photo" name="Photo" accept=".jpg,.jpeg,.png" required>
                <div class="form-text">Format accepté : JPG, JPEG, PNG.</div>
            </div>

            <button type="submit" class="btn btn-primary w-100">Soumettre la Demande</button>
        </form>
    </div>
</div>
<br><br><br><br><br>

<?php
include_once('../includes/footer.php');
?>
