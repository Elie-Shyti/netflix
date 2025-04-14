<?php
// --------------------------------------------------------------
// 1. Afficher les erreurs en développement
// --------------------------------------------------------------
// Ces deux lignes configurent PHP pour afficher toutes les erreurs, ce qui
// est très utile pendant le développement pour déboguer le code.
error_reporting(E_ALL);
ini_set('display_errors', 1);

// --------------------------------------------------------------
// 2. Démarrage de la session
// --------------------------------------------------------------
// La fonction session_start() initialise une session pour l'utilisateur.
// Cela permet de stocker et de récupérer des informations (comme le pseudo)
// à travers plusieurs pages.
session_start();

try {
    // --------------------------------------------------------------
    // 3. Connexion à la base de données "netflix"
    // --------------------------------------------------------------
    // On crée un nouvel objet PDO pour se connecter à MySQL.
    // Le premier paramètre spécifie :
    //   - l'hôte de la base de données (localhost)
    //   - le nom de la base de données (netflix)
    //   - le charset (utf8 pour supporter les caractères spéciaux)
    // Le deuxième et troisième paramètre sont respectivement le nom d'utilisateur
    // et le mot de passe à utiliser pour la connexion.
    // N'oubliez pas de remplacer "root" et "" par vos propres identifiants si nécessaire.
    $pdo = new PDO("mysql:host=localhost;dbname=netflix;charset=utf8", "root", "");
    
    // On configure PDO pour qu'il lance une exception (PDOException) en cas d'erreur.
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // --------------------------------------------------------------
    // 4. Vérification de la méthode de soumission du formulaire
    // --------------------------------------------------------------
    // On vérifie que le formulaire a été soumis par la méthode POST.
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // --------------------------------------------------------------
        // 5. Récupération et sécurisation des données du formulaire
        // --------------------------------------------------------------
        // On récupère le pseudo et on le sécurise avec htmlspecialchars pour
        // éviter les attaques de type injection de code HTML (XSS).
        $pseudo = htmlspecialchars($_POST['pseudo']);
        
        // On récupère le mot de passe en clair (il sera ensuite haché).
        $motdepasseClair = $_POST['motdepasse'];
        
        // Récupère et sécurise le nom et le prénom.
        $nom = htmlspecialchars($_POST['nom']);
        $prenom = htmlspecialchars($_POST['prenom']);
        
        // On récupère la date de naissance directement.
        $date_naissance = $_POST['date_naissance'];
        
        // On filtre et valide l'email. La fonction filter_var() renvoie false
        // si l'email n'est pas valide.
        $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
        
        // On récupère et sécurise le téléphone et le sexe.
        $telephone = htmlspecialchars($_POST['telephone']);
        $sexe = htmlspecialchars($_POST['sexe']);

        // --------------------------------------------------------------
        // 6. Validation de l'email
        // --------------------------------------------------------------
        // Si l'adresse email n'est pas valide (c'est-à-dire $email vaut false),
        // on redirige l'utilisateur vers le formulaire d'inscription avec un message d'erreur.
        if (!$email) {
            header("Location: scripts_inscription.html?error=emailFalse" . urlencode("Adresse email invalide."));
            exit;  // Terminer le script pour ne pas poursuivre.
        }

        // --------------------------------------------------------------
        // 7. Hachage du mot de passe
        // --------------------------------------------------------------
        // Le mot de passe en clair est converti en une version sécurisée grâce à password_hash().
        // Ceci permet de stocker le mot de passe de manière sécurisée dans la base de données.
        $motdepasse = password_hash($motdepasseClair, PASSWORD_DEFAULT);

        // --------------------------------------------------------------
        // 8. Insertion de l'utilisateur dans la table "utilisateurs"
        // --------------------------------------------------------------
        // On prépare une requête SQL pour insérer un nouvel utilisateur.
        // Les points d'interrogation sont des "placeholders" qui seront remplacés
        // par les valeurs respectives.
        $stmt = $pdo->prepare("INSERT INTO utilisateurs (pseudo, motdepasse, nom, prenom, date_naissance, email, telephone, sexe) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        
        // On exécute la requête en passant un tableau contenant toutes les valeurs à insérer.
        $stmt->execute([$pseudo, $motdepasse, $nom, $prenom, $date_naissance, $email, $telephone, $sexe]);

        // --------------------------------------------------------------
        // 9. Enregistrement de l'utilisateur dans la session
        // --------------------------------------------------------------
        // On stocke le pseudo de l'utilisateur dans la session pour l'identifier sur les pages suivantes.
        $_SESSION['utilisateur'] = $pseudo;

        // --------------------------------------------------------------
        // 10. Redirection en cas de succès
        // --------------------------------------------------------------
        // Après l'insertion réussie dans la base de données, on redirige l'utilisateur
        // vers la page "script_profile.html" qui est la page de profil.
        header("Location: script_profile.html");
        exit;
    }
} catch (PDOException $e) {
    // --------------------------------------------------------------
    // 11. Gestion des erreurs avec PDO
    // --------------------------------------------------------------
    // En cas d'erreur lors de la connexion ou de l'exécution de la requête SQL,
    // une exception PDO est attrapée ici.
    // L'utilisateur est redirigé vers le formulaire d'inscription (scripts_inscription.html)
    // avec un message d'erreur qui est passé dans l'URL.
    header("Location: scripts_inscription.html?error=errorRegistration" . urlencode("Erreur PDO : " . $e->getMessage()));
    exit;
}
?>
