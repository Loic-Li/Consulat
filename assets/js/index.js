let country = document.querySelector('.notre-pays');
let login = document.querySelector('.login-in');
let sign = document.querySelector('.sign-in');
country.addEventListener('click', function () {
    window.location.href = 'views/country.php';
});
login.addEventListener('click', function () {
    window.location.href = 'login.php';
});
sign.addEventListener('click', function () {
    window.location.href = 'register.php';
});

