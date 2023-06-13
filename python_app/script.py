import mysql.connector
import hashlib
from datetime import datetime
import json

# Lire les informations de configuration à partir du fichier JSON
with open('config.json') as config_file:
    config = json.load(config_file)

# Récupérer les informations de connexion à la base de données
host = config['database']['host']
database = config['database']['name']
user = config['database']['username']
password = config['database']['password']

# Récupérer le sel personnalisé
salt = config['salt']

# Connexion à la base de données
conn = mysql.connector.connect(
    host=host,
    user=user,
    password=password,
    database=database
)
# Demander le nom d'utilisateur à modifier
utilisateur_modif = input("Entrez le nom d'utilisateur à modifier : ")

# Vérifier si l'utilisateur existe
cursor.execute("SELECT * FROM users WHERE username = %s", (utilisateur_modif,))
result = cursor.fetchone()

if result is None:
    print("L'utilisateur spécifié n'existe pas.")
else:
    # Afficher les informations de l'utilisateur
    print("Informations de l'utilisateur :")
    print("Nom d'utilisateur :", result[0])
    print("Mot de passe :", result[1])

    # Demander confirmation pour la modification
    confirmation = input("Voulez-vous vraiment modifier le mot de passe de cet utilisateur ? (Oui/Non) ")

    if confirmation.lower() == "oui":
        # Demander le nouveau mot de passe
        nouveau_mot_de_passe = input("Entrez le nouveau mot de passe : ")

        try:
            # Sauvegarder l'ancien mot de passe hashé dans un fichier avec la date et l'heure
            ancien_mot_de_passe = result[1]
            timestamp = datetime.now().strftime("%Y-%m-%d_%H-%M-%S")
            backup_filename = f"password_backup_hash_{timestamp}.txt"

            with open(backup_filename, "w") as backup_file:
                backup_file.write(ancien_mot_de_passe)

            # Concaténer le sel avec le nouveau mot de passe
            mot_de_passe_sel = salt + nouveau_mot_de_passe

            # Calculer le hash SHA1 du mot de passe avec le sel
            mot_de_passe_hash = hashlib.sha1(mot_de_passe_sel.encode()).hexdigest()

            # Modifier le mot de passe dans la base de données
            cursor.execute("UPDATE users SET password = %s WHERE username = %s",
                           (mot_de_passe_hash, utilisateur_modif))

            # Valider les modifications dans la base de données
            conn.commit()

            print("Le mot de passe de l'utilisateur", utilisateur_modif, "a été modifié avec succès.")
        except Exception as e:
            print("Une erreur s'est produite lors de la modification du mot de passe :", str(e))
            print("Le mot de passe n'a pas été modifié.")
    else:
        print("La modification du mot de passe a été annulée.")

# Attendre que l'utilisateur appuie sur une touche avant de remettre l'ancien mot de passe
input("Appuyez sur une touche pour remettre l'ancien mot de passe...")

try:
    # Remettre l'ancien mot de passe dans la base de données
    cursor.execute("UPDATE users SET password = %s WHERE username = %s",
                   (ancien_mot_de_passe, utilisateur_modif))

    # Valider les modifications dans la base de données
    conn.commit()

    print("L'ancien mot de passe de l'utilisateur", utilisateur_modif, "a été remis avec succès.")
except Exception as e:
    print("Une erreur s'est produite lors de la remise de l'ancien mot de passe :", str(e))

# Fermer la connexion et le curseur
cursor.close()
conn.close()
