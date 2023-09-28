const listId = new URLSearchParams(window.location.search).get("listId")

const taskDisplay = (task, container, user, projectRole) => {
        
        const taskDiv = document.createElement('tr');
        taskDiv.classList.add('task');
        taskDiv.innerHTML = `
            <td>${task.name}</td>
            <td>${task.description}</td>
            <td>${task.end_date}</td>
            ${
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

const getTasks = () => {

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
        })
};

// fonction de remplissage du formulaire d'édition
const fillEditForm = (task) => {
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
};

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
    addBtn.addEventListener('click', (e) => {
        e.preventDefault();
        addTask();
    })
});