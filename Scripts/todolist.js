const getTasks = () => {

    const taskList = document.querySelector('.tasks-container');
    taskList.innerHTML = '';

    // Récupération des tâches
    fetch("./Route/getTasks.php")
        .then(res => res.json())
        .then(data => {
            data.tasks.forEach(task => {

                // Affichage des tâches dans le DOM
                let taskDiv = document.createElement('div');
                taskDiv.classList.add('task');
                taskDiv.innerHTML = `<p>${task.name}</p>
                                    <p>${task.description}</p>
                                    <button class="edit-btn" value="${task.id}">Edit</button>
                                    <button class="delete-btn" value="${task.id}">Delete</button>`;
                taskList.appendChild(taskDiv);
            });
        })
        .then(() => {

            // Ajout des event listeners sur les boutons
            const editBtns = document.querySelectorAll('.edit-btn');
            const deleteBtns = document.querySelectorAll('.delete-btn');

            console.log(editBtns)
            console.log(deleteBtns)

            editBtns.forEach(btn => {
                btn.addEventListener('click', () => {
                    console.log(btn.value)
                })
            });
            deleteBtns.forEach(btn => {
                btn.addEventListener('click', () => {
                    deleteTask(btn.value)
                })
            });
        })
};


const editTask = (id) => {

};

// Suppression d'une tâche
const deleteTask = (id) => {
    fetch("./Route/deleteTask.php", {
        method: "POST",
        body: JSON.stringify({
            id: id
        })
    })
    .then(() => getTasks())
};

document.addEventListener('DOMContentLoaded', function() {

    getTasks();


});