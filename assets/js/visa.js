document.addEventListener('DOMContentLoaded', function () {
    const nationalitySelect = document.getElementById('nationality');
    const sejourSelect = document.getElementById('sejour');
    const tarifDisplay = document.getElementById('tarifDisplay');
    const tarifInput = document.getElementById('tarifTotal');
    const submitBtn = document.getElementById('submitBtn');

    function updateTarif() {
        const nationality = nationalitySelect.value;
        const sejour = sejourSelect.value;
        let tarifTotal = 0;

        const tarifsNationalites = {
            'Française': 50,
            'Allemande': 55,
            'Américaine': 70,
            'Autre': 60,
            'Chinoise': 0 // Ajout d'un tarif pour les Chinois
        };

        const tarifDureeSejour = {
            '30': 50,
            '60': 75,
            '90': 100,
            '180': 150,
            '365': 200
        };

        if (nationality !== 'Chinoise') {
            tarifTotal += tarifsNationalites[nationality] || tarifsNationalites['Autre'];
            tarifTotal += tarifDureeSejour[sejour] || tarifDureeSejour['30']; // Si la durée est invalide, on met 30 jours
        }

        tarifDisplay.innerHTML = tarifTotal + '€';
        tarifInput.value = tarifTotal;
    }

    nationalitySelect.addEventListener('change', updateTarif);
    sejourSelect.addEventListener('change', updateTarif);

    updateTarif();
});

document.getElementById('passportNumber').addEventListener('input', function (e) {
    let value = e.target.value.replace(/[^A-Za-z0-9]/g, ''); // Supprimer les caractères non alphanumériques
    let formattedValue = '';

    // Si vous souhaitez un format spécifique, vous pouvez ajouter des séparateurs, etc.
    // Exemple simple : laissez l'utilisateur saisir jusqu'à 9 caractères (lettres et chiffres)
    e.target.value = value.toUpperCase(); // Mettre les lettres en majuscules
});


document.getElementById('dob').addEventListener('change', function() {
    const dob = new Date(this.value);
    const today = new Date();
    const dobError = document.getElementById('dobError');

    if (dob > today) {
        dobError.style.display = 'block';
        this.value = ''; // Réinitialise le champ
    } else {
        dobError.style.display = 'none';
    }
});
