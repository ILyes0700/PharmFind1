<?php
session_start();  // Cette ligne doit être en premier dans votre fichier PHP
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accounte</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Kanit:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="medfind.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/font-awesome-line-awesome/css/all.min.css">
    <link rel="website icon" href="i1.png" type="png">
    <style>
        .kanit-regular {
  font-family: "Kanit", serif;
  font-weight: 400;
  font-style: normal;
}
 .cart-container {
    position: relative;
    display: inline-block;
}

.cart-badge {
    position: absolute;
    top: -5px;
    right: -5px;
    background-color: red;
    color: white;
    font-size: 14px;
    padding: 2px 6px;
    border-radius: 50%;
}


    </style>
</head>
<body class="kanit-regular" style="background-color: #ffffff;">
<nav class="navbar navbar-expand-lg navbar-light">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center" href="log11.php">
            <img src="i1.png" alt="Logo" class="im mt-0" style="width: 40px; margin-right: 10px;">
            <h3 class="pt-2" style="color: #002060;   font-size: 2rem;">PharmFind</h3>
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
<section class="container">
    <?php include("rechphar.php"); ?>
</section>
<div class="text-center mt-5 mb-0">
    <p class="footer-text mt-5" style="color: #b0b0b0; font-size: 14px; padding-top: 50px;">PharmFind &copy; 2024 | Designed by <strong>Ilyes</strong></p>
</div>
</body>
</html>
