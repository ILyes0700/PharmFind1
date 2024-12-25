<?php
require("connect.php");

// Vérifier si l'ID de la livraison et la confirmation sont présents
if (isset($_GET['id']) && isset($_GET['confirmation'])) {
    $livraisonId = $_GET['id'];
    $confirmation = $_GET['confirmation'];

    // Si le patient confirme la livraison
    if ($confirmation === 'oui') {
        // Mettre à jour le champ email_sent à 1
        $sql = "UPDATE pharmacie_livraison SET email_sent = 1 WHERE id = '$livraisonId'";
        if (mysqli_query($conn, $sql)) {
            //echo "<script>alert('Livraison confirmée avec succès!');</script>";
        } else {
            echo "<script>alert('Erreur lors de la mise à jour de la livraison.');</script>";
        }
    }
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmation de Livraison</title>
    <style>
        .confirmation-container {
            margin-top: 50px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="confirmation-container">
        <h2>Êtes-vous sûr de vouloir confirmer la réception de votre livraison ?</h2>
        <form method="GET" action="">
            <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>">
            <button type="submit" name="confirmation" value="oui">Oui</button>
            <button type="submit" name="confirmation" value="non">Non</button>
        </form>
    </div>
</body>
</html>
