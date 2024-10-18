<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consulat de Chine</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <?php
        // Déterminer quel CSS charger
        $basePath = (strpos($_SERVER['SCRIPT_NAME'], '/views/') !== false) ? '../' : '';
        
        if (isset($cssFile)) {
            echo '<link rel="stylesheet" href="' . $basePath . 'assets/css/' . htmlspecialchars($cssFile) . '.css">';
        }
    ?>
</head>

<body>

    <!-- Bande rouge avec le logo et les boutons -->
    <nav class="navbar navbar-expand-lg navbar-custom p-3">
        <div class="container-fluid">
            <div class="d-flex align-items-center">
                <img src="<?php echo $basePath; ?>assets/img/china-flag.png" alt="Drapeau de la Chine" class="navbar-flag me-2">
                <h1 class="navbar-brand text-light m-0 title">Consulat de Chine</h1>
            </div>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                        <?php if (basename($_SERVER['SCRIPT_NAME']) !== 'index.php'): ?>
                            <li class="nav-item">
                                <a class="nav-link" href="../index.php">Accueil</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="country.php">Notre Pays</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="culture.php">Notre Culture</a>
                            </li>
                        <?php endif; ?>
                </ul>

                <div>
                    <?php if (basename($_SERVER['SCRIPT_NAME']) === 'index.php'): ?>
                        <button class="btn btn-custom me-2 login-in">Connexion</button>
                        <button class="btn btn-custom sign-in">Inscription</button>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>
