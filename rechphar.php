<?php
// Connexion à la base de données
require("connect.php");

// Vérifier la connexion
if ($conn->connect_error) {
    die("Échec de la connexion : " . $conn->connect_error);
}

// Récupérer les pharmacies pour un état sélectionné, si l'état est défini dans l'URL
$state = isset($_GET['statee']) ? $_GET['statee'] : '';

// Requête SQL pour récupérer les états uniques de la table 'phar' (en supposant que 'statee' est l'état)
$sql_states = "SELECT DISTINCT statee FROM phar ORDER BY statee";
$result_states = $conn->query($sql_states);

// Requête SQL pour récupérer les pharmacies d'un état particulier
$sql_pharmacies = "";
if ($state) {
    $state = $conn->real_escape_string($state);  // Sécuriser l'état
    $sql_pharmacies = "SELECT * FROM phar WHERE statee = '$state'";
    $result_pharmacies = $conn->query($sql_pharmacies);
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PharmFind</title>

    <!-- Lien vers Bootstrap pour le style de base -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f7f7f7;
            color: #333;
        }

        .container {
            background-color: #fff;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-top: 50px;
        }

        h1 {
            color: #007bff;
            font-size: 28px;
            margin-bottom: 30px;
        }

        h2 {
            color: #28a745;
            margin-top: 20px;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #004085;
        }

        .list-group-item {
            background-color: #f8f9fa;
            border: 1px solid #ddd;
            margin-bottom: 10px;
            border-radius: 5px;
            font-size: 16px;
        }

        .list-group-item:hover {
            background-color: #e9ecef;
        }
    </style>
</head>
<body>

<div class="container mt-1">
    <h1>Rechercher des Pharmacies par État</h1>

    <!-- Formulaire pour choisir l'état -->
    <form action="" method="GET">
        <div class="mb-3">
            <label for="statee" class="form-label" style="color:#007bff; font-weight: bold;">Sélectionner un État</label>
            <select name="statee" id="statee" class="form-control">
                <option value="">Choisir un état</option>
                <?php
                if ($result_states->num_rows > 0) {
                    while ($row = $result_states->fetch_assoc()) {
                        $selected = ($row['statee'] == $state) ? 'selected' : '';
                        echo "<option value='" . $row['statee'] . "' $selected>" . $row['statee'] . "</option>";
                    }
                }
                ?>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Rechercher</button>
    </form>

    <!-- Affichage des pharmacies pour l'état sélectionné -->
    <?php
    if ($state && $result_pharmacies && $result_pharmacies->num_rows > 0) {
        echo "<h2>Pharmacies en $state</h2>";
        echo "<ul class='list-group mt-3'>";
        while ($row = $result_pharmacies->fetch_assoc()) {
            echo "<li class='list-group-item'>
                    <a   style='text-decoration: none;' href='pharmacy_detail.php?id=" . $row['id'] . "'>" . $row['nomphar'] . " - " . $row['address1'] . " (" . $row['zip'] . ")</a>
                  </li>";
        }
        echo "</ul>";
    } elseif ($state) {
        echo "<p>Aucune pharmacie trouvée dans cet état.</p>";
    }
    ?>
</div>

</body>
</html>

<?php
// Fermer la connexion à la base de données
$conn->close();
?>
