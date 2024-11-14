<?php
session_start();
require 'config.php'; // Inclure la configuration de la base de données

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Supprimer les espaces invisibles et uniformiser la casse
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // Préparer la requête pour éviter les injections SQL
    $stmt = $conn->prepare("SELECT id_client, mdp_client FROM client WHERE LOWER(email_client) = LOWER(?)");
    $stmt->execute([$email]);

    // Vérifier si un utilisateur avec cet email existe
    if ($stmt->rowCount() == 1) {
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Vérifier le mot de passe
        if (password_verify($password, $user['mdp_client'])) {
            // Mot de passe correct, créer une session
            $_SESSION['id_client'] = $user['id_client'];
            header("Location: accueil.php"); // Redirige vers la page d'accueil après connexion
            exit();
        } else {
            // Mot de passe incorrect
            echo "Mot de passe incorrect.";
        }
    } else {
        // Email non trouvé
        echo "Aucun compte trouvé avec cet email.";
    }
}
?>
