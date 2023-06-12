<?php
// Récupérer les données du formulaire
$newUsername = $_POST['new_username'];
$newPassword = $_POST['new_password'];

// Connexion à la base de données
$servername = 'mysql';
$database = 'your_database_name';
$db_username = 'your_username';
$db_password = 'your_password';

$conn = new mysqli($servername, $db_username, $db_password, $database);

// Vérifier la connexion
if ($conn->connect_error) {
    die('Échec de la connexion à la base de données : ' . $conn->connect_error);
}

// Vérifier si l'utilisateur existe déjà
$checkUserQuery = "SELECT * FROM users WHERE username='$newUsername'";
$checkUserResult = $conn->query($checkUserQuery);

if ($checkUserResult->num_rows > 0) {
    echo 'L\'utilisateur existe déjà. Veuillez choisir un autre nom d\'utilisateur.';
} else {
    // Hasher le mot de passe
    $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

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
