<?php
require("connect.php");

// Vérifier la connexion
if ($conn->connect_error) {
    die("Échec de la connexion : " . $conn->connect_error);
}

// Vérifier si un terme de recherche a été soumis
if (isset($_GET['recherche'])) {
    $recherche = $_GET['recherche'];
    
    // Sécuriser le terme de recherche pour éviter les injections SQL
    $recherche = $conn->real_escape_string($recherche);

    // Requête SQL pour rechercher dans la base de données les pharmacies dont le nom contient le terme recherché
    $sql = "SELECT * FROM phar WHERE nomphar LIKE '%$recherche%'";

    // Exécution de la requête
    $result = $conn->query($sql);

    // Vérifier si des résultats ont été trouvés
    if ($result->num_rows > 0) {
        echo "<h2>Résultats de la recherche :</h2>";
        echo "<ul>";

        // Afficher les résultats dans une liste
        while ($row = $result->fetch_assoc()) {
            echo "<li>" . $row['nomphar'] . "</li>";
        }

        echo "</ul>";
    } else {
        echo "<p>Aucune pharmacie trouvée.</p>";
    }
}

// Fermer la connexion à la base de données
$conn->close();
?>
