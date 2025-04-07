<?php
// Affiche toutes les erreurs (utile en développement pour déboguer)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Démarrage de la session pour pouvoir enregistrer des informations utilisateur
session_start();

try {
    // Connexion à la base de données "netflix"
    // Remplacez "root" et "" par vos identifiants MySQL si nécessaire
    $pdo = new PDO("mysql:host=localhost;dbname=netflix;charset=utf8", "root", "");
    // Configure PDO pour lancer des exceptions en cas d'erreur
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Vérifie que le formulaire a bien été soumis avec la méthode POST
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Récupération et sécurisation des données du formulaire
        $pseudo = htmlspecialchars($_POST['pseudo']);  // Nettoie le pseudo pour éviter les injections XSS
        $motdepasseClair = $_POST['motdepasse'];          // Mot de passe en clair (sera haché)
        $nom = htmlspecialchars($_POST['nom']);
        $prenom = htmlspecialchars($_POST['prenom']);
        $date_naissance = $_POST['date_naissance'];
        // Vérifie et filtre l'email. Si l'email n'est pas valide, la variable sera false.
        $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
        $telephone = htmlspecialchars($_POST['telephone']);
        $sexe = htmlspecialchars($_POST['sexe']);

        // Si l'adresse email n'est pas valide, redirige vers le formulaire d'inscription avec un message d'erreur
        if (!$email) {
            header("Location: scripts_inscription.html?error=emailFalse" . urlencode("Adresse email invalide."));
            exit;
        }

        // Hachage du mot de passe en clair pour plus de sécurité
        $motdepasse = password_hash($motdepasseClair, PASSWORD_DEFAULT);

        // Préparation de la requête SQL pour insérer l'utilisateur dans la table "utilisateurs"
        $stmt = $pdo->prepare("INSERT INTO utilisateurs (pseudo, motdepasse, nom, prenom, date_naissance, email, telephone, sexe) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        // Exécution de la requête avec les valeurs récupérées
        $stmt->execute([$pseudo, $motdepasse, $nom, $prenom, $date_naissance, $email, $telephone, $sexe]);

        // Enregistrement du pseudo de l'utilisateur dans la session
        $_SESSION['utilisateur'] = $pseudo;

        // En cas de succès, redirige vers la page de profil
        header("Location: script_profile.html");
        exit;
    }
} catch (PDOException $e) {
    // En cas d'erreur lors de l'insertion dans la base de données,
    // redirige vers le formulaire d'inscription avec le message d'erreur dans l'URL
    header("Location: scripts_inscription.html?error=errorRegistration" . urlencode("Erreur PDO : " . $e->getMessage()));
    exit;
}
?>
