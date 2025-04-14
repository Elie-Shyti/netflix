# Documentation Technique - Flouflix

## Introduction

**Flouflix** est une application web qui simule un portail de films et séries. Le système offre :
- Une page d'accueil affichant des films via un carrousel.
- Une barre de recherche semi-fonctionnelle qui propose des suggestions.
- Un système d’inscription et de connexion pour les utilisateurs, avec redirection conditionnelle (administrateur ou utilisateur classique).
- Une gestion des images de films stockées dans une base de données MySQL (BDD nommée **netflix**).
- Une interface d’administration permettant d’ajouter de nouvelles images/films.
- Un fichier XML (**films.xml**) pour référencer et manipuler les films en complément de la base de données.

Ce document décrit l’architecture technique

## Architecture Technique

### Technologies Utilisées
- **PHP** : pour la logique serveur (traitement des formulaires d’inscription, de connexion, administration, etc.).
- **MySQL** : pour le stockage des données, notamment les images et les utilisateurs.
- **JavaScript** : pour la logique côté client, incluant le chargement dynamique des images, la gestion du carrousel et la barre de recherche.
- **XML** : fichier **films.xml** pour contenir et synchroniser les informations sur les films.
- **HTML/CSS** : pour la structure et le style des pages web.

### Flux de Données
- **Inscription & Connexion** : Les informations saisies par l’utilisateur sont envoyées aux scripts PHP pour validation et insertion en base (ou vérification), puis l’utilisateur est redirigé en fonction de son statut.
- **Gestion des Images** : Les images sont enregistrées dans la table `images` et également référencées dans le fichier **films.xml**. Les films sont récupérés côté client via `fetch` pour être affichés dans le carrousel.
- **Barre de Recherche** : Le JavaScript interroge le fichier XML ou une source de données côté client, affiche des suggestions sous le champ de recherche, et permet à l’utilisateur de naviguer jusqu’à une carte film spécifique.

## Installation et Configuration

### Prérequis
- Serveur Web avec PHP.
- MySQL ou MariaDB.