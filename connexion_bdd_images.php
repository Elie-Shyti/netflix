<?php
// On indique que le résultat sera du JSON
header('Content-Type: application/json');

// On affiche toutes les erreurs pour aider en cas de problème
error_reporting(E_ALL);
ini_set('display_errors', 1);

try {
    // On se connecte à la base de données "netflix"
    // Les paramètres sont : l'hôte, le nom de la base, le charset, le nom d'utilisateur et le mot de passe
    $pdo = new PDO("mysql:host=localhost;dbname=netflix;charset=utf8", "root", "");
    
    // Si une erreur se produit avec la base, PDO lancera une exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // On exécute une requête pour obtenir les images de la table "images"
    // Les images sont triées par date d'ajout, des plus récentes aux plus anciennes
    $stmt = $pdo->query("SELECT nom_fichier, chemin, texte_alternatif, categorie FROM images ORDER BY date_ajout DESC");
    
    // On récupère tous les résultats sous forme de tableau associatif
    $images = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // On encode le tableau en JSON et on l'affiche (cela sera retourné au navigateur)
    echo json_encode($images);
} catch (PDOException $e) {
    // Si une erreur survient, on renvoie un objet JSON avec l'erreur
    echo json_encode(['error' => $e->getMessage()]);
}
?>
