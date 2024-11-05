<?php
session_start();
$isLoggedIn = isset($_SESSION['user_id']);
$isOnIndex = basename($_SERVER['PHP_SELF']) === 'index.php';
$title = 'Accueil';
$cssFile = 'index';
include 'includes/header.php';
?>
<!-- Contenu principal -->
<div class="container content-wrapper">
    <div class="row align-items-center">
        <div class="col-md-6">
            <img src="assets/img/tower.png" alt="Image Shanghai" class="image-left">
        </div>
        <div class="col-md-6 d-flex flex-column align-items-center justify-content-center">
            <h2 class="text-center">Bienvenue sur le site officiel de la Chine</h2>
            <p class="text-center">Le Consulat de Chine vous accompagne dans vos démarches administratives :
                demandes de visa, services consulaires, et informations culturelles. Que vous soyez citoyen chinois
                ou étranger, trouvez ici les services et informations essentiels pour voyager ou vivre en Chine.</p>
            <button class="btn btn-outline-dark notre-pays">Notre Pays</button>
        </div>
    </div>
</div>

<br><br><br><br><br>

<div class="container my-5">
    <h1 class="text-center mb-4">Nous contacter</h1>
    <form action="contact_process.php" method="POST" class="contact-form bg-light mx-auto p-4 rounded shadow" style="max-width: 1000px;">
        <div class="mb-3">
            <label for="name" class="form-label">Nom</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">E-mail</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <div class="mb-3">
            <label for="subject" class="form-label">Sujet</label>
            <input type="text" class="form-control" id="subject" name="subject" required>
        </div>
        <div class="mb-3">
            <label for="message" class="form-label">Message</label>
            <textarea class="form-control" id="message" name="message" rows="5" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary w-100">Envoyer</button>
    </form>
</div>




<?php
    $jsFile = "index";
    include 'includes/footer.php';
?>
