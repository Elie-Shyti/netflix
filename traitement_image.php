<?php
// Affiche les erreurs en développement
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

        // Redirection avec message de succès
        header("Location: admin_images.php?message=" . urlencode("Image ajoutée avec succès."));
        exit;
    } catch (PDOException $e) {
        // En cas d'erreur, redirection avec message d'erreur
        header("Location: admin_images.php?error=" . urlencode("Erreur PDO : " . $e->getMessage()));
        exit;
    }
} else {
    header("Location: admin_images.php");
    exit;
}
?>
