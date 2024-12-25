<?php
// Connexion à la base de données
require("connect.php");
session_start();
// Vérifier la connexion
if ($conn->connect_error) {
    die("Échec de la connexion : " . $conn->connect_error);
}
//$sql_meds = "SELECT med.nom, med.imagee, med.disce, med.prix FROM med
//JOIN phar_med ON med.id = phar_med.med_id 
//WHERE phar_med.phar_id = $pharmacy_id";

// Récupérer l'ID de la pharmacie depuis l'URL
$pharmacy_id = isset($_GET['id']) ? $_GET['id'] : 0;

// Sécuriser l'ID pour éviter les injections SQL
$pharmacy_id = $conn->real_escape_string($pharmacy_id);
// Requête SQL pour récupérer les médicaments de la pharmacie par son ID
$sql_meds = "SELECT m.id,m.nom,m.imagee,m.disce,m.prix from med m , phar p where m.id=p.id and p.id=$pharmacy_id ORDER BY m.nom ASC;";
$result_meds = $conn->query($sql_meds);

// Requête SQL pour récupérer les détails de la pharmacie
$sql_pharmacy = "SELECT * FROM phar WHERE id = $pharmacy_id";
$result_pharmacy = $conn->query($sql_pharmacy);
$pharmacy = $result_pharmacy->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PharmFind</title>
    <link rel="stylesheet" href="medfind.css">
    <link rel="website icon" href="i1.png" type="png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Kanit:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel= "stylesheet" href= "https://maxst.icons8.com/vue-static/landings/line-awesome/font-awesome-line-awesome/css/all.min.css" >
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f7f7f7;
        }
        .container {
            background-color: #fff;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-top: 50px;
        }
        h1, h2 {
            color: #007bff;
        }
        .card {
            margin-top: 20px;
        }
        .card-body {
            text-align: center;
        }
        .card-title {
            font-size: 18px;
            font-weight: bold;
        }
        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }
        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #004085;
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
        .cart-container {
    position: relative;
    display: inline-block;
}
.num{
    border-color: #002060;
    background-color:rgb(232, 240, 255) ;
    border-radius: 15%;
    width: 90px;
}

.cart-badge {
    position: absolute;
    top: -5px;
    right: -10px;
    background-color: #007bff;
    color: white;
    font-size: 14px;
    padding: 2px 6px;
    border-radius: 50%;
}
.kanit-regular {
  font-family: "Kanit", serif;
  font-weight: 400;
  font-style: normal;
}

    </style>
</head>
<body class="kanit-regular">
<nav class="navbar navbar-expand-lg navbar-light">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center" href="log11.php">
            <img src="i1.png" alt="Logo" class="im mt-0" style="width: 40px; margin-right: 10px;">
            <h3 class="pt-2" style="color: #002060;  font-size: 2rem;">PharmFind</h3>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav ms-auto">
    <li class="nav-item">
    <a class="nav-link active lie" href="painer.php" style="color: #007bff; font-weight: bold;">
        <!-- Conteneur de l'icône du panier avec un badge -->
        <div class="cart-container" style="position: relative; display: inline-block;">
            <!-- Image du panier -->
            <img src="pan.png" alt="Panier" style="height:45px; width:45px; margin-top: 15px; margin-right: 18px;">
            
            <!-- Badge du nombre d'articles -->
            <?php
            // Calculer le nombre d'articles dans le panier
            if (isset($_SESSION['cart']) && count($_SESSION['cart']) > 0) {
                $cartCount = count($_SESSION['cart']); // Nombre d'articles dans le panier
            } else {
                $cartCount = 0; // Si le panier est vide
            }
            ?>
            <!-- Si il y a des articles, afficher le badge -->
            <?php if ($cartCount > 0): ?>
                <span class="cart-badge" style="position: absolute; top: -5px; right: 41px; background-color: #007bff; color: white; font-size: 14px; padding: 2px 6px; border-radius: 50%;">
                    <?php echo $cartCount; ?>
                </span>
            <?php endif; ?>
        </div>
    </a>
</li>



        <li class="nav-item">
            <a class="nav-link active" href="clic.html" style="color: #007bff; font-weight: bold;"><img src="ch.png" alt="" style="height:70px ; width:70px ;"></a>
        </li>
    </ul>
</div>

    </div>
</nav>
<div class="container">
<a href="log11.php" class="back-button mt-2 mb-3">
                <i class="fa fa-arrow-left"></i> Retour à la page précédente
            </a>

    <h2>Détails de la Pharmacie: <?php echo $pharmacy['nomphar']; ?></h2>
    <p style="color:rgb(89, 190, 148); font-weight: bold;"><strong>Adresse:</strong> <?php echo $pharmacy['address1'] . ', ' . $pharmacy['zip']; ?></p>

    <h2>Médicaments disponibles:</h2>

    <div class="row">
    <?php
if ($result_meds->num_rows > 0) {
    while ($row = $result_meds->fetch_assoc()) {
        echo "<div class='col-xs-12 col-sm-12 col-md-6 col-lg-3 pt-3'>
                <div class='card'>
                    <img src='" . $row['imagee'] . "' class='card-img-top' alt='...'>
                    <div class='card-body ca'>
                        <h5 class='card-title'><span class='co'>" . $row['nom'] . "</span></h5>
                        <p class='card-text'>" . $row['disce'] . "</p>
                        <form action='prix.php' method='POST'>
                            <input type='hidden' name='med_name' value='" . $row['nom'] . "'>
                            <input type='hidden' name='idphar' value='" . $pharmacy_id . "'>
                            <input type='hidden' name='med_price' value='" . $row['prix'] . "'>
                            <input type='number' name='quantity' class='num' placeholder='Quantité' min='0' required>
                            <input type='submit' class='btn btn-primary bt'value='Acheter'>
                        </form>
                        
                        <p class='prix pt-2'>" . $row['prix'] . " d</p>
                    </div>
                </div>
              </div>";
    }
} else {
    echo "<p style='color:rgb(89, 190, 148); font-weight: bold;'>Aucun médicament trouvé dans cette pharmacie.</p>";
}
?>


</div>

<div class="text-center mt-5 mb-0">
    <p class="footer-text mt-5" style="color: #b0b0b0; font-size: 14px; padding-top: 50px;">PharmFind &copy; 2024 | Designed by <strong>Ilyes</strong></p>
</div>
</body>
</html>

<?php
// Fermer la connexion à la base de données
$conn->close();
?>
