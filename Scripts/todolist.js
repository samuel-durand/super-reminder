import {openEditForm, closeEditForm} from './script.js'

const listId = new URLSearchParams(window.location.search).get("listId")

// Affichage des tâches
const taskDisplay = (task, container, user, projectRole) => {
        
        const taskDiv = document.createElement('tr');
        taskDiv.classList.add('task');
        taskDiv.innerHTML = `
            <td>${task.name}</td>
            <td>${task.description}</td>
            <td>${task.end_date}</td>
            ${
                // si l'utilisateur est membre de la tâche ou admin du projet, on affiche les boutons d'édition et de suppression
                (task.members.find(member => member.user_id == user)  || 
                projectRole === "admin") ? (
                `<td>
                    <button id="done-btn${task.id}" class="btn">${task.status ? ("Restorer"):("Terminer")}</button>
                    <button id="edit-btn${task.id}" class="btn">Editer</button>
                    <button id="delete-btn${task.id}" class="btn">Supprimer</button>
                </td>`)
                : ('')
            }
        `;
    
        container.appendChild(taskDiv);
        // ajout des event listeners sur les boutons

        if (task.members.find(member => member.user_id == user)) {
            const doneBtn = document.querySelector(`#done-btn${task.id}`);
            const editBtn = document.querySelector(`#edit-btn${task.id}`);
            const deleteBtn = document.querySelector(`#delete-btn${task.id}`);
            
            doneBtn.addEventListener('click', () => {
                toggleStatus(task)
            });
            editBtn.addEventListener('click', () => {
                fillEditForm(task)
            });
            deleteBtn.addEventListener('click', () => {
                deleteTask(task.id)
            });
        }
};

// Affichage des membres du projet
const memberDisplay = (members) => {

    const memberList = document.querySelector('.member-list');
    memberList.innerHTML = '';

    members.forEach(member => {
        const memberDiv = document.createElement('div');
        memberDiv.classList.add('member');
        memberDiv.innerHTML = `
            <p>${member.login}: ${member.role}</p>
            
        `;
        memberList.appendChild(memberDiv);
    });
};

// Récupération des tâches
const getTasks = () => {

    const memberList = document.querySelector('.member-list');
    const taskList = document.querySelector('.current-tasks');
    const doneTaskList = document.querySelector('.done-tasks');

    // Récupération des tâches
    fetch("./../Route/Tasks/getTasks.php/?listId=" + listId + "")
        .then(res => res.json())
        .then(data => {

            taskList.innerHTML = '';
            doneTaskList.innerHTML = '';

            let userRole = data.members.find(member => member.user_id == data.user).role;

            data.tasks.forEach(task => {

                // Affichage des tâches dans le DOM
                if (!task.status) {
                    taskDisplay(task, taskList, data.user, userRole);
                } else {
                    taskDisplay(task, doneTaskList, data.user, data.userRole);
                }
            });

            // Affichage des membres dans le DOM
            if (memberList.innerHTML == '') {
                memberDisplay(data.members);
            }
        })
};

// Remplissage du formulaire d'édition
const fillEditForm = (task) => {
    openEditForm();
    const editName = document.querySelector('#edit-name');
    const editDescription = document.querySelector('#edit-description');
    const editDate = document.querySelector('#edit-date');
    const editId = document.querySelector('#edit-id');

    editName.value = task.name;
    editDescription.value = task.description;
    editDate.value = task.end_date;
    editId.value = task.id;

    const editBtn = document.querySelector('#edit-btn');
    editBtn.addEventListener('click', () => {
        editTask(task.id)
    });

};

// Ouverture du formulaire d'édition
const openMemberForm = () => {
    
        const container = document.querySelector('.modal-container');
        const memberForm = document.querySelector('.invite-form');
    
        container.classList.remove('hidden');
        memberForm.classList.remove('hidden');
}

// fermeture du formulaire d'édition
const closeMemberForm = () => {

    const container = document.querySelector('.modal-container');
    const memberForm = document.querySelector('.invite-form');

    container.classList.add('hidden');
    memberForm.classList.add('hidden');
}

