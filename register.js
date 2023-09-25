document.addEventListener('DOMContentLoaded', function() {
    const registrationForm = document.getElementById('registrationForm');

    registrationForm.addEventListener('submit', function(e) {
        e.preventDefault(); // Empêcher le formulaire de se soumettre normalement

        const formData = new FormData(this);

        fetch('Register.php', {
            method: 'POST',
            body: formData
        })
        .then(function(response) {
            if (response.ok) {
                return response.json();
            } else {
                throw new Error('Erreur lors de la requête vers register.php');
            }
        })
        .then(function(data) {
            if (data.error) {
                console.error(data.error);
            } else {
                console.log('Données renvoyées par le serveur :', data);
                window.location.href = `login.php?id=${data.userId}`;
                alert('Vous êtes inscrit'); // Ajouter une alerte
            }
        })
        .catch(function(error) {
            console.error('Erreur lors de la requête fetch :', error);
        });
    });
});
