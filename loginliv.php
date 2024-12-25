<?php
require("connect.php");
$id = $_POST["id"];
$query = "SELECT * FROM entreprise WHERE id = '$id'";
$result = mysqli_query($conn, $query);
if (mysqli_num_rows($result) > 0) {
    echo "<script> window.location.href = 'livr.php'; </script>";
} else {
    echo "<script> alert('Votre ID incorrect ! !'); </script>";
    echo "<script> window.location.href = 'logliv.html'; </script>";
        
}

?>
