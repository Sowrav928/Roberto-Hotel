// For Header
// For Collasable Menu
function toggleMenu() {
    var navLinks = document.getElementById("navLinks");
    navLinks.classList.toggle("show");
}

// Add 'active' class to the clicked menu item
const menuLinks = document.querySelectorAll('.nav-links li a');

const activeMenu = localStorage.getItem('activeMenu');
if (activeMenu) {
document.querySelector(`.nav-links li a[href="${activeMenu}"]`).parentElement.classList.add('active');
}

menuLinks.forEach(link => {
link.addEventListener('click', function() {
    menuLinks.forEach(item => item.parentElement.classList.remove('active'));
    this.parentElement.classList.add('active');
    localStorage.setItem('activeMenu', this.getAttribute('href'));
});
});


