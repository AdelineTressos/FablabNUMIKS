document.addEventListener('DOMContentLoaded', function() {
    const dropdownTriggers = document.querySelectorAll('.sidebar-item');
    dropdownTriggers.forEach(dropdownTrigger => {
        const dropdownMenu = dropdownTrigger.querySelector('.dropdown-content');

        if(dropdownMenu) {
            dropdownTrigger.addEventListener('mouseover', function() {
                dropdownMenu.style.display = 'block';
            });
            dropdownTrigger.addEventListener('mouseout', function() {
                dropdownMenu.style.display = 'none';
            });
        }
    });
});

document.addEventListener('DOMContentLoaded', function() {
    const sidebarLinks = document.querySelectorAll('.sidebar-link');
    const currentPath = window.location.pathname;

    sidebarLinks.forEach(function(link) {
        if (link.getAttribute('href') === currentPath) {
            link.classList.add('active-link');
        }
    });

    sidebarLinks.forEach(function(link) {
        link.addEventListener('click', function() {
            sidebarLinks.forEach(function(link) {
                link.classList.remove('active-link');
            });
            this.classList.add('active-link');
        });
    });
});

new DataTable('.sortTable');

document.addEventListener('DOMContentLoaded', (event) => {
    var myModal = new bootstrap.Modal(document.getElementById('exampleModal'), {
        keyboard: false
    });
});
