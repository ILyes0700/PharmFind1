<?php
if (isset($_GET['email']) && isset($_GET['id'])) {
    $email = $_GET['email'];
    $id = $_GET['id'];

    // Connexion à la base de données
    require("connect.php");

    // Mettre à jour la livraison pour marquer comme confirmée
    $sql = "UPDATE pharmacie_livraison SET confirmation='oui' WHERE email_patient='$email' AND medicament_nom='$id'";
    
    if (mysqli_query($conn, $sql)) {
       // echo "Merci pour votre confirmation de réception de la livraison.";
    } else {
        echo "Erreur lors de la confirmation.";
    }
}
?>
