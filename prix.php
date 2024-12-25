<?php
session_start();  // Démarrer la session pour gérer le panier



// Vérifier si un produit a été ajouté au panier (via POST)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les données envoyées par le formulaire
    $med_name = $_POST['med_name'];
    $med_price = $_POST['med_price'];
    $quantity = $_POST['quantity'];
    $idphar=$_POST["idphar"];

    // Calculer le prix total pour l'article
    $total_price = $med_price * $quantity;

    // Initialiser le panier s'il n'est pas encore défini dans la session
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    // Ajouter l'article au panier
    $_SESSION['cart'][] = [
        'name' => $med_name,
        'price' => $med_price,
        'quantity' => $quantity,
        'total_price' => $total_price,
        'idphar' => $idphar
    ];

    // Optionnellement, afficher un message ou rediriger vers la page panier
    //echo "<script>alert('Produit ajouté au panier!');</script>";
    //echo "<script>window.location.href = 'pharmacy_detail.php';</script>";  // Rediriger vers prix.php pour afficher le panier
}

?>
