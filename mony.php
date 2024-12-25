<?php
// Connexion à la base de données
session_start();
require("connect.php"); // Assurez-vous que ce fichier contient la connexion à la base de données
$idphar=$_GET["id"];
if ($conn->connect_error) {
    die("Erreur de connexion à la base de données : " . $conn->connect_error);
}
//Récupérer les pharmacies pour un état sélectionné, si l'état est défini dans l'URL
$idphar = isset($_GET['id']) ? $_GET['id'] : '';
// Récupérer les médicaments depuis la table pharmacy_medicaments
$sql = "SELECT * FROM pharmacy_medicaments where pharmacy_id=$idphar"; //where pharmacy_id=$idphar";
$result = $conn->query($sql);

$total_quantite = 0;
$total_prix = 0;
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PharmFind - Liste des Médicaments</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Kanit:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="medfind.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f8f9fa;
            color: #333;
        }
        nav {
            background-color: rgb(218, 218, 218);
        }
        .navbar-nav .nav-link {
            color: #fff;
        }
        .navbar-nav .nav-link.active {
            color: #ffc107;
        }
        .container {
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-top: 50px;
        }
        .btn-print {
            background-color:rgb(243, 169, 58);
            color: #fff;
            border:none;
            border-radius:8px;
        }
        .kanit-regular {
  font-family: "Kanit", serif;
  font-weight: 400;
  font-style: normal;
}
        .bt{
            background-color:rgb(34, 108, 219);
            color: #fff;
            margin-left:440px;
        }
        h2 {
            font-size: 2rem;
            color: #007bff;
            margin-bottom: 30px;
        }
        table {
            width: 100%;
            margin-bottom: 20px;
        }
        th, td {
            text-align: center;
            padding: 12px;
        }
        th {
            background-color: #007bff;
            color: #fff;
        }
        td {
            background-color: #f9f9f9;
        }
        .table-bordered {
            border: 1px solid #dee2e6;
        }
        .total-section {
            margin-top: 30px;
            padding: 20px;
            background-color: #f1f1f1;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .footer {
            background-color:rgb(227, 235, 243);
            color: #fff;
            padding: 20px 0
            text-align: center;
            margin-top: 50px;
        }
        .footer a {
            color: #ffc107;
            text-decoration: none;
        }
        .footer a:hover {
            text-decoration: underline;
        }
        .navbar-brand {
            color: #fff;
            font-weight: bold;
            font-size: 30px;
        }
        .im {
            margin-left: 30px;
            margin-top: -10px;
        }
        footer a {
            color: black;
            text-decoration: none;
        }
        .container {
            padding: 15px;
        }
        h2 {
            font-size: 1.5rem;
            text-align: center;
        }
        .table th, .table td {
            padding: 8px;
        }
        .table-responsive {
            overflow-x: auto;
        }
        .pm{
            padding-left:0px;
            color:rgba(172, 145, 235, 0.48);
        }
        .jn{
            padding-right:20px;
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
<body style="background-color: #ffffff; " class="kanit-regular">
<nav class="navbar navbar-expand-lg" style=" background-color: #ffffff; ">
        <div class="container">
          <a class="navbar-brand d-flex align-items-center" href="pharm.html">
            <img src="i1.png" alt="Logo PharmFind" class="me-2" style="width: 40px; height: 40px;">
            <h3 class="mb-0" style=" color:#002060;">PharmFind</h3>
          </a>
      </nav>
    <div class="container mb-5">
    <a href="monphar.html" class="back-button mt-2 mb-5">
            <i class="fa fa-arrow-left"></i> Retour à la page précédente
        </a>
        <h2 class="pl-5">Liste des Médicaments Achétée</h2>
        <?php
        if ($result->num_rows > 0) {
            echo '<div class="table-responsive">';
            echo '<table class="table table-bordered table-striped">';
            echo '<thead><tr><th>Nom</th><th>Quantité</th><th>Prix</th><th>Total</th><th>Date</th></tr></thead><tbody>';

            while ($row = $result->fetch_assoc()) {
                $total_item = $row['quantite'] * $row['prix'];
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row['nom_medicament']) . "</td>";
                echo "<td>" . $row['quantite'] . "</td>";
                echo "<td>" . number_format($row['prix'], 2, ',', ' ') . " d</td>";
                echo "<td>" . number_format($total_item, 2, ',', ' ') . " d</td>";
                echo "<td>" . $row['datee'] . "</td>";
                echo "</tr>";

                $total_quantite += $row['quantite'];
                $total_prix += $total_item;
            }

            echo '</tbody></table>';
            echo '</div>';
        } else {
            echo "<p>Aucun médicament disponible.</p>";
        }
        ?>
        
        <div class="total-section">
            <h3>Total des Médicaments</h3>
            <p><strong>Quantité totale :</strong> <?php echo $total_quantite; ?> </p>
            <p><strong>Total des prix :</strong> <?php echo number_format($total_prix, 2, ',', ' ') . " d"; ?></p>
        </div>
        <div class="col-12 text-center pt-4">
        <input type="submit" class="btn btn-primary" onclick="window.print();"  value="Imprimer le Facture">
        </div>
    </div>

    <div class="text-center mt-4">
            <p class="footer-text" style="color: #b0b0b0; font-size: 14px;">PharmFind &copy; 2024 | Designed by <strong>Ilyes</strong></p>
        </div>

</body>
</html>

<?php
// Fermer la connexion
$conn->close();
?>
