<?php
require("connect.php");
$tel = $_POST["tel"];
$pass = $_POST["pass"];
$role = $_POST["rol"];
if ($role == 'Ph') {
    $query = "SELECT * FROM phar WHERE tel = '$tel' AND passworde = '$pass'";
    $result = mysqli_query($conn, $query);
    if (mysqli_num_rows($result) > 0) {
        echo "<script> window.location.href = 'pharm.html'; </script>";
    } else {
        echo "<script> alert('Numéro de téléphone ou mot de passe incorrect !'); </script>";
        echo "<script> window.location.href = 'login.html'; </script>";
        
    }
}
else{
    $query = "SELECT * FROM passient WHERE tel = '$tel' AND passworde = '$pass'";
    $result = mysqli_query($conn, $query);
    if (mysqli_num_rows($result) > 0) {
        echo "<script> window.location.href = 'log11.php'; </script>";
    } else {
        echo "<script> alert('Numéro de téléphone ou mot de passe incorrect !'); </script>";
        echo "<script> window.location.href = 'login.html'; </script>";
    }
}
?>
