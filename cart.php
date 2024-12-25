<?php
session_start();  // Démarre la session pour gérer le panier

if (!isset($_SESSION['cart']) || count($_SESSION['cart']) == 0) {
    echo "Votre panier est vide.";
    exit;
}

$total = 0;
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Panier</title>
</head>
<body>
    <h1>Votre Panier</h1>
    <table border="1">
        <tr>
            <th>Nom</th>
            <th>Prix Unitaire</th>
            <th>Quantité</th>
            <th>Total</th>
        </tr>
        <?php foreach ($_SESSION['cart'] as $item): ?>
            <tr>
                <td><?= $item['name']; ?></td>
                <td><?= $item['price']; ?> €</td>
                <td><?= $item['quantity']; ?></td>
                <td><?= $item['total_price']; ?> €</td>
            </tr>
            <?php $total += $item['total_price']; ?>
        <?php endforeach; ?>
    </table>

    <p>Total : <?= $total; ?> €</p>
    <a href="delivery.php">Sélectionner une entreprise de livraison</a>
</body>
</html>
