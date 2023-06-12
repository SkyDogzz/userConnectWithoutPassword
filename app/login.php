<?php
// Récupérer les données du formulaire
$username = $_POST['username'];
$password = $_POST['password'];

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

// Récupérer le mot de passe hashé pour l'utilisateur donné
$getPasswordQuery = "SELECT password FROM users WHERE username='$username'";
$getPasswordResult = $conn->query($getPasswordQuery);

if ($getPasswordResult->num_rows > 0) {
    $row = $getPasswordResult->fetch_assoc();
    $hashedPassword = $row['password'];

    // Vérifier le mot de passe
    if (password_verify($password, $hashedPassword)) {
        echo 'Connexion réussie !';
    } else {
        echo 'Échec de la connexion. Veuillez vérifier vos informations de connexion.';
    }
} else {
    echo 'Échec de la connexion. Veuillez vérifier vos informations de connexion.';
}

$conn->close();
?>
