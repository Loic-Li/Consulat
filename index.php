<?php
session_start();
$isLoggedIn = isset($_SESSION['user_id']);
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


<?php
    $jsFile = "index";
    include 'includes/footer.php';
?>
