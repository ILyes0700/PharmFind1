<?php
require("connect.php");
$id = $_POST["id"];
$query = "SELECT * FROM phar WHERE id = '$id'";
$result = mysqli_query($conn, $query);
if (mysqli_num_rows($result) > 0) {
    echo "<script> window.location.href = 'pharm.html'; </script>";
} else {
    echo "<script> alert('Votre ID incorrect !'); </script>";
    echo "<script> window.location.href = 'logphar.html'; </script>";
}

?>
