document.addEventListener("DOMContentLoaded", function() {
    document.querySelectorAll('.navbar .dropdown').forEach(function(everydropdown){
        let timeoutId;

        // Fonction pour ouvrir le dropdown
        function openDropdown(el_link) {
            clearTimeout(timeoutId); // Annule la fermeture programmée
            let nextEl = el_link.nextElementSibling;
            if (!el_link.classList.contains('show')) {
                el_link.classList.add('show');
                nextEl.classList.add('show');
            }
        }

        // Fonction pour fermer le dropdown
        function closeDropdown(el_link) {
            // Programmation de la fermeture
            timeoutId = setTimeout(function() {
                let nextEl = el_link.nextElementSibling;
                if (el_link.classList.contains('show')) {
                    el_link.classList.remove('show');
                    nextEl.classList.remove('show');
                }
            }, 400); // Ajustez le délai si nécessaire
        }

        everydropdown.addEventListener('mouseenter', function(e){
            let el_link = this.querySelector('a[data-bs-toggle]');
            openDropdown(el_link);
        });

        everydropdown.addEventListener('mouseleave', function(e){
            let el_link = this.querySelector('a[data-bs-toggle]');
            closeDropdown(el_link);
        });

        // Gestion du clic sur le dropdown
        everydropdown.querySelector('a[data-bs-toggle]').addEventListener('click', function(e){
            if(this.classList.contains('show')) {
                closeDropdown(this); // Ferme si ouvert
            } else {
                openDropdown(this); // Ouvre si fermé
            }
            e.preventDefault(); // Empêche la navigation
        });

        // Permettre la navigation pour les liens à l'intérieur du menu déroulant
        everydropdown.querySelectorAll('.dropdown-menu a').forEach(function(link) {
            link.addEventListener('click', function(e) {
                // La navigation se fera normalement ici, sans prévenir le comportement par défaut
            });
        });
    });
});
