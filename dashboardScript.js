document.addEventListener('DOMContentLoaded', () => {
    const menuItems = document.querySelectorAll('.menu-item');
    const sections = document.querySelectorAll('.dashConSection');

    menuItems.forEach(item => {
        item.addEventListener('click', (e) => {
            e.preventDefault();
            menuItems.forEach(menu => menu.classList.remove('active'));
            item.classList.add('active');
            sections.forEach(section => section.style.display = 'none');
            const sectionId = item.getAttribute('data-section');
            document.getElementById(sectionId).style.display = 'block';
        });
    });
});