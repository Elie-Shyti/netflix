<?php
session_start();
// Vous pouvez ajouter ici une vérification d'authentification pour restreindre l'accès à l'administrateur.
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Administration - Ajouter une image</title>
  <link rel="stylesheet" href="styles_admin.css">
</head>
<body>
  <h1>Ajouter une image</h1>
  
  <?php
    if(isset($_GET['message'])){
      echo '<p style="color:green;">'.htmlspecialchars($_GET['message']).'</p>';
    }
    if(isset($_GET['error'])){
      echo '<p style="color:red;">'.htmlspecialchars($_GET['error']).'</p>';
    }
  ?>

  <form action="traitement_image.php" method="post">
    <label for="nom_fichier">Nom du fichier :</label><br>
    <input type="text" name="nom_fichier" id="nom_fichier" required><br><br>
    
    <label for="chemin">Chemin (ex. : images/monimage.jpg) :</label><br>
    <input type="text" name="chemin" id="chemin" required><br><br>
    
    <label for="texte_alternatif">Texte alternatif :</label><br>
    <input type="text" name="texte_alternatif" id="texte_alternatif"><br><br>
    
    <label for="categorie">Catégorie :</label><br>
    <select name="categorie" id="categorie" required>
      <option value="Populaires">Populaires</option>
      <option value="Top Séries">Top Séries</option>
      <option value="Les plus regardés">Les plus regardés</option>
      <!-- Ajoutez d'autres catégories si nécessaire -->
    </select><br><br>
    
    <button type="submit">Ajouter l'image</button>
  </form>
</body>
</html>
