// Fonction principale asynchrone pour afficher les utilisateurs à partir du fichier PHP
async function displayUsers() {
    const response = await fetch('getUsers.php');
    const data = await response.json();
    const users = data.users;

    // Afficher les utilisateurs
    const usersTable = document.getElementById('users-table');
    usersTable.innerHTML = '';
    users.forEach(user => {
        const row = usersTable.insertRow();
        row.innerHTML = `
            <td>${user.id}</td>
            <td>${user.login}</td>
            <td>${user.firstname}</td>
            <td>${user.lastname}</td>
        `;
    });
}

// Fonction principale asynchrone pour afficher les tâches à partir du fichier PHP
async function displayTasks() {
    const response = await fetch('getTasks.php');
    const data = await response.json();
    const tasks = data.tasks;

    // Afficher les tâches
    const tasksTable = document.getElementById('tasks-table');
    tasksTable.innerHTML = '';
    tasks.forEach(task => {
        const row = tasksTable.insertRow();
        row.innerHTML = `
            <td>${task.id}</td>
            <td>${task.name}</td>
            <td>${task.description}</td>
            <td>${task.end_date}</td>
        `;
    });
}

// Appeler les fonctions pour afficher les utilisateurs et les tâches
displayUsers();
displayTasks();
