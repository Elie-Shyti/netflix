# README

## Description du Projet

Ce projet se compose de deux parties principales :

1. **Flouflix**  
   Une application web qui simule un portail de films et séries. Elle comporte :
   - Une page d'accueil affichant des films avec un carrousel et une barre de recherche semi-fonctionnelle.
   - Un système d’inscription et de connexion pour les utilisateurs, avec redirection conditionnelle (administrateur ou utilisateur classique).
   - Une gestion des images de films stockées dans une base de données MySQL (BDD nommée **netflix**).
   - Une interface d’administration permettant d’ajouter de nouvelles images/films.
   - Un fichier **films.xml** pour référencer et manipuler les films (en complément de la base de données).

2. *(Optionnel : Vous pouvez étendre ou intégrer d’autres composants, comme un jeu de Monopoly par exemple.)*

---

## Prérequis

- **Serveur Web avec PHP** (XAMPP, WAMP, Laragon, etc.).
- **MySQL** (ou MariaDB)  
  Créez la base de données **netflix** et exécutez les scripts SQL suivants :

### Table `images`
```sql
CREATE TABLE IF NOT EXISTS images (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nom_fichier VARCHAR(255) NOT NULL,
  chemin VARCHAR(255) NOT NULL,
  texte_alternatif VARCHAR(255),
  categorie VARCHAR(50) NOT NULL,
  date_ajout TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ;
```


### Table `utilisateurs`
```sql
CREATE TABLE IF NOT EXISTS utilisateurs (
  id INT AUTO_INCREMENT PRIMARY KEY,
  pseudo VARCHAR(50) UNIQUE NOT NULL,
  motdepasse VARCHAR(255) NOT NULL,
  nom VARCHAR(100),
  prenom VARCHAR(100),
  date_naissance DATE,
  email VARCHAR(100) UNIQUE,
  telephone VARCHAR(20),
  sexe VARCHAR(20),
  admin TINYINT(1) DEFAULT 0
); 
```

## Structure du Projet

/Flouflix/
- ├── admin_images.php                
  Page d'administration avec formulaire d'ajout d'image/film
- ├── checkLogin.js                   
  Script JS pour la vérification de la connexion (ex. mot de passe)
- ├── checkPassword.js                
  Script JS pour la vérification du mot de passe sur le formulaire  
- ├── connexion_bdd_images.php        
  (Ex. script de connexion dédié à l'accès BDD pour images)
- ├── Explication.md                  
  Explication pour l'utilisation du netflix
- ├── films.xml                       
  Fichier XML listant vos films (complément ou alternative à la BDD)
- ├── README.md                       
  Ce fichier de documentation
- ├── script_accueil.html             
  Page d'accueil : carrousel, barre de recherche, etc.
- ├── script_profile.html             
  Page de profil (choix de profil, etc.)
- ├── scripts_accueil.js              
  Logique d'affichage : carrousel, recherche, chargement des films
- ├── scripts_connexion.html          
  Page de connexion
- ├── scripts_connexion_inscription.html 
  Page proposant de choisir entre connexion et inscription
- ├── scripts_inscription.html        
  Page d'inscription
- ├── scripts_profile.js              
  Logique pour la gestion des profils
- ├── styles_accueil.css              
  Styles pour la page d'accueil
- ├── styles_connexion_inscription.css
  Styles pour les pages connexion/inscription
- ├── styles_profile.css              
  Styles pour la page de profil
- ├── traitement_image.php                
  Script PHP pour traiter l'ajout d'une image (dans le XML)
- ├── traitement_ajout_image.php      
  Script PHP pour traiter l'ajout d'une image (dans la BDD &)
- ├── traitement_connexion.php        
  Script PHP pour valider la connexion (pseudo/mdp) et rediriger
- ├── traitement_inscription.php      
  Script PHP pour gérer l'inscription d'un nouvel utilisateur

## remarque 

- e projet est fourni à titre d'exemple. Vous devrez peut-être ajuster les identifiants et la configuration PHP/MySQL selon votre environnement.
- Chaque composant comporte, dans la mesure du possible, des commentaires pour faciliter la compréhension.
- Pour plus de détails, n'hésitez pas à consulter les commentaires dans les fichiers sources. Vous pouvez également adapter la logique de synchronisation entre la BDD et le   fichier XML pour répondre à vos besoins. 