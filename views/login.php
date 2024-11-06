<?php
    $title = 'Connexion';
    $cssFile = 'form'; // Ajouter un fichier CSS spécifique si besoin
    include '../includes/header.php'; // Inclure le header
?>

<div class="container mt-5 d-flex justify-content-center">
    <div class="col-md-6 p-4 rounded shadow-sm custom-form-background">
        <h2 class="text-center mb-4">Connexion</h2>
        <form action="../controllers/login_controller.php" method="POST" class="needs-validation" novalidate>
            <div class="mb-3">
                <label for="email" class="form-label">Adresse e-mail</label>
                <input type="email" class="form-control" id="email" name="email" required>
                <div class="invalid-feedback">
                    Veuillez entrer une adresse e-mail valide.
                </div>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Mot de passe</label>
                <input type="password" class="form-control" id="password" name="password" required>
                <div class="invalid-feedback">
                    Veuillez entrer votre mot de passe.
                </div>
            </div>

            <div class="d-grid">
                <button type="submit" class="btn btn-primary">Se connecter</button>
            </div>
        </form>
    </div>
</div>

<?php include '../includes/footer.php'; // Inclure le footer ?>
