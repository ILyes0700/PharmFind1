<?php
session_start();

// Connexion à la base de données
require("connect.php");
if ($conn->connect_error) {
    die("Erreur de connexion à la base de données : " . $conn->connect_error);
}

// Traitement du formulaire d'envoi à la pharmacie
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['send'])) {
    // Vérifiez si les champs sont bien remplis
    if (isset($_POST['email_patient']) && isset($_POST['entreprise']) && !empty($_POST['email_patient']) && !empty($_POST['entreprise'])) {
        // Récupérer les informations du patient et de l'entreprise
        $email_patient = $_POST['email_patient'];
        $entreprise_id = $_POST['entreprise'];

        // Rechercher les informations de l'entreprise sélectionnée
        $sql_entreprise = "SELECT * FROM entreprise WHERE id = ?";
        $stmt_entreprise = $conn->prepare($sql_entreprise);
        $stmt_entreprise->bind_param("i", $entreprise_id);
        $stmt_entreprise->execute();
        $result_entreprise = $stmt_entreprise->get_result();
        $entreprise = $result_entreprise->fetch_assoc();

        // Vérifiez si le panier n'est pas vide
        if (!empty($_SESSION['cart'])) {
            // Parcourir chaque article du panier
            foreach ($_SESSION['cart'] as $item) {
                // Vérifier si 'idphar' existe dans l'élément
                $idphar = isset($item['idphar']) ? $item['idphar'] : null;

                // Récupérer les informations du médicament
                $datee = date('Y-m-d');  // Assurez-vous que la date est bien au format 'YYYY-MM-DD'
                $medicament_nom = htmlspecialchars($item['name']);
                $medicament_quantite = (int) $item['quantity'];
                $medicament_prix = (float) $item['price'];  // Le prix du médicament
                $tot = $medicament_prix * $medicament_quantite;  // Total pour cet article

                // Insertion des informations dans la base de données
                $sql = "INSERT INTO pharmacie_livraison (email_patient, entreprise, medicament_nom, medicament_quantite, medicament_prix, total, datee, pharmacy_id) 
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("sssdidsi", $email_patient, $entreprise['nom_de_entreprise'], $medicament_nom, $medicament_quantite, $medicament_prix, $tot, $datee, $idphar);  // Lier les variables
                if ($stmt->execute()) {
                    //echo " <script>alert( 'Données envoyées à la pharmacie avec succès !')</script>";
                } else {
                    echo "Erreur lors de l'envoi des données : " . $stmt->error;
                }
            }

            // Vider le panier après l'envoi
            unset($_SESSION['cart']);  // Ou $_SESSION['cart'] = []; si vous préférez
        } else {
            echo "<script>alert( 'Le panier est vide. Veuillez ajouter des produits avant d'envoyer ! .')</script>";
        }
    } else {
        //echo "L'email du patient et l'entreprise sont obligatoires.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Livraison à la Pharmacie</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
        h3 {
            text-align: center;
            color: #333;
        }
        p {
            margin: 10px 0;
            font-size: 16px;
            color: #555;
        }
        .total {
            font-size: 18px;
            font-weight: bold;
            color: #2c3e50;
            text-align: right;
            margin-top: 20px;
        }
        .empty-cart {
            font-size: 18px;
            text-align: center;
            color: #e74c3c;
        }
        .buttons {
            text-align: center;
            margin-top: 20px;
        }
        button {
            padding: 10px 20px;
            font-size: 16px;
            margin: 5px;
            cursor: pointer;
            border-radius: 5px;
            border: none;
        }
        .btn-send {
            background-color: #2ecc71;
            color: #fff;
        }
        .btn-back {
            background-color: #3498db;
            color: #fff;
        }
        /* Styles généraux */
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 20px;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        h3 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }

        /* Formulaire */
        form {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        div {
            display: flex;
            flex-direction: column;
        }

        label {
            font-size: 16px;
            margin-bottom: 5px;
            color: #555;
        }

        input[type="email"],
        select {
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #f9f9f9;
            color: #333;
        }

        input[type="email"]:focus,
        select:focus {
            border-color: #2ecc71;
            outline: none;
        }

        select {
            height: 40px;
        }

        /* Boutons */
        .buttons {
            display: flex;
            justify-content: center;
            gap: 20px;
        }

        button {
            padding: 12px 20px;
            font-size: 16px;
            cursor: pointer;
            border-radius: 5px;
            border: none;
            transition: background-color 0.3s ease;
        }

        .btn-send {
            background-color: #2ecc71;
            color: #fff;
        }

        .btn-send:hover {
            background-color: #27ae60;
        }

        .btn-back {
            background-color: #3498db;
            color: #fff;
        }

        .btn-back:hover {
            background-color: #2980b9;
        }

        /* Aide visuelle */
        option {
            padding: 10px;
        }

        option:hover {
            background-color: #e3e3e3;
        }

    </style>
</head>
<body>

<div class="container">
    <h3>Envoyer à la Pharmacie</h3>

    <?php
    if (empty($_SESSION['cart'])) {
        echo "<p class='empty-cart'>Votre panier est vide. Veuillez ajouter des produits avant de procéder à la livraison.</p>";
    } else {
        echo "<p><strong>Panier :</strong></p>";
        $total = 0;
        foreach ($_SESSION['cart'] as $item) {
            echo "<p><strong>Nom:</strong> " . htmlspecialchars($item['name']) . "</p>";
            echo "<p><strong>Prix:</strong> " . number_format($item['price'], 3, ',', ' ') . " €</p>";
            echo "<p><strong>Quantité:</strong> " . $item['quantity'] . "</p>";
            echo "<p><strong>Total pour cet article:</strong> " . number_format($item['total_price'], 3, ',', ' ') . " €</p>";
            $total += $item['total_price'];  // Ajouter chaque article au total global
        }
        echo "<div class='total'>";
        echo "<h4>Total Panier: " . number_format($total, 3, ',', ' ') . " €</h4>";
        echo "</div>";
    }
    ?>

    <form method="POST" action="livraison.php">
        <div>
            <label for="email_patient"> Votre Email avec lequel vous étes inscrit pour accéder avec succés a la commande:</label>
            <input type="email" id="email_patient" name="email_patient" required>
        </div>

        <div>
            <label for="entreprise">Entreprise (Nom de la livraison) :</label>
            <select id="entreprise" name="entreprise" required>
                <option value="">Sélectionnez une livraison</option>
                <?php
                // Récupérer les entreprises de la base de données
                $sql = "SELECT id, nom_de_entreprise, address1, zip FROM entreprise";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    // Afficher les entreprises
                    while ($row = $result->fetch_assoc()) {
                        echo "<option value='" . $row['id'] . "'>" . htmlspecialchars($row['nom_de_entreprise']) . " - " . htmlspecialchars($row['address1']) . ", " . htmlspecialchars($row['zip']) . "</option>";
                    }
                } else {
                    echo "<option value=''>Aucune entreprise disponible</option>";
                }
                ?>
            </select>
        </div>

        <div class="buttons">
            <button type="submit" name="send" class="btn-send">Envoyer à la Livreur</button>
            <button type="button" class="btn-back" ><a href="painer.php" style="text-decoration: none; color: rgb(255, 255, 255);">Retour au Panier</a></button>
        </div>
    </form>
</div>

</body>
</html>
