// ouverture du formulaire d'édition
export const openEditForm = () => {

    const container = document.querySelector('.modal-container');
    const editForm = document.querySelector('.edit-form');

    container.classList.remove('hidden');
    editForm.classList.remove('hidden');
};

// fermeture du formulaire d'édition
export const closeEditForm = () => {

    const container = document.querySelector('.modal-container');
    const editForm = document.querySelector('.edit-form');

    container.classList.add('hidden');
    editForm.classList.add('hidden');
}