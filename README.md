# userConnectWithoutPassword

## Lancer le projet

```bash
docker compose up -d
```
ou`
```bash
docker-compose up -d
```

## Créer la table "users"

Pour créer la table "users" avec les colonnes "username" et "password", vous pouvez exécuter la requête SQL suivante :

```sql

CREATE TABLE users (
    username VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL
);
```

Cette requête crée une table "users" avec deux colonnes : "username" de type VARCHAR et "password" de type VARCHAR. Les deux colonnes sont marquées comme "NOT NULL", ce qui signifie qu'elles doivent avoir une valeur lors de l'insertion de données.

## Visualiser les utilisateurs

Pour visualiser les utilisateurs enregistrés dans la table "users", vous pouvez suivre les étapes suivantes :

Connectez-vous au conteneur MySQL :

```bash
docker exec -it <nom_du_conteneur_mysql> bash
```
Connectez-vous à la base de données souhaitée :

```bash
mysql -u <nom_utilisateur> -p <nom_base_de_données>
```
Remplacez <nom_utilisateur> par votre nom d'utilisateur MySQL et <nom_base_de_données> par le nom de votre base de données.

Exécutez la requête pour afficher tous les utilisateurs :

```sql
SELECT * FROM users;
```
   
Cette requête récupère toutes les colonnes de la table "users" et affiche les enregistrements correspondants.

Assurez-vous d'avoir le bon nom de conteneur MySQL, le nom d'utilisateur et le nom de la base de données pour vous connecter correctement.

N'oubliez pas de remplacer <nom_du_conteneur_mysql>, <nom_utilisateur> et <nom_base_de_données> par les valeurs appropriées dans les commandes.

Ces instructions devraient vous aider à créer la table "users" avec les colonnes "username" et "password" et à visualiser les utilisateurs enregistrés dans la base de données. N'hésitez pas à personnaliser ces instructions en fonction de votre environnement spécifique.

## Exécutez le script Python :

### Install mysql-connector

```bash
pip install mysql-connector-python
```

Pour exécuter le script Python qui se trouve dans le conteneur Python, vous pouvez suivre les étapes suivantes :
```bash
docker exec -it <nom_du_conteneur_python> bash
```

Remplacez <nom_du_conteneur_python> par le nom de votre conteneur Python.

Accédez au répertoire où se trouve le script Python :

```bash
cd chemin_vers_le_script>
```
Remplacez <chemin_vers_le_script> par le chemin relatif ou absolu vers le dossier où se trouve votre script Python.

```bash
python script.py
```

Remplacez script.py par le nom de votre fichier de script Python.

Le script Python sera exécuté à l'intérieur du conteneur Python et vous verrez les résultats ou les messages d'impression dans la sortie de la console.

Assurez-vous d'avoir le bon nom de conteneur Python et le chemin correct vers le script Python pour exécuter le script avec succès.

N'oubliez pas de remplacer <nom_du_conteneur_python> par le nom approprié de votre conteneur Python et <chemin_vers_le_script> avec le chemin correct vers le script Python dans votre système de fichiers.

Ces instructions devraient vous aider à lancer le script Python qui se trouve dans le conteneur Python.