const burgerMenu = document.getElementById('burger-menu');
const sidebar = document.getElementById('sidebar');

burgerMenu.addEventListener('click', () => {
    burgerMenu.classList.toggle('active');
    sidebar.classList.toggle('active');
});
