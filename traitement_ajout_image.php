<?php
// Affiche<?php
// Affiche toutes les erreurs pour le débogage en développement
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Démarre la session (utile pour conserver des informations utilisateur)
session_start();

// On vérifie que le formulaire a été soumis via la méthode POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Récupération et sécurisation des données du formulaire
    $nom_fichier = htmlspecialchars($_POST['nom_fichier']); // Nom du fichier
    $chemin = htmlspecialchars($_POST['chemin']);           // Chemin vers l'image
    // Si un texte alternatif est fourni, le sécuriser sinon le définir comme chaîne vide
    $texte_alternatif = isset($_POST['texte_alternatif']) ? htmlspecialchars($_POST['texte_alternatif']) : "";
    $categorie = htmlspecialchars($_POST['categorie']);     // Catégorie du film

    try {
        // Connexion à la base de données "netflix"
        // Remplacez "root" et "" par vos identifiants MySQL si besoin
        $pdo = new PDO("mysql:host=localhost;dbname=netflix;charset=utf8", "root", "");
        // Configure PDO pour lancer une exception en cas d'erreur
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Préparation de la requête SQL pour insérer les données dans la table "images"
        $stmt = $pdo->prepare("INSERT INTO images (nom_fichier, chemin, texte_alternatif, categorie) VALUES (?, ?, ?, ?)");
        // Exécution de la requête avec les valeurs récupérées
        $stmt->execute([$nom_fichier, $chemin, $texte_alternatif, $categorie]);

        // -------------------------------------------------------
        // Mise à jour du fichier XML (films.xml)
        // -------------------------------------------------------

        // Chemin du fichier XML
        $xmlFile = 'films.xml';

        // Vérifie si le fichier XML existe déjà
        if (file_exists($xmlFile)) {
            // Charge le fichier XML existant avec SimpleXML
            $xml = simplexml_load_file($xmlFile);
        } else {
            // Sinon, crée un nouveau fichier XML avec la racine <films>
            $xml = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><films></films>');
        }

        // Ajoute un nouvel élément <film> dans le document XML
        $newFilm = $xml->addChild('film');
        $newFilm->addChild('nom_fichier', $nom_fichier);
        $newFilm->addChild('chemin', $chemin);
        $newFilm->addChild('texte_alternatif', $texte_alternatif);
        $newFilm->addChild('categorie', $categorie);

        // Sauvegarde le document XML dans le fichier films.xml
        $xml->asXML($xmlFile);

        // Redirection vers la page d'administration avec un message de succès dans l'URL
        header("Location: admin_images.php?message=" . urlencode("Film ajouté avec succès."));
        exit;
    } catch (PDOException $e) {
        // En cas d'erreur (ex. problème de connexion ou d'insertion), redirige vers la page d'administration
        // avec un message d'erreur dans l'URL
        header("Location: admin_images.php?error=" . urlencode("Erreur PDO : " . $e->getMessage()));
        exit;
    }
} else {
    // Si le script est appelé sans soumission du formulaire, redirige vers la page d'administration
    header("Location: admin_images.php");
    exit;
}
?>