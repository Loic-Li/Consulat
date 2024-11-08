<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title ?></title>
    <?php
    // Déterminer le chemin de base
    $basePath = (strpos($_SERVER['SCRIPT_NAME'], '/views/') !== false) ? '../' : '';

    // Inclure la favicon
    echo '<link rel="icon" href="' . $basePath . 'assets/img/china-flag.png" type="image/png">';
    ?>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <?php
        // Déterminer quel CSS charger
        $basePath = (strpos($_SERVER['SCRIPT_NAME'], '/views/') !== false) ? '../' : '';

        if (isset($cssFile)) {
            echo '<link rel="stylesheet" href="' . $basePath . 'assets/css/' . htmlspecialchars($cssFile) . '.css">';
        }
    ?>
    <link rel="stylesheet" href="<?php echo $basePath; ?>assets/css/global.css">
</head>

<body>

    <!-- Bande rouge avec le logo et les boutons -->
    <nav class="navbar navbar-expand-lg navbar-custom p-3">
        <div class="container-fluid">
            <div class="d-flex align-items-center">
                <img src="<?php echo $basePath; ?>assets/img/china-flag.png" alt="Drapeau de la Chine" class="navbar-flag me-2">
                <a class="navbar-brand text-light m-0 title"
                    href="<?php echo $isOnIndex ? '#' : '../index.php'; ?>"
                    <?php echo $isOnIndex ? 'onclick="return false;"' : ''; ?>>
                    Consulat de Chine
                </a>
            </div>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <?php if ($isLoggedIn): ?> <!-- Si l'utilisateur est connecté -->
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo $basePath; ?>index.php">Accueil</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo $basePath; ?>views/country.php">Pays</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo $basePath; ?>views/culture.php">Culture</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo $basePath; ?>views/dashboard.php">Mon Compte</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo $basePath; ?>views/logout.php">Déconnexion</a>
                        </li>
                    <?php else: ?> <!-- Si l'utilisateur n'est pas connecté -->
                        <li class="nav-item">
                            <a class="btn btn-custom me-2 login-in" href="<?php echo $basePath; ?>views/login.php">Connexion</a>
                        </li>
                        <li class="nav-item">
                            <a class="btn btn-custom sign-in" href="<?php echo $basePath; ?>views/register.php">Inscription</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>
