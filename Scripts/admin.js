async function submitDeleteForm(formData) {
    try {
        const response = await fetch('./Admin/Delete_user_task.php', {
            method: 'POST',
            body: formData,
        });

        if (!response.ok) {
            throw new Error('Erreur lors de l\'envoi du formulaire de suppression.');
        }

        const responseData = await response.json();

        if (responseData.success) {
            alert(responseData.message); 
        } else {
            alert('Erreur : ' + responseData.errorMessage); // Afficher le message d'erreur
        }
    } catch (error) {
        console.error(error);
    }
}

const deleteForm = document.getElementById('delete-user-form');
deleteForm.addEventListener('submit', async (e) => {
    e.preventDefault(); 
    const formData = new FormData(deleteForm);

    await submitDeleteForm(formData);
});
