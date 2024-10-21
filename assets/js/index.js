document.addEventListener('DOMContentLoaded', function () {
    let country = document.querySelector('.notre-pays');

    country.addEventListener('click', function () {
        window.location.href = 'views/country.php';
    });
});
    