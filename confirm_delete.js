function confirmDelete() {
    let confirmResult = confirm("Êtes-vous sûr de vouloir supprimer votre compte ?");
    if (confirmResult) {
        // Récupérez l'ID de l'utilisateur depuis l'URL
        const urlParams = new URLSearchParams(window.location.search);
        const userId = urlParams.get("id");

        // Vérifiez si l'ID de l'utilisateur est présent
        if (userId) {
            // Effectuez une requête FETCH pour supprimer le compte
            fetch(`profile.php?id=${userId}&action=delete`, {
                method: "POST",
            })
                .then((response) => {
                    if (response.ok) {
                        return response.text();
                    } else {
                        throw new Error("Une erreur s'est produite lors de la suppression du compte.");
                    }
                })
                .then((data) => {
                    // Traitez la réponse du serveur après la suppression (par exemple, redirection ou affichage d'un message)
                    alert("Votre compte a été supprimé avec succès !");
                    window.location.href = "index.php"; // Redirigez l'utilisateur vers la page d'accueil après la suppression
                })
                .catch((error) => {
                    // Gérez les erreurs en cas d'échec de la suppression
                    alert(error.message);
                });
        } else {
            alert("Impossible de déterminer l'ID de l'utilisateur.");
        }
    }
}
