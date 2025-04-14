<?php
// Affiche les erreurs en développement.
// Ces deux lignes permettent de voir toutes les erreurs sur la page, ce qui est utile pendant le développement.
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Démarre une session PHP pour pouvoir conserver des informations utilisateur entre les pages.
session_start();

// On vérifie que le formulaire a bien été soumis en utilisant la méthode POST.
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // ------------------------------
    // Récupération et sécurisation des données du formulaire
    // ------------------------------
    
    // Récupère le champ "nom_fichier" du formulaire et utilise htmlspecialchars() pour empêcher les injections de code HTML (sécurité).
    $nom_fichier = htmlspecialchars($_POST['nom_fichier']);
    
    // Pareil pour le champ "chemin" qui correspond au chemin de l'image.
    $chemin = htmlspecialchars($_POST['chemin']);
    
    // Pour "texte_alternatif", vérifie si la donnée existe ; si oui, la sécurise, sinon la définit comme une chaîne vide.
    $texte_alternatif = isset($_POST['texte_alternatif']) ? htmlspecialchars($_POST['texte_alternatif']) : "";
    
    // Récupère et sécurise le champ "categorie" du formulaire.
    $categorie = htmlspecialchars($_POST['categorie']);

    // ------------------------------
    // Tentative de connexion à la base de données et insertion des données
    // ------------------------------
    
    try {
        // Connexion à la base de données "netflix" en utilisant PDO.
        // La chaîne de connexion (DSN) spécifie l'hôte, le nom de la base et l'encodage (utf8).
        // Ici, on utilise "root" comme nom d'utilisateur, et "" (vide) comme mot de passe (à adapter selon votre configuration).
        $pdo = new PDO("mysql:host=localhost;dbname=netflix;charset=utf8", "root", "");
        
        // Configure PDO pour qu'il lance des exceptions en cas d'erreur (facilite le débogage).
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Prépare une requête SQL pour insérer les données dans la table "images".
        // Les points d'interrogation sont des placeholders pour les valeurs qui seront ajoutées.
        $stmt = $pdo->prepare("INSERT INTO images (nom_fichier, chemin, texte_alternatif, categorie) VALUES (?, ?, ?, ?)");
        
        // Exécute la requête en passant les valeurs récupérées du formulaire sous forme de tableau.
        $stmt->execute([$nom_fichier, $chemin, $texte_alternatif, $categorie]);

        // Après l'insertion réussie, on redirige l'utilisateur vers la page d'administration (admin_images.php)
        // en passant un message de succès dans l'URL.
        header("Location: admin_images.php?message=succes" . urlencode("Image ajoutée avec succès."));
        exit; // Termine le script après la redirection.

    } catch (PDOException $e) {
        // Si une exception (erreur) se produit lors de l'insertion (par exemple, problème de connexion, doublon, etc.),
        // on redirige l'utilisateur vers la page d'administration avec un message d'erreur dans l'URL.
        header("Location: admin_images.php?error=insertionError" . urlencode("Erreur PDO : " . $e->getMessage()));
        exit;
    }
} else {
    // Si le script est appelé sans soumission du formulaire (par exemple, accès direct),
    // on redirige tout simplement vers la page d'administration.
    header("Location: admin_images.php");
    exit;
}
?>
