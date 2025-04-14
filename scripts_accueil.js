document.addEventListener('DOMContentLoaded', function() {

    // 1. Liste de toutes les images (nom + chemin) 
    const allImages = [
        { title: "Avatar", path: "images/avatar.jpg" },
        { title: "Avengers", path: "images/avengers.jpg" },
        { title: "Cyberpunk", path: "images/cyberpunk.jpg" },
        { title: "Doctor Who", path: "images/doctor who.jpg" },
        { title: "Friends", path: "images/friends.jpg" },
        { title: "Inception", path: "images/inception.jpg" },
        { title: "Interstellar", path: "images/interstellar.jpg" },
        { title: "Jurassic Park", path: "images/jurassic park.jpg" },
        { title: "Matrix", path: "images/matrix.jpg" },
        { title: "Pulp Fiction", path: "images/pulp fiction.jpg" },
        { title: "Stranger Things", path: "images/stranger things.jpg" },
        { title: "The Dark Knight", path: "images/the dark knight.jpg" },
        { title: "The Godfather", path: "images/the godfather.jpg" }
    ];

    // 2. Sélectionne le conteneur dédié à « Toutes les images »
    const allImagesContainer = document.getElementById('all-images-container');

    // 3. Génère une "carte" pour chaque image
    allImages.forEach(function(img) {
        // Création d'une div pour la carte
        const card = document.createElement('div');
        card.classList.add('movie-card');

        // Remplissage de la carte (image + titre)
        card.innerHTML = `
            <img src="${img.path}" alt="${img.title}">
            <h3>${img.title}</h3>
        `;

        // Ajout de la carte au conteneur
        allImagesContainer.appendChild(card);
    });

    // 4. Boutons de navigation pour le carrousel
    //    (Même logique que pour vos autres catégories)
    const prevBtn = allImagesContainer.parentElement.querySelector('.prev-btn');
    const nextBtn = allImagesContainer.parentElement.querySelector('.next-btn');

    prevBtn.addEventListener('click', function() {
        allImagesContainer.scrollLeft -= 200;
    });

    nextBtn.addEventListener('click', function() {
        allImagesContainer.scrollLeft += 200;
    });

    // 5. Conservez vos autres fonctionnalités JavaScript (barre de recherche, etc.)

});

