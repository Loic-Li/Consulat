<!-- footer.php -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>

<?php
    // Déterminer le chemin de base pour les fichiers JS
    $basePath = (strpos($_SERVER['SCRIPT_NAME'], '/views/') !== false) ? '../' : '';

    // Charger le fichier JS si défini
    if (isset($jsFile)) {
        echo '<script src="' . $basePath . 'assets/js/' . htmlspecialchars($jsFile) . '.js"></script>';
    }
    echo '<script src="' . $basePath . 'assets/js/global.js"></script>';
?>


</body>
</html>
