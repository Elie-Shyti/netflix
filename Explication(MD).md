# Compte rendu de la page d'Inscription et de Connexion en Markdown #


## Page de Connexion/Inscription : ##
&nbsp;
- La division (avec comme classe "form-container") qui est présente dans la balise <body> dans laquelle tout les éléments seront dans celle-ci:

- Dans cette classe de type "form-container",il y a le titre "Connexion / Inscription".***

- Une autre division qui contient une classe de type "containment", on y trouve les deux boutons de type "submit" et qui sont uniquement clickable (onclick),l'un est le bouton Connexion qui redirigera vers la page Connexion.html lors du click gauche de la souris sur le bouton qui entoure le texte "Connexion" sur la page du site internet.***

- L'autre est le bouton Inscription qui redirigera vers la page inscription.html lors du click gauche de la souris sur le bouton qui entoure le texte "Inscription" sur la page du site internet.***

- Un selecteur de langue avec comme identifiant "langue" et comme nom "langue", deux choix de langue qui sont identifiés comme des options et qui ont pour valeur "(le nome de la langue),soit Anglais ou soit Français.***

&nbsp;
## Page d'Inscription : ##

&nbsp;
- Dans cette classe de type "form-container",il y a le titre "S'inscrire".

- Dans la classe se trouve une balise <form> qui contient une autre division qui a pour type de classe "containment".

- Dans cette division on retrouve plusieurs input pour chaque éléments d'inscription (de type "placeholder"), et qui sont obligatoire (requis) puis on y retrouve un selecteur de Genre (Masculin,Féminin ou autre).

- Et deux boutons, Valider de type "submit" pour être redirigé vers la page de connexion (le compte étant crée) et Effacer de type "reset" pour supprimer les valeurs insérés (tout recommencer)

- Puis le bouton retour qui est de type "back" qui doit renvoyer la personne sur la page de connexion et d'inscription.

&nbsp;
## Page de Connexion ##

&nbsp;
- Dans cette classe de type "form-container",il y a le titre "Se connecter".

- Dans la classe se trouve une balise <form> qui contient une autre division qui a pour type de classe "containment".***

- Dans cette division se trouve deux input avec des placeholder, l'un avec pour type "text" qui fera office de pseudonyme et l'autre qui sera du type "password" qui fera lui office du mot de passe.
Ces deux précisions sont données dans les id et les name présent dans les input.

- Deux boutons, Valider de type "submit" pour être redirigé vers la page de selection des profils (script_profile) et Effacer de type "reset" pour supprimer les valeurs insérés (tout recommencer).

&nbsp;
## Design en CSS ##


- Le selecteur "*" et les propriétés margin et padding à 0% supprime les marges et les espacements par défaut de tous les éléments HTML,c'est pour pour éviter tout espacement indésirable autour des éléments

- La propriété "display:flex;" permet de pouvoir deplacer la disposition présente sur la page et modifier la hauteur de la page.

- la propriété "justify-content:center;" permet de mettre les éléments de manière horizontale

- la propriété "height:100%" permet que tout l'élément html occupe toute la hauteur de la page

&nbsp;
## Dans le body : ##
&nbsp;
- font-family : Définie la famille de polices à utiliser (Verdana, Geneva, Tahoma).

- color: #a7a7a7 : Définit la couleur du texte en gris clair.

- display: flex : Active Flexbox pour organiser le contenu du body.

- flex-direction: column : Organise les enfants (éléments) du body en colonne.
justify-content: center et align-items: center : Centre le contenu horizontalement que verticalement.

- height: 100% : Prend toute la hauteur de la fenêtre du navigateur.

- background-image : Définit l'image d'arrière-plan (Sanstitre.png).

- background-repeat: no-repeat : Empêche la répétition de l'image d'arrière-plan.

- background-size: cover : Redimensionne l'image d'arrière-plan pour couvrir tout l'espace.

- background-color: #000000 : Définit une couleur de fond noire.

- border: 10% : Applique une bordure de 10% de la taille de l'élément (probablement une erreur, voir section sur les bordures).

&nbsp;
## Dans le contenu de form-container: ##

&nbsp;
- background: rgb(17, 17, 17) : Couleur de fond sombre.

- padding: 20% : Espacement interne du conteneur.

- border-radius: 8px : Coins arrondis pour un effet visuel plus doux.

- box-shadow: 0 4px 8px rgba(0, 0, 0, 0.637) : Ajoute une ombre autour du conteneur pour le faire ressortir.

- width: 120% : Définit la largeur du conteneur à 120% de l'élément parent (peut nécessiter un ajustement selon la situation).

- background-color: #000000c2 : Ajoute une couleur d'arrière-plan semi-transparente noire.

- background-size: cover et background-repeat: no-repeat : Assurent que l'image d'arrière-plan ne se répète pas et couvre l'élément.

&nbsp;
## Dans le conteneur "containement": ##

&nbsp;
- La propriété "display:flex;" permet de pouvoir deplacer la disposition présente sur la page et modifier la hauteur de la page.

- justify-content: center : Centre les éléments enfants horizontalement.

- flex-direction: column : Organise les enfants en colonne.

&nbsp;
## Le champ de saisi (input et select): ##

&nbsp;
- width: 100% : Assure que les champs remplissent toute la largeur disponible.

- padding: 12px 20px : Applique un espacement interne autour du texte.

- margin: 10px 0 : Espacement entre chaque champ.

- border: 1px solid #ccc : Bordure légère de couleur grise.

- border-radius: 4px : Coins arrondis pour un aspect plus doux.

- background-color: #000000c9 : Fond sombre semi-transparent.

- box-sizing: border-box : Assure que le padding et border sont inclus dans les dimensions totales de l'élément.

- color: #ffffff : Couleur du texte en blanc.

- align-items: center : Aligne les éléments enfants (comme le texte ou l'icône) au centre.

&nbsp;
## Les boutons : ##

&nbsp;
- width: 100% : Le bouton prend toute la largeur disponible.

- padding: 14px 14px : Applique un espacement interne.

- margin: 8px 0 : Ajoute un espacement entre les boutons.

- border: none : Supprime la bordure par défaut des boutons.

- background-color: #ff0000 : Fond rouge vif pour le bouton principal

- color: rgb(255, 255, 255) : Texte blanc.

- cursor: pointer : Change le curseur lorsque l'utilisateur survole le bouton.

- border-radius: 5px : Coins arrondis.

- transition: opacity 0.3s : Ajoute un effet de transition lors du survol.

- display: flex, justify-content: center, align-items: center : Centrer le texte à l'intérieur du bouton.

