<?php
// Récupérer les données du formulaire
$newUsername = $_POST['new_username'];
$newPassword = $_POST['new_password'];

$config = json_decode(file_get_contents('config.json'), true);

// Récupérer les informations de connexion à la base de données
$servername = $config['database']['host'];
$database = $config['database']['name'];
$db_username = $config['database']['username'];
$db_password = $config['database']['password'];

# Récupérer les informations de connexion à la table users  
$table = $config['database']['table'];
$uidName = $config['database']['uid_name'];
$$passwordName = $config['database']['password_name'];

// Récupérer le sel personnalisé
$salt = $config['salt'];

// Connexion à la base de données
$conn = new mysqli($servername, $db_username, $db_password, $database);

// Vérifier la connexion
if ($conn->connect_error) {
    die('Échec de la connexion à la base de données : ' . $conn->connect_error);
}

// Vérifier si l'utilisateur existe déjà
$checkUserQuery = "SELECT * FROM " . $table . " WHERE " . $uidName . "='$newUsername'";
$checkUserResult = $conn->query($checkUserQuery);

if ($checkUserResult->num_rows > 0) {
    echo 'L\'utilisateur existe déjà. Veuillez choisir un autre nom d\'utilisateur.';
} else {
    // Concaténer le sel avec le mot de passe
    $passwordWithSalt = $salt . $newPassword;

    // Calculer le hash SHA1 du mot de passe avec le sel
    $hashedPassword = sha1($passwordWithSalt);

    // Insérer l'utilisateur dans la base de données
    $insertUserQuery = "INSERT INTO users (username, password) VALUES ('$newUsername', '$hashedPassword')";
    if ($conn->query($insertUserQuery) === TRUE) {
        echo 'Inscription réussie !';
    } else {
        echo 'Échec de l\'inscription. Veuillez réessayer.';
    }
}

$conn->close();
?>

<a href="/">Retour à l'accueil</a>
