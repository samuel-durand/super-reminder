document.addEventListener('DOMContentLoaded', function () {
    let submitButton = document.getElementById('submitButton');
    let registrationForm = document.getElementById('registrationForm');

    submitButton.addEventListener('click', function (e) {
        e.preventDefault();
        let login = document.getElementById('login').value;
        let firstname = document.getElementById('firstname').value;
        let lastname = document.getElementById('lastname').value;
        let password = document.getElementById('password').value;

        // Créez un objet FormData avec les données du formulaire
        let formData = new FormData();
        formData.append('login', login);
        formData.append('firstname', firstname);
        formData.append('lastname', lastname);
        formData.append('password', password);

        // Effectuez une requête asynchrone
        fetch('./Route/Projects/register.php', {
            method: 'POST',
            body: formData // Utilisez l'objet FormData ici
        })
        .then(function (response) {
            if (!response.ok) {
                throw new Error('Une erreur s\'est produite lors de la requête.');
            }
            return response.json();
        })
        .then(function (data) {
            if (data.success) {
                // L'inscription a réussi, affichez une alerte ou redirigez l'utilisateur
                alert('Inscription réussie! Redirection vers la page de connexion.');
                // Vous pouvez également rediriger l'utilisateur vers la page de connexion ici
                window.location.href = 'connexion.php?id=' + data.user.id;
            } else {
                // L'inscription a échoué, affichez un message d'erreur
                alert('Erreur lors de l\'inscription: ' + data.message);
            }
        })
        .catch(function (error) {
            console.error(error);
            alert('Une erreur s\'est produite lors de la requête.');
        });
    });
});
