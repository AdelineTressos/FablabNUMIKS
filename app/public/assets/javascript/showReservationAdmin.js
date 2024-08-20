

// Pour le modifier avant d'être envoyer machine 
document.addEventListener('DOMContentLoaded', function() {
    let updateBtn = document.getElementById('updateBtn');
    let confirmModal = new bootstrap.Modal(document.getElementById('confirmModal'), {});
  
    updateBtn.addEventListener('click', function() {
      confirmModal.show();
    });
  
    document.getElementById('confirmUpdateBtn').addEventListener('click', function() {
      let form = document.getElementById('myFormId');
      if(form) {
        form.submit();
      } else {
        console.error('Form not found!');
      }
    });
  });

  document.addEventListener('DOMContentLoaded', function() {
    // Fonction pour ouvrir le modal de confirmation de suppression
    window.openConfirmationModal = function(deleteUrl) {
      let confirmModal = new bootstrap.Modal(document.getElementById('deleteConfirmationModal'), {});
      confirmModal.show();
  
      // Configurer l'action pour le bouton de confirmation de suppression
      document.getElementById('deleteConfirmBtn').onclick = function() {
        window.location.href = deleteUrl; // Redirige vers l'URL de suppression
      };
    };
  
    // Attachement de la fonction openConfirmationModal à vos boutons de suppression existants
    // Assurez-vous que chaque bouton de suppression appelle cette fonction avec l'URL de suppression appropriée
  });


  document.addEventListener('DOMContentLoaded', function() {
    // Fonction pour ouvrir le modal de confirmation de validation
    window.openValidationModal = function(validationUrl) {
      let validationModal = new bootstrap.Modal(document.getElementById('validationConfirmationModal'), {});
      validationModal.show();
  
      // Configurer l'action pour le bouton de confirmation de validation
      document.getElementById('validateConfirmBtn').onclick = function() {
        window.location.href = validationUrl; // Redirige vers l'URL de validation
      };
    };
  });
  
  
  
