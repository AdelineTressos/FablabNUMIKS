document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('searchInput');

    searchInput.addEventListener('keyup', function (e) {
        const searchTerm = e.target.value.toLowerCase().trim();
        const publications = document.querySelectorAll('.card.h-100');

        publications.forEach(function (publication) {
            // S'assurer que 'title' est toujours une chaîne pour éviter les erreurs, et trim + toLowerCase pour la robustesse
            const title = (publication.getAttribute('data-title') || '').toLowerCase().trim();
            
            if (title.includes(searchTerm)) {
                publication.style.display = '';
            } else {
                publication.style.display = 'none';
            }
        });
    });
});