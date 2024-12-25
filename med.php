<?php
// Connexion à la base de données
require("connect.php");

// Vérifier si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Vérification que le fichier image a bien été soumis
    if (isset($_FILES["imagee"])) {

        // Récupérer les données envoyées depuis le formulaire
        $id = $_POST["id"];  // ID de la pharmacie
        $nom = $_POST["nom"];  // Nom du médicament
        $prix = $_POST["prix"];  // Prix du médicament
        $disce = $_POST["disc"];  // Description du médicament

        // Gestion de l'image téléchargée
        $target_dir = "uploads/";  // Dossier où l'image sera stockée
        $target_file = $target_dir . basename($_FILES["imagee"]["name"]);  // Chemin du fichier
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));  // Type du fichier

        // Vérification si le fichier est bien une image
        if (getimagesize($_FILES["imagee"]["tmp_name"]) === false) {
            echo "<script>alert('Le fichier n\\'est pas une image.');</script>";
            echo "<script> window.location.href = 'pharm.html'; </script>";
            exit;
        }
        // Vérification de la taille de l'image (max 500 KB)
        if ($_FILES["imagee"]["size"] > 500000) {
            echo "<script>alert('Le fichier est trop lourd.');</script>";
            echo "<script> window.location.href = 'pharm.html'; </script>";
            exit;
        }

        // Vérifier les formats d'images autorisés
        if ($imageFileType != "jpg" && $imageFileType != "jpeg" && $imageFileType != "png" && $imageFileType != "gif" && $imageFileType != "webp") {
            echo "<script>alert('Seuls les formats JPG, JPEG, PNG, GIF, et WEBP sont autorisés.');</script>";
            exit;
        }

        // Déplacer le fichier téléchargé dans le dossier 'uploads'
        if (move_uploaded_file($_FILES["imagee"]["tmp_name"], $target_file)) {

            // Préparer la requête SQL pour insérer les données dans la base de données
            $query = "INSERT INTO med (id, nom, imagee, disce,prix) 
                      VALUES ('$id', '$nom', '$target_file', '$disce', '$prix')";

            // Exécuter la requête SQL
            if (mysqli_query($conn, $query)) {
                //echo "<script>alert('Médicament ajouté avec succès !');</script>";
                echo "<script> window.location.href = 'pharm.html'; </script>";
            } else {
                echo "<script>alert('Erreur lors de l\\'ajout du médicament : " . mysqli_error($conn) . "');</script>";
            }
        } else {
            echo "<script>alert('Erreur lors du téléchargement de l\\'image.');</script>";
            echo "<script> window.location.href = 'pharm.html'; </script>";
        }
    } else {
        echo "<script>alert('Aucune image téléchargée.');</script>";
        echo "<script> window.location.href = 'pharm.html'; </script>";
    }
}

// Fermer la connexion à la base de données
mysqli_close($conn);
?>
