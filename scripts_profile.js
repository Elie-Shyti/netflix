// Lorsque la page est entièrement chargée, la fonction définie ici est exécutée
window.onload = function() {

    // On récupère l'élément HTML qui contiendra la liste des profils via son identifiant "profiles"
    var profilesContainer = document.getElementById("profiles");
    // On récupère le bouton pour ajouter un nouveau profil (élément avec l'id "addProfile")
    var addProfileButton = document.getElementById("addProfile");

    // On initialise une liste de profils, ici avec un profil par défaut "Défaut"
    var profiles = ["Défaut"];

    // Fonction qui se charge de mettre à jour l'affichage des profils dans la page
    function loadProfiles() {
        // On vide le contenu existant du conteneur de profils
        profilesContainer.innerHTML = "";

        // On parcourt la liste des profils
        for (var i = 0; i < profiles.length; i++) {
            // Création d'une nouvelle div pour représenter un profil
            var profileDiv = document.createElement("div");
            // On attribue à cette div la classe CSS "profile"
            profileDiv.className = "profile";

            // Création d'une balise image pour afficher l'icône du profil
            var profileImage = document.createElement("img");
            // On définit le chemin de l'image (ici une image par défaut)
            profileImage.src = "images/default-profile.png";
            // On définit le texte alternatif pour l'image, ici le nom du profil
            profileImage.alt = profiles[i];

            // Création d'une div pour afficher le nom du profil
            var profileName = document.createElement("div");
            // Attribution de la classe "profile-name" pour le style
            profileName.className = "profile-name";
            // Contenu textuel de la div, qui est le nom du profil actuel
            profileName.textContent = profiles[i];

            // Définition d'un gestionnaire d'évènement sur le clic du profil
            // On utilise une fonction anonyme pour créer une "closure" qui capture la valeur de l'indice i
            profileDiv.onclick = function(index) {
                return function() {
                    // Lorsqu'un profil est cliqué, on redirige vers "script_accueil.html"
                    window.location.href = "script_accueil.html";
                };
            }(i); // Ici, on passe l'indice courant (i) à la fonction pour se souvenir de la valeur

            // Ajout de l'image et du nom à la div du profil
            profileDiv.appendChild(profileImage);
            profileDiv.appendChild(profileName);

            // Ajout de la div du profil dans le conteneur général des profils
            profilesContainer.appendChild(profileDiv);
        }
    }

    // Définition du comportement du bouton "Ajouter un profil"
    addProfileButton.onclick = function() {
        // On demande à l'utilisateur de saisir le nom du nouveau profil via un prompt
        var newName = prompt("Nom du nouveau profil :");
        // Si l'utilisateur a fourni un nom (la valeur n'est pas vide ou annulée)
        if (newName) {
            // On ajoute le nouveau profil à la liste des profils
            profiles.push(newName);
            // On recharge (rafraîchit) l'affichage des profils pour y inclure le nouveau profil
            loadProfiles();
        }
    };

    // On lance la fonction pour afficher les profils dès le chargement de la page
    loadProfiles();
};