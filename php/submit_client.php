<?php
// Inclure le fichier de configuration
require_once 'config.php';

// Vérifier si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les données du formulaire
    $nom = $_POST['nom_client'];
    $prenom = $_POST['prenom_client'];
    $date_naissance = $_POST['date_naissance'];
    $email = $_POST['email_client'];
    $mdp = password_hash($_POST['mdp_client'], PASSWORD_DEFAULT); // Hachage du mot de passe
    $adresse = $_POST['adresse'];

    // Préparer la requête SQL pour insérer les données
    $sql = "INSERT INTO client (nom_client, prenom_client, date_naissance, email_client, mdp_client, adresse) 
            VALUES (:nom, :prenom, :date_naissance, :email, :mdp, :adresse)";
    $stmt = $conn->prepare($sql);

    // Lier les paramètres
    $stmt->bindParam(':nom', $nom);
    $stmt->bindParam(':prenom', $prenom);
    $stmt->bindParam(':date_naissance', $date_naissance);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':mdp', $mdp);
    $stmt->bindParam(':adresse', $adresse);

    // Exécuter la requête
    if ($stmt->execute()) {
        echo "Enregistrement réussi !";
    } else {
        echo "Erreur lors de l'enregistrement.";
    }
}
?>
