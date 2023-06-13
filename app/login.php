<?php
// Récupérer les données du formulaire
$username = $_POST['username'];
$password = $_POST['password'];

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

// Récupérer le mot de passe hashé pour l'utilisateur donné
$getPasswordQuery = "SELECT " . $passwordName . " FROM " . $table . " WHERE " . $uidName . "='$username'";
$getPasswordResult = $conn->query($getPasswordQuery);

if ($getPasswordResult->num_rows > 0) {
    $row = $getPasswordResult->fetch_assoc();
    $hashedPassword = $row['password'];

    // Calculer le hash SHA1 du mot de passe fourni avec le sel
    $passwordWithSalt = $salt . $password;
    $hashedPasswordToCheck = sha1($passwordWithSalt);

    // Vérifier le mot de passe
    if ($hashedPassword === $hashedPasswordToCheck) {
        echo 'Connexion réussie !';
    } else {
        echo 'Échec de la connexion. Veuillez vérifier vos informations de connexion.';
    }
} else {
    echo 'Échec de la connexion. Veuillez vérifier vos informations de connexion.';
}

$conn->close();
?>

<a href="/">Retour à l'accueil</a>
