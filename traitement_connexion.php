<?php
// Affiche toutes les erreurs (utile en développement pour détecter les problèmes)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Démarrage de la session pour pouvoir stocker des informations sur l'utilisateur (exemple : pseudo)
session_start();

try {
    // Étape 1 : Connexion à la base de données "netflix"
    // On crée un nouvel objet PDO pour se connecter à MySQL.
    // La chaîne de connexion indique l'hôte (localhost), le nom de la base (netflix) et l'encodage (utf8).
    // Les identifiants "root" et "" sont utilisés ici .
    $pdo = new PDO("mysql:host=localhost;dbname=netflix;charset=utf8", "root", "");
    // On définit le mode d'erreur de PDO pour qu'il lance une exception en cas d'erreur.
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Étape 2 : On vérifie que la requête est bien envoyée par la méthode POST
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Récupération et nettoyage (pour éviter des failles XSS) des données du formulaire d'identification
        $pseudo = htmlspecialchars($_POST['pseudo']);      // Nettoyage du pseudo
        $motdepasseClair = $_POST['motdepasse'];              // Le mot de passe en clair est récupéré

        // Étape 3 : Rechercher dans la table "utilisateurs" l'enregistrement correspondant au pseudo fourni
        // La requête préparée permet de sécuriser la requête (protection contre l'injection SQL).
        $stmt = $pdo->prepare("SELECT * FROM utilisateurs WHERE pseudo = ?");
        $stmt->execute([$pseudo]);

        // Si au moins un enregistrement a été trouvé...
        if ($stmt->rowCount() > 0) {
            // Récupération des données de l'utilisateur sous forme de tableau associatif
            $utilisateur = $stmt->fetch(PDO::FETCH_ASSOC);
            // Vérification du mot de passe :
            // La fonction password_verify compare le mot de passe saisi avec le mot de passe haché stocké dans la base
            if (password_verify($motdepasseClair, $utilisateur['motdepasse'])) {
                // Enregistrement du pseudo dans la variable de session (pour garder une trace de l'utilisateur connecté)
                $_SESSION['utilisateur'] = $utilisateur['pseudo'];
                // Vérification si cet utilisateur a le statut d'administrateur.
                // On teste si la colonne "admin" existe et si sa valeur est 1
                if (isset($utilisateur['admin']) && $utilisateur['admin'] == 1) {
                    // L'utilisateur est un administrateur : on le redirige vers la page d'administration (ici "admin_images.php")
                    header("Location: admin_images.php");
                    exit;
                } else {
                    // Sinon, c'est un utilisateur normal : on le redirige vers sa page de profil (ici "script_profile.html")
                    header("Location: script_profile.html");
                    exit;
                }
            } else {
                // Si le mot de passe fourni ne correspond pas, on redirige vers le formulaire de connexion
                // avec un message d'erreur indiquant "Mot de passe incorrect."
                header("Location: scripts_connexion.html?error=" . urlencode("Mot de passe incorrect."));
                exit;
            }
        } else {
            // Si aucun compte n'est trouvé pour le pseudo donné, on redirige vers le formulaire de connexion
            // en passant un message d'erreur indiquant qu'aucun compte n'a été trouvé
            header("Location: scripts_connexion.html?error=" . urlencode("Aucun compte trouvé avec ce pseudo."));
            exit;
        }
    }
} catch (PDOException $e) {
    // En cas d'erreur liée à la base de données (connexion, requête, etc.),
    // on redirige également vers le formulaire de connexion, en ajoutant le message d'erreur dans l'URL.
    header("Location: scripts_connexion.html?error=" . urlencode("Erreur PDO : " . $e->getMessage()));
    exit;
}
?>