// Ouverture du formulaire de suppression de membre
const openRemoveMemberForm = () => {
    
    const container = document.querySelector('.modal-container');
    const memberForm = document.querySelector('.remove-form');

    container.classList.remove('hidden');
    memberForm.classList.remove('hidden');
}

// fermeture du formulaire de suppression de membre
const closeRemoveMemberForm = () => {

const container = document.querySelector('.modal-container');
const memberForm = document.querySelector('.remove-form');

container.classList.add('hidden');
memberForm.classList.add('hidden');
}

// Ajout d'un membre
const inviteMember = () => {

    const user = document.querySelector('#user').value;
    const role = document.querySelector('#role').value;

    fetch("./../Route/Projects/addMember.php", {
        method: "POST",
        body: JSON.stringify({
            userId: user,
            role: role,
            projectId: listId
        })
    })
    closeMemberForm();
}

// Suppression d'un membre
const removeMember = () => {

        if(!confirm('Voulez-vous vraiment supprimer ce membre ?')) return 0;

        const user = document.querySelector('#remove-user').value;
        console.log(user);
        fetch("./../Route/Projects/removeMember.php", {
            method: "POST",
            body: JSON.stringify({
                userId: user,
                projectId: listId
            })
        })
        closeRemoveMemberForm();
}

// edition d'une tâche
const editTask = (id) => {
    const editName = document.querySelector('#edit-name');
    const editDescription = document.querySelector('#edit-description');
    const editDate = document.querySelector('#edit-date');

    fetch("./../Route/Tasks/editTask.php", {
        method: "POST",
        body: JSON.stringify({
            id: id,
            name: editName.value,
            description: editDescription.value,
            list_id: listId,
            end_date: editDate.value
        })
    })
    .then(() => getTasks())
    closeEditForm();
};

// Changement de statut d'une tâche
const toggleStatus = (task) => {

    fetch("./../Route/Tasks/toggleTask.php", {
        method: "POST",
        body: JSON.stringify({
            id: task.id,
            status: task.status
        })
    })
    .then(() => getTasks())
};

// Suppression d'une tâche
const deleteTask = (id) => {
    if (!confirm('Voulez-vous vraiment supprimer cette tâche ?')) return 0;

    fetch("./../Route/Tasks/deleteTask.php", {
        method: "POST",
        body: JSON.stringify({
            id: id
        })
    })
    .then(() => getTasks())
};

// Ajout d'une tâche
const addTask = () => {
    const name = document.querySelector('#name').value;
    const description = document.querySelector('#description').value;
    const date = document.querySelector('#date').value;

    fetch("./../Route/Tasks/addTask.php", {
        method: "POST",
        body: JSON.stringify({
            name: name,
            description: description,
            end_date: date,
            list_id: listId
        })
    })
    .then(() => getTasks())
};

document.addEventListener('DOMContentLoaded', function() {

    getTasks();

    const addBtn = document.querySelector('#add-btn');
    const cancelBtn = document.querySelector('#cancel-btn');

    const inviteBtn = document.querySelector('#invite-btn');
    const removeBtn = document.querySelector('#remove-btn');

    const addMemberBtn = document.querySelector('#add-member-btn');
    const removeMemberBtn = document.querySelector('#remove-member-btn');

    const cancelInviteBtn = document.querySelector('#cancel-invite-btn');
    const cancelRemoveBtn = document.querySelector('#cancel-remove-btn');

    addBtn && addBtn.addEventListener('click', () => {
        addTask();
    })

    cancelBtn && cancelBtn.addEventListener('click', () => {
        closeEditForm();
    })

    inviteBtn && inviteBtn.addEventListener('click', () => {
        inviteMember();
    })

    addMemberBtn && addMemberBtn.addEventListener('click', () => {
        openMemberForm();
    })

    cancelInviteBtn && cancelInviteBtn.addEventListener('click', () => {
        closeMemberForm();
    })

    removeBtn && removeBtn.addEventListener('click', () => {
        removeMember();
    })

    removeMemberBtn && removeMemberBtn.addEventListener('click', () => {
        openRemoveMemberForm();
    })

    cancelRemoveBtn && cancelRemoveBtn.addEventListener('click', () => {
        closeRemoveMemberForm();
    })
});