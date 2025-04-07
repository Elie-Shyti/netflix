window.onload = function() {
    var profilesContainer = document.getElementById("profiles");
    var addProfileButton = document.getElementById("addProfile");

    var profiles = ["Défaut"];

    function loadProfiles() {
        profilesContainer.innerHTML = "";

        for (var i = 0; i < profiles.length; i++) {
            var profileDiv = document.createElement("div");
            profileDiv.className = "profile";

            var profileImage = document.createElement("img");
            profileImage.src = "images/default-profile.png";
            profileImage.alt = profiles[i];

            var profileName = document.createElement("div");
            profileName.className = "profile-name";
            profileName.textContent = profiles[i];

            profileDiv.onclick = function(index) {
                return function() {
                    window.location.href = "script_accueil.html";
                };
            }(i);

            profileDiv.appendChild(profileImage);
            profileDiv.appendChild(profileName);

            profilesContainer.appendChild(profileDiv);
        }
    }

    addProfileButton.onclick = function() {
        var newName = prompt("Nom du nouveau profil :");
        if (newName) {
            profiles.push(newName);
            loadProfiles();
        }
    };

    loadProfiles();
};
