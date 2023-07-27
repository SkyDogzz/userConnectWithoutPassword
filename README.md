# Projet: Gestion de mot de passe utilisateur avec MySQL

Ce projet est un script Python conçu pour gérer les mots de passe des utilisateurs stockés dans une base de données MySQL. Le script permet de modifier le mot de passe d'un utilisateur spécifié après confirmation et propose également une fonction de sauvegarde de l'ancien mot de passe avant la mise à jour. Le script utilise le hachage SHA-1 pour stocker les mots de passe dans la base de données.

## Fonctionnalités principales :

1. Connexion à la base de données MySQL en utilisant les informations fournies dans le fichier de configuration config.json.
2. Demande à l'utilisateur le nom d'utilisateur dont le mot de passe doit être modifié.
3. Vérifie si l'utilisateur spécifié existe dans la base de données. Si l'utilisateur n'existe pas, un message approprié est affiché.
4. Si l'utilisateur existe, affiche les informations de l'utilisateur (nom d'utilisateur et mot de passe).
5. Demande une confirmation pour la modification du mot de passe.
6. Si l'utilisateur confirme la modification, il peut entrer un nouveau mot de passe.
7. Sauvegarde de l'ancien mot de passe dans un fichier texte avant la mise à jour.
8. Hachage du nouveau mot de passe avec un sel et mise à jour du mot de passe dans la base de données.
9. En cas d'erreur lors de la mise à jour du mot de passe, le script affiche un message d'erreur approprié et n'effectue pas la mise à jour.
10. Si l'utilisateur annule la modification, le mot de passe n'est pas mis à jour.
11. Après la modification (ou l'annulation), le script propose de remettre l'ancien mot de passe en cas d'erreur.
12. La remise de l'ancien mot de passe est effectuée en mettant à jour la base de données avec la valeur sauvegardée.

## Prérequis :

1. Python (avec les bibliothèques nécessaires telles que mysql.connector et hashlib).
2. Base de données MySQL configurée et accessible avec les informations appropriées (hôte, nom de la base de données, nom d'utilisateur, mot de passe).

## Comment utiliser le script :

1. Assurez-vous que Python est installé sur votre système.
2. Créez un fichier config.json dans le même répertoire que le script et remplissez-le avec les informations de connexion à la base de données MySQL, ainsi que les noms de table et de colonnes appropriés.

```bash
    {
        "database": {
            "host": "localhost",
            "name": "nom_de_la_base_de_donnees",
            "username": "nom_d_utilisateur",
            "password": "mot_de_passe",
            "table": "nom_de_la_table",
            "uid_field": "champ_nom_d_utilisateur",
            "password_field": "champ_mot_de_passe",
            "uid_name": "nom_colonne_nom_d_utilisateur",
            "password_name": "nom_colonne_mot_de_passe"
        },
        "salt": "votre_sel_pour_hachage"
    }
```

3. Exécutez le script. Il vous demandera le nom d'utilisateur pour lequel vous souhaitez modifier le mot de passe.
4. Suivez les instructions à l'écran pour modifier ou annuler la modification du mot de passe.

## Remarques :

- Assurez-vous d'avoir correctement configuré la base de données et les informations de connexion dans le fichier config.json.