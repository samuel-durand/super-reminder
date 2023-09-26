const taskDisplay = (task, container) => {
    
        const taskDiv = document.createElement('tr');
        taskDiv.classList.add('task');
        taskDiv.innerHTML = `
            <td>${task.name}</td>
            <td>${task.description}</td>
            <td>${task.end_date}</td>
            <td>
                <button id="done-btn${task.id}" class="btn btn-success">${task.status ? ("Restorer"):("Terminer")}</button>
                <button id="edit-btn${task.id}" class="btn btn-primary">Editer</button>
                <button id="delete-btn${task.id}" class="btn btn-danger">Supprimer</button>
            </td>
        `;
    
        container.appendChild(taskDiv);
        // add event listeners on buttons
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
};

const getTasks = () => {

    const taskList = document.querySelector('.current-tasks');
    const doneTaskList = document.querySelector('.done-tasks');

    // Récupération des tâches
    fetch("./Route/getTasks.php")
        .then(res => res.json())
        .then(data => {

            taskList.innerHTML = '';
            doneTaskList.innerHTML = '';

            data.tasks.forEach(task => {
                console.log(task);
                // Affichage des tâches dans le DOM
                if (!task.status) {
                    taskDisplay(task, taskList);
                } else {
                    taskDisplay(task, doneTaskList);
                }
            });
        })
};

// function that automatically fills the edit form with the task's data
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
    const editId = document.querySelector('#edit-id');

    fetch("./Route/editTask.php", {
        method: "POST",
        body: JSON.stringify({
            id: editId.value,
            name: editName.value,
            description: editDescription.value,
            end_date: editDate.value
        })
    })
    .then(() => getTasks())
};

const toggleStatus = (task) => {

    fetch("./Route/toggleTask.php", {
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

    fetch("./Route/deleteTask.php", {
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

    fetch("./Route/addTask.php", {
        method: "POST",
        body: JSON.stringify({
            name: name,
            description: description,
            end_date: date
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