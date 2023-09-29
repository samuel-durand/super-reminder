import {openEditForm, closeEditForm} from './script.js'

// Affichage des projets
const projectDisplay = (project, projectDiv, user) => {

    const projectRow = document.createElement('tr');
    projectRow.classList.add('project');

    projectRow.innerHTML = `
        <td><a href="todolist.php/?listId=${project.id}">${project.name}</a></td>
        <td>${project.description}</td>
        <td>${project.end_date}</td>
        ${
            // si l'utilisateur est admin du projet, on affiche les boutons d'édition et de suppression
            project.members.find(member => member.user_id == user).role == 'admin' ? (
            `<td>
                <button id="edit-btn${project.id}" class="btn">Editer</button>
                <button id="delete-btn${project.id}" class="btn">Supprimer</button>
            </td>`)
            : ('')
        }
    `;
    projectDiv.appendChild(projectRow);
    
    if (project.members.find(member => member.user_id == user).role == 'admin') {
        const editBtn = document.querySelector(`#edit-btn${project.id}`);
        const deleteBtn = document.querySelector(`#delete-btn${project.id}`);

        editBtn.addEventListener('click', () => {
            fillEditForm(project);
        });
        deleteBtn.addEventListener('click', () => {
            deleteProject(project.id);
        });
    }

}

// Récupération des projets
const getProjects = () => {

    const projectDiv = document.querySelector('.current-projects');

    fetch('./Route/Projects/getProjects.php')
    .then(response => response.json())
    .then(data => {
        projectDiv.innerHTML = '';

        data.projects.forEach(project => {
            projectDisplay(project, projectDiv, data.user);
        });
    });
};

// Remplissage du formulaire d'édition
const fillEditForm = (project) => {

    openEditForm();
    const editName = document.querySelector('#edit-name');
    const editDescription = document.querySelector('#edit-description');
    const editDate = document.querySelector('#edit-date');
    const editBtn = document.querySelector('#edit-btn');

    editName.value = project.name;
    editDescription.value = project.description;
    editDate.value = project.end_date;

    editBtn.addEventListener('click', () => {
        editProject(project.id);
    });
};

// Suppression d'un projet
const deleteProject = (id) => {

    if(!confirm('Voulez-vous vraiment supprimer ce projet ?')) {
        return;
    }

    fetch('./Route/Projects/deleteProject.php', {
        method: 'POST',
        body: JSON.stringify({id: id})
    })
    .then(getProjects);
};

// Ajout d'un projet
const addProject = () => {

    const name = document.querySelector('#name');
    const description = document.querySelector('#description');
    const end_date = document.querySelector('#date');

    fetch('./Route/Projects/addProject.php', {
        method: 'POST',
        body: JSON.stringify({
            name: name.value,
            description: description.value,
            end_date: end_date.value
        })
    })
    .then(getProjects);
};

// Edition d'un projet
const editProject = (id) => {

    const editName = document.querySelector('#edit-name');
    const editDescription = document.querySelector('#edit-description');
    const editDate = document.querySelector('#edit-date');

    fetch('./Route/Projects/editProject.php', {
        method: 'POST',
        body: JSON.stringify({
            id: id,
            name: editName.value,
            description: editDescription.value,
            end_date: editDate.value
        })
    })
    .then(getProjects);
    closeEditForm();
};


document.addEventListener('DOMContentLoaded', function() {

    getProjects();
    const addProjectBtn = document.querySelector('#add-btn');
    const cancelBtn = document.querySelector('#cancel-btn');

    addProjectBtn.addEventListener('click', () => {
        addProject();
    });

    cancelBtn.addEventListener('click', () => {
        closeEditForm();
    });
});