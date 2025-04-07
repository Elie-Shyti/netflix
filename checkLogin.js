document.addEventListener("DOMContentLoaded", function() {
    // Sélectionne le formulaire et le champ du mot de passe de connexion
    const form = document.querySelector("form");
    const passwordInput = document.getElementById("motdepasse");

    // Écoute la soumission du formulaire
    form.addEventListener("submit", function(event) {
        // Vérifie que le mot de passe comporte au moins 8 caractères
        if (passwordInput.value.length < 8) {
            // Appliquer un contour rouge au champ
            passwordInput.style.border = "2px solid red";
            // Afficher un message d'erreur
            alert("Le mot de passe doit contenir au moins 8 caractères.");
            // Bloquer la soumission du formulaire
            event.preventDefault();
        } else {
            // Réinitialiser le style si le mot de passe est conforme
            passwordInput.style.border = "";
        }
    });
});