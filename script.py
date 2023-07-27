import mysql.connector
import hashlib
from datetime import datetime
import json

with open('config.json') as config_file:
    config = json.load(config_file)

host = config['database']['host']
database = config['database']['name']
user = config['database']['username']
password = config['database']['password']

table = config['database']['table']
uidField = config['database']['uid_field']
passwordField = config['database']['password_field']
uidName = config['database']['uid_name']
passwordName = config['database']['password_name']


salt = config['salt']

conn = mysql.connector.connect(
    host=host,
    user=user,
    password=password,
    database=database
)
cursor = conn.cursor()

utilisateur_modif = input("Entrez le nom d'utilisateur a modifier : ")

cursor.execute("SELECT * FROM " + table + " WHERE " + uidName + " = %s", (utilisateur_modif,))
result = cursor.fetchone()

if result is None:
    print("L'utilisateur specifie n'existe pas.")
else:
    print("Informations de l'utilisateur :")
    print("Nom d'utilisateur :", result[uidField])
    print("Mot de passe :", result[passwordField])

    confirmation = input("Voulez-vous vraiment modifier le mot de passe de cet utilisateur ? (Oui/Non) ")

    if confirmation.lower() == "oui":
        nouveau_mot_de_passe = input("Entrez le nouveau mot de passe : ")

        try:
            ancien_mot_de_passe = result[passwordField]
            timestamp = datetime.now().strftime("%Y-%m-%d_%H-%M-%S")
            backup_filename = "password_backup_hash_{}.txt".format(timestamp)

            with open(backup_filename, "w") as backup_file:
                backup_file.write(ancien_mot_de_passe)

            mot_de_passe_sel = salt + nouveau_mot_de_passe

            mot_de_passe_hash = hashlib.sha1(mot_de_passe_sel.encode()).hexdigest()

            cursor.execute("UPDATE " + table + " SET " + passwordName + " = %s WHERE " + uidName + " = %s",
                            (mot_de_passe_hash, utilisateur_modif))

            conn.commit()

            print("Le mot de passe de l'utilisateur", utilisateur_modif, "a ete modifie avec succes.")
        except Exception as e:
            print("Une erreur s'est produite lors de la modification du mot de passe :", str(e))
            print("Le mot de passe n'a pas ete modifie.")
    else:
        print("La modification du mot de passe a ete annulee.")

    input("Appuyez sur une touche pour remettre l'ancien mot de passe...")

    try:
        cursor.execute("UPDATE " + table + " SET " + passwordName + " = %s WHERE " + uidName + " = %s",
                         (ancien_mot_de_passe, utilisateur_modif))

        conn.commit()

        print("L'ancien mot de passe de l'utilisateur", utilisateur_modif, "a ete remis avec succes.")
    except Exception as e:
        print("Une erreur s'est produite lors de la remise de l'ancien mot de passe :", str(e))

cursor.close()
conn.close()