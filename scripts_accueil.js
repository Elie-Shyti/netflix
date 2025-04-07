document.addEventListener('DOMContentLoaded', function() {
    // Les catégories attendues, telles qu'affichées dans vos sections HTML
    const expectedCategories = ["Populaires", "Top Séries", "Les plus regardés"];
    // Création d'un objet pour regrouper les images par catégorie
    const categories = {};
    expectedCategories.forEach(cat => {
        categories[cat] = [];
    });

    // Récupération des images depuis fetch_images.php
    fetch('fetch_images.php')
      .then(response => response.json())
      .then(data => {
          if(data.error) {
              console.error(data.error);
              return;
          }
          // Regrouper les images par catégorie
          data.forEach(image => {
              if(expectedCategories.includes(image.categorie)) {
                  categories[image.categorie].push(image);
              }
          });

          // Pour chaque section de catégorie dans le HTML, remplir le conteneur avec les images correspondantes
          document.querySelectorAll('.category').forEach(categoryEl => {
              const heading = categoryEl.querySelector('h2');
              const categoryName = heading ? heading.textContent.trim() : '';
              const container = categoryEl.querySelector('.carousel-container');
              if(categories[categoryName] && container) {
                  categories[categoryName].forEach(image => {
                      const card = document.createElement('div');
                      card.classList.add('movie-card');
                      card.innerHTML = `
                          <img src="${image.chemin}" alt="${image.texte_alternatif}">
                          <h3>${image.nom_fichier}</h3>
                      `;
                      container.appendChild(card);
                  });
              }
          });
      })
      .catch(err => {
          console.error("Erreur lors du chargement des images :", err);
      });

    // Gestion des boutons du carrousel
    document.querySelectorAll('.category').forEach(categoryEl => {
        const container = categoryEl.querySelector('.carousel-container');
        const prevBtn = categoryEl.querySelector('.prev-btn');
        const nextBtn = categoryEl.querySelector('.next-btn');

        prevBtn.addEventListener('click', () => {
            container.scrollLeft -= 200;
        });

        nextBtn.addEventListener('click', () => {
            container.scrollLeft += 200;
        });
    });

    // Bouton "Watch Now" et autres fonctionnalités
    document.getElementById('watch-now-btn').addEventListener('click', () => {
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
