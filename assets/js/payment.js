// Fonction pour formater le numéro de carte de crédit
document.getElementById('cardNumber').addEventListener('input', function (e) {
    let value = e.target.value.replace(/\D/g, ''); // Supprimer tous les non-chiffres
    let formattedValue = '';

    // Ajouter un espace après chaque groupe de 4 chiffres
    for (let i = 0; i < value.length; i += 4) {
        formattedValue += value.slice(i, i + 4) + ' ';
    }

    // Supprimer l'espace supplémentaire à la fin
    e.target.value = formattedValue.trim();
});

// Fonction pour formater la date d'expiration (MM/AA)
document.getElementById('expirationDate').addEventListener('input', function (e) {
    let value = e.target.value.replace(/\D/g, ''); // Supprimer tous les non-chiffres
    let formattedValue = '';

    // Ajouter une barre après les 2 premiers chiffres (mois)
    if (value.length >= 2) {
        formattedValue = value.slice(0, 2) + '/' + value.slice(2, 4);
    } else {
        formattedValue = value;
    }

    e.target.value = formattedValue;
});
