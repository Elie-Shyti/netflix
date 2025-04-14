<?php
// Affiche les erreurs en développement pour faciliter le débogage
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupération et sécurisation des données du formulaire
    $nom_fichier = htmlspecialchars($_POST['nom_fichier']);
    $chemin = htmlspecialchars($_POST['chemin']);
    $texte_alternatif = isset($_POST['texte_alternatif']) ? htmlspecialchars($_POST['texte_alternatif']) : "";
    $categorie = htmlspecialchars($_POST['categorie']);

    try {
        // Connexion à la base de données "netflix"
        $pdo = new PDO("mysql:host=localhost;dbname=netflix;charset=utf8", "root", "");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Préparation et exécution de l'insertion dans la table "images"
        $stmt = $pdo->prepare("INSERT INTO images (nom_fichier, chemin, texte_alternatif, categorie) VALUES (?, ?, ?, ?)");
        $stmt->execute([$nom_fichier, $chemin, $texte_alternatif, $categorie]);

        // ---------------------
        // Mise à jour du fichier XML
        // ---------------------
        // Définir le chemin du fichier XML. Assurez-vous que le script a les autorisations nécessaires pour écrire dans ce fichier.
        $xmlFile = 'films.xml';

        // Vérifie si le fichier XML existe déjà
        if (file_exists($xmlFile)) {
            // Si le fichier existe, on le charge en utilisant SimpleXML
            $xml = simplexml_load_file($xmlFile);
        } else {
            // Sinon, on crée un nouveau document XML avec la balise racine <films>
            $xml = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><films></films>');
        }

        // Crée un nouvel élément <film> dans le document XML
        $newFilm = $xml->addChild('film');
        $newFilm->addChild('nom_fichier', $nom_fichier);      // Ajoute le nom du fichier
        $newFilm->addChild('chemin', $chemin);                  // Ajoute le chemin de l'image
        $newFilm->addChild('texte_alternatif', $texte_alternatif); // Ajoute le texte alternatif
        $newFilm->addChild('categorie', $categorie);            // Ajoute la catégorie

        // Sauvegarde le document XML mis à jour dans le même fichier
        $xml->asXML($xmlFile);

        // Redirection avec message de succès vers la page d'administration
        header("Location: admin_images.php?message=" . urlencode("Image ajoutée avec succès."));
        exit;
    } catch (PDOException $e) {
        // En cas d'erreur (ex. problème de connexion ou d'insertion), on redirige vers la page d'administration 
        // avec le message d'erreur dans l'URL
        header("Location: admin_images.php?error=" . urlencode("Erreur PDO : " . $e->getMessage()));
        exit;
    }
} else {
    // Si le script est appelé sans soumission de formulaire, rediriger vers la page d'administration
    header("Location: admin_images.php");
    exit;
}
?>
