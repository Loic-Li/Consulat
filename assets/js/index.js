document.addEventListener('DOMContentLoaded', function () {
    let country = document.querySelector('.notre-pays');

    country.addEventListener('click', function () {
        window.location.href = 'views/country.php';
    });
});

function currentPageCheck(url) {
    // Vérifie si l'URL actuelle correspond à celle du lien
    if (window.location.pathname.endsWith(url)) {
        return false; // Ne fait rien si on est déjà sur cette page
    }
    return true; // Sinon, suit le lien
}
