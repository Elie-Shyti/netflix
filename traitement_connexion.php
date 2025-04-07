<?php
// Affiche toutes les erreurs (en développement)
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

try {
    // Connexion à la base de données "netflix"
    $pdo = new PDO("mysql:host=localhost;dbname=netflix;charset=utf8", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $pseudo = htmlspecialchars($_POST['pseudo']);
        $motdepasseClair = $_POST['motdepasse'];

        // Rechercher l'utilisateur dans la base
        $stmt = $pdo->prepare("SELECT * FROM utilisateurs WHERE pseudo = ?");
        $stmt->execute([$pseudo]);

        if ($stmt->rowCount() > 0) {
            $utilisateur = $stmt->fetch(PDO::FETCH_ASSOC);
            // Vérifier le mot de passe
            if (password_verify($motdepasseClair, $utilisateur['motdepasse'])) {
                $_SESSION['utilisateur'] = $utilisateur['pseudo'];
                // Vérifier le statut d'administrateur
                if (isset($utilisateur['admin']) && $utilisateur['admin'] == 1) {
                    // Rediriger vers la page administrateur
                    header("Location: admin_images.php");
                    exit;
                } else {
                    // Rediriger vers la page utilisateur normale
                    header("Location: script_profile.html");
                    exit;
                }
            } else {
                header("Location: scripts_connexion.html?error=" . urlencode("Mot de passe incorrect."));
                exit;
            }
        } else {
            header("Location: scripts_connexion.html?error=" . urlencode("Aucun compte trouvé avec ce pseudo."));
            exit;
        }
    }
} catch (PDOException $e) {
    header("Location: scripts_connexion.html?error=" . urlencode("Erreur PDO : " . $e->getMessage()));
    exit;
}
?>
