let country = document.querySelector('.notre-pays');
let login = document.querySelector('.login-in');
let sign = document.querySelector('.sign-in');
country.addEventListener('click', function () {
    window.location.href = 'views/country.php';
});
login.addEventListener('click', function () {
    window.location.href = 'views/login.php';
});
sign.addEventListener('click', function () {
    window.location.href = 'views/register.php';
});