document.addEventListener('DOMContentLoaded', function() {
    // 1. Définition des catégories attendues (doivent correspondre aux <categorie> dans le XML)
    const expectedCategories = ["Populaires", "Top Séries", "Les plus regardés"];
    // Création d'un objet pour stocker les films par catégorie
    const categories = {};
    expectedCategories.forEach(function(cat) {
        categories[cat] = [];
    });
    
    // On crée également un tableau pour stocker TOUS les films pour la recherche.
    const allFilms = [];

    // 2. Fonction pour créer une carte pour un film
    function createFilmCard(film) {
        var card = document.createElement("div");
        card.classList.add("movie-card");
        // On ajoute un attribut de données afin de pouvoir retrouver la carte plus facilement lors d'une sélection de suggestion.
        card.setAttribute("data-film-chemin", film.chemin);
        card.innerHTML = `
            <img src="${film.chemin}" alt="${film.texte_alternatif}">
            <h3>${film.nom_fichier}</h3>
        `;
        return card;
    }

    // 3. Chargement du fichier XML via fetch()
    fetch('films.xml')
      .then(function(response) {
          return response.text();
      })
      .then(function(str) {
          return (new window.DOMParser()).parseFromString(str, "text/xml");
      })
      .then(function(data) {
          // Récupération de tous les éléments <film>
          var filmNodes = data.querySelectorAll("film");
          filmNodes.forEach(function(node) {
              // Extraction des informations de chaque film
              var nom_fichier = node.querySelector("nom_fichier").textContent;
              var chemin = node.querySelector("chemin").textContent;
              var texte_alternatif = node.querySelector("texte_alternatif").textContent;
              var categorie = node.querySelector("categorie").textContent;

              // Création de l'objet film
              var filmObj = {
                  nom_fichier: nom_fichier,
                  chemin: chemin,
                  texte_alternatif: texte_alternatif,
                  categorie: categorie
              };

              // Ajoute le film à la bonne catégorie si celle-ci est attendue
              if (expectedCategories.includes(categorie)) {
                  categories[categorie].push(filmObj);
              }
              // Ajoute le film à l'array global pour la recherche
              allFilms.push(filmObj);
          });

          // 4. Affichage des films par catégorie
          document.querySelectorAll('.category').forEach(function(categoryEl) {
              var heading = categoryEl.querySelector('h2');
              var categoryName = heading ? heading.textContent.trim() : '';
              var container = categoryEl.querySelector('.carousel-container');
              if (categories[categoryName] && container) {
                  categories[categoryName].forEach(function(film) {
                      var card = createFilmCard(film);
                      container.appendChild(card);
                  });
              }
          });
      })
      .catch(function(err) {
          console.error("Erreur lors du chargement du fichier XML:", err);
      });

// 5. Gestion de la barre de recherche avec suggestions
// Récupère le champ de recherche et le conteneur de suggestions dans le HTML
const searchInput = document.getElementById("search-input");
const suggestionsContainer = document.getElementById("search-suggestions");

// Lorsque l'utilisateur tape dans le champ de recherche
searchInput.addEventListener("keyup", function() {
    const query = searchInput.value.toLowerCase(); // Convertir la recherche en minuscules pour une comparaison insensible à la casse
    suggestionsContainer.innerHTML = ""; // Vider le conteneur de suggestions

    // Si la recherche n'est pas vide, créer la liste de suggestions
    if (query.trim() !== "") {
        // Filtrer les films dont le nom contient le texte recherché
        const suggestions = allFilms.filter(function(film) {
            return film.nom_fichier.toLowerCase().includes(query);
        });

        // Pour chaque film suggéré, créer un élément qui inclut à la fois l'image et le titre
        suggestions.forEach(function(film) {
            var suggestionItem = document.createElement("div");
            suggestionItem.classList.add("suggestion-item");

            // On crée le contenu HTML avec une image et le nom du film
            // Vous pouvez ajuster la taille de l'image via le style inline ou via votre fichier CSS
            suggestionItem.innerHTML = `
                <img src="${film.chemin}" alt="${film.texte_alternatif}" style="width:40px;height:auto;margin-right:5px;">
                <span>${film.nom_fichier}</span>
            `;

            // Quand on clique sur une suggestion, on fait défiler la page jusqu'à la carte correspondante
            suggestionItem.addEventListener("click", function() {
                // Recherche la carte par rapport à l'attribut data-film-chemin
                var targetCard = document.querySelector(`.movie-card[data-film-chemin="${film.chemin}"]`);
                if (targetCard) {
                    // Défilement fluide jusqu'à la carte
                    targetCard.scrollIntoView({ behavior: "smooth", block: "center" });
                }
            });

            // Ajouter la suggestion dans le conteneur
            suggestionsContainer.appendChild(suggestionItem);
        });
    }
});

    // 6. Gestion des boutons du carrousel
    document.querySelectorAll('.category').forEach(function(categoryEl) {
        var container = categoryEl.querySelector('.carousel-container');
        var prevBtn = categoryEl.querySelector('.prev-btn');
        var nextBtn = categoryEl.querySelector('.next-btn');

        prevBtn.addEventListener('click', function() {
            container.scrollLeft -= 200;
        });

        nextBtn.addEventListener('click', function() {
            container.scrollLeft += 200;
        });
    });

    // 7. Bouton "Watch Now" et autres fonctionnalités
    document.getElementById('watch-now-btn').addEventListener('click', function() {
        alert('Préparez-vous à vivre une expérience inoubliable sur Flouflix !');
    });

    function showDevelopmentAlert() {
        alert("Cette fonctionnalité est en cours de développement !");
    }

    document.getElementById("series-link").addEventListener("click", function(event) {
        event.preventDefault();
        showDevelopmentAlert();
    });

    document.getElementById("movies-link").addEventListener("click", function(event) {
        event.preventDefault();
        showDevelopmentAlert();
    });

    document.getElementById("new-link").addEventListener("click", function(event) {
        event.preventDefault();
        showDevelopmentAlert();
    });
});