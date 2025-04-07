<?php
header('Content-Type: application/json');
error_reporting(E_ALL);
ini_set('display_errors', 1);

try {
    // Connexion à la base de données "netflix"
    $pdo = new PDO("mysql:host=localhost;dbname=netflix;charset=utf8", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Récupérer les informations des images, triées par date d'ajout (les plus récentes en premier)
    $stmt = $pdo->query("SELECT nom_fichier, chemin, texte_alternatif, categorie FROM images ORDER BY date_ajout DESC");
    $images = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($images);
} catch (PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>
