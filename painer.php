<?php
session_start();

// Connexion à la base de données
require("connect.php");
if ($conn->connect_error) {
    die("Erreur de connexion à la base de données : " . $conn->connect_error);
}

// Traitement du formulaire d'envoi à la pharmacie
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['send'])) {
    if (!empty($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as $item) {
            // Vérifier si 'idphar' existe dans l'élément
            if (isset($item['idphar'])) {
                $idphar = $item['idphar'];
            } else {
                $idphar = null;  // Si l'ID de la pharmacie n'est pas défini, on le met à null
            }
        
            // Récupérer les informations du médicament
            $datee = date('Y-m-d');  // La date d'achat du médicament
            $medicament_nom = htmlspecialchars($item['name']);
            $medicament_quantite = (int) $item['quantity'];
            $medicament_prix = (float) $item['price'];  // Le prix du médicament
            $tot = $medicament_prix * $medicament_quantite;  // Total pour cet article

            // Insertion des informations dans la base de données
            $sql = "INSERT INTO pharmacy_medicaments (nom_medicament, quantite, prix, pharmacy_id, datee) 
                    VALUES (?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sdids", $medicament_nom, $medicament_quantite, $tot, $idphar, $datee);  // Lier les variables
            $stmt->execute();
        }
        
        // Vider le panier après l'envoi
        unset($_SESSION['cart']);  // Ou $_SESSION['cart'] = []; si vous préférez
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon Panier</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Kanit:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        .kanit-regular {
  font-family: "Kanit", serif;
  font-weight: 400;
  font-style: normal;
}
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
        .item {
            border-bottom: 1px solid #ddd;
            padding: 15px 0;
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
        .btn-print {
            background-color: rgb(243, 169, 58);
            color: #fff;
        }
        .bt {
            background-color: rgb(34, 108, 219);
            color: #fff;
        }
        .btn-download {
            background-color: #27ae60;
            color: #fff;
        }
        .tot {
            color: #27ae60;
        }
        .back-button i {
            margin-right: 8px;
        }
        .back-button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            font-size: 16px;
            margin-bottom: 20px;
            transition: background-color 0.3s ease;
        }
    </style>
</head>
<body class="kanit-regular">

<div class="container">
            <a href="log11.php" class="back-button mt-2 mb-5">
                <i class="fa fa-arrow-left"></i> Retour à la page précédente
            </a>

    <?php
    if (empty($_SESSION['cart'])) {
        echo "<p class='empty-cart'>Votre panier est vide.</p>";
    } else {
        echo "<h3>Panier</h3>";
        $total = 0;
        foreach ($_SESSION['cart'] as $item) {
            echo "<div class='item'>";
            echo "<p><strong>Nom:</strong> " . htmlspecialchars($item['name']) . "</p>";
            echo "<p><strong>Prix:</strong> " . number_format($item['price'], 3, ',', ' ') . " €</p>";
            echo "<p><strong>Quantité:</strong> " . $item['quantity'] . "</p>";
            echo "<p><strong>Total:</strong> " . number_format($item['total_price'], 3, ',', ' ') . " €</p>";
            echo "</div>";
            $total += $item['total_price'];  // Ajouter chaque article au total global
        }
        echo "<div class='total'>";
        echo "<h4>Total Panier: " . number_format($total, 3, ',', ' ') . " €</h4>";
        echo "</div>";
    }
    ?>

    <div class="buttons">
        <!-- Formulaire pour envoyer à la pharmacie -->
        <form method="POST" action="livraison.php">
            <button type="submit" name="send" class="btn-print kanit-regular">Envoyer à la Pharmacie</button>
        </form>
    </div>

    <div class="buttons">
        <button class="btn-print bt kanit-regular" onclick="window.print();">Imprimer le Panier</button>
        <button class="btn-download kanit-regular" onclick="downloadCart();">Télécharger en PDF</button>
    </div>

</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script>
    function downloadCart() {
        const { jsPDF } = window.jspdf;
        const doc = new jsPDF();

        let content = 'Panier:\n\n';
        <?php
        if (!empty($_SESSION['cart'])) {
            foreach ($_SESSION['cart'] as $item) {
                echo "content += 'Nom: " . htmlspecialchars($item['name']) . "\\n';";
                echo "content += 'Prix: " . number_format($item['price'], 3, ',', ' ') . " €\\n';";
                echo "content += 'Quantité: " . $item['quantity'] . "\\n';";
                echo "content += 'Total: " . number_format($item['total_price'], 3, ',', ' ') . " €\\n\\n';";
            }
        }
        ?>
        content += 'Total Panier: <?php echo number_format($total, 3, ',', ' '); ?> €';

        doc.text(content, 10, 10);
        doc.save('panier.pdf');
    }
</script>

</body>
</html>
