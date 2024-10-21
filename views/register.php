<?php
    $cssFile = 'form';
    include '../includes/header.php';
?>

<div class="container mt-5 d-flex justify-content-center">
    <div class="col-md-6 p-4 rounded shadow-sm custom-form-background">
        <h2 class="text-center mb-4">Créer un compte</h2>
        <form action="../config/register_process.php" method="POST" class="needs-validation" novalidate>
            <div class="row mb-3">
                <div class="col">
                    <label for="firstName" class="form-label">Prénom</label>
                    <input type="text" class="form-control" id="firstName" name="first_name" required>
                    <div class="invalid-feedback">
                        Veuillez entrer votre prénom.
                    </div>
                </div>
                <div class="col">
                    <label for="lastName" class="form-label">Nom</label>
                    <input type="text" class="form-control" id="lastName" name="last_name" required>
                    <div class="invalid-feedback">
                        Veuillez entrer votre nom.
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Adresse e-mail</label>
                <input type="email" class="form-control" id="email" name="email" required>
                <div class="invalid-feedback">
                    Veuillez entrer une adresse e-mail valide.
                </div>
            </div>

            <div class="mb-3">
                <label for="phone" class="form-label">Téléphone</label>
                <input type="text" class="form-control" id="phone" name="phone" required>
                <div class="invalid-feedback">
                    Veuillez entrer un numéro de téléphone valide.
                </div>
            </div>

            <div class="mb-3">
            <label for="password" class="form-label">Mot de passe</label>
            <div class="input-group">
                <input type="password" class="form-control" id="password" name="password" required>
                <span class="input-group-text">
                    <i class="fas fa-eye" id="togglePassword" style="cursor: pointer;"></i>
                </span>
                </div>
            </div>


            <div class="mb-3">
                <label for="confirmPassword" class="form-label">Confirmer le mot de passe</label>
                <input type="password" class="form-control" id="confirmPassword" name="confirm_password" required>
                <div class="invalid-feedback">
                    Veuillez confirmer votre mot de passe.
                </div>
            </div>

            <div class="d-grid">
                <button type="submit" class="btn btn-primary">S'inscrire</button>
            </div>
        </form>
    </div>
</div>

<?php
    $jsFile = "form";
    include '../includes/footer.php';
?>
