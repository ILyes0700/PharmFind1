<?php
// Inclusion de PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Connexion à la base de données
include('connect.php');  // Assurez-vous que ce fichier contient la connexion à la base de données

// Récupération des données envoyées via POST
$email = $_POST['email'];
$tel = $_POST['tel'];
$pass = $_POST['pass'];
$nom = $_POST['nom'];
$prenom = $_POST['pre'];
$date = $_POST['date'];
$address = $_POST['add'];
$address2 = $_POST['add2'];
$state = $_POST['stat'];
$zip = $_POST['zip'];
$role = $_POST['check2'];  // Pharmacien ou autre
$gender = $_POST['check1']; // Genre (Homme ou Femme)
$nomphar = $_POST['nomphar']; // Nom de la pharmacie si Pharmacien

// Vérifier la connexion à la base de données
if (!$conn) {
    die("Connexion échouée : " . mysqli_connect_error());
}

// Vérifier si le numéro de téléphone existe déjà dans la table phar
$req = mysqli_query($conn, "SELECT * FROM phar WHERE tel = '$tel'");

if ($role == 'Pharmacien') {
    // Si le rôle est Pharmacien et que le numéro de téléphone n'existe pas
    if (mysqli_num_rows($req) == 0) {
        // Insérer les données dans la table 'phar' (pour les pharmaciens)
        $id = rand(100, 9999999);
        $req2 = mysqli_query($conn, "INSERT INTO phar (id,email, tel, passworde, nom, prenom, gender, datee, address1, address2, statee, zip, typee, nomphar) 
                                    VALUES ('$id','$email', '$tel', '$pass', '$nom', '$prenom', '$gender', '$date', '$address', '$address2', '$state', '$zip', '$role', '$nomphar')");

        if ($req2) {
            echo "<script>alert('$nom ajouté avec succès!')</script>";
            $id_pharmacie = mysqli_insert_id($conn);
            // Envoi de l'e-mail de confirmation
            require 'vendor/autoload.php'; // Charge PHPMailer
            $mail = new PHPMailer(true);

            try {
                // Configurer le serveur SMTP
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';  // Utilisation du serveur SMTP de Gmail
                $mail->SMTPAuth = true;          // Activation de l'authentification SMTP
                $mail->Username = 'pharfind@gmail.com';  // Remplacez par votre adresse e-mail Gmail
                $mail->Password = 'rfqdlvatmnuklgtb';  // Utilisez le mot de passe d'application
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;  // Utilisation de TLS pour sécuriser la connexion
                $mail->Port = 587;  // Port utilisé par Gmail pour TLS

                // Informations de l'expéditeur et du destinataire
                $mail->setFrom('pharfind@gmail.com', 'PharmFind');
                $mail->addAddress($email, $nom);  // Remplacez par l'adresse du pharmacien

                // Contenu de l'e-mail
                $mail->isHTML(true);
                $mail->Subject = 'Confirmation d\'inscription';
                $mail->Body    = "Bonjour " . $nom  . ",<br><br>Votre inscription en tant que pharmacien est confirmée.<br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Identifiant :&nbsp;&nbsp;   $id_pharmacie <br><br>Merci de vous être inscrit sur PharmFind.";
                $mail->AltBody = 'Bonjour ' . $nom . ', Votre inscription en tant que pharmacien est confirmée. Telephone : ' . $tel;

                // Envoi de l'e-mail
                $mail->send();
                echo "<script>alert('E-mail de confirmation envoyé avec succès !');</script>";
                echo "<script> window.location.href = 'login.html'; </script>";

            } catch (Exception $e) {
                echo "Erreur lors de l'envoi de l'e-mail: {$mail->ErrorInfo}";
            }

        } else {
            echo "<script>alert('Erreur lors de l\'ajout du pharmacien.');</script>";
        }
    } else {
        echo "<script>alert('Le numéro de téléphone existe déjà dans la base de données !');</script>";
    }
} else {
    // Si le rôle est patient
    if($role == 'Pasient'){
        $req3 = mysqli_query($conn, "SELECT * FROM passient WHERE tel = '$tel'");
        if (mysqli_num_rows($req3) == 0) {
            // Insérer les données dans la table 'passient' (pour les patients)
            $req2 = mysqli_query($conn, "INSERT INTO passient (email, tel, passworde, nom, prenom, gender, datee, address1, address2, statee, zip, typee) 
                                        VALUES ('$email', '$tel', '$pass', '$nom', '$prenom', '$gender', '$date', '$address', '$address2', '$state', '$zip', '$role')");
    
            if ($req2) {
    
                echo "<script>alert('$nom ajouté avec succès!')</script>";
                require 'vendor/autoload.php'; // Charge PHPMailer
                $mail = new PHPMailer(true);
    
                try {
                    $mail->isSMTP();
                    $mail->Host = 'smtp.gmail.com';  // Utilisation du serveur SMTP de Gmail
                    $mail->SMTPAuth = true;          // Activation de l'authentification SMTP
                    $mail->Username = 'pharfind@gmail.com';  // Remplacez par votre adresse e-mail Gmail
                    $mail->Password = 'rfqdlvatmnuklgtb';  // Utilisez le mot de passe d'application
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;  // Utilisation de TLS pour sécuriser la connexion
                    $mail->Port = 587;  // Port utilisé par Gmail pour TLS
    
                    // Informations de l'expéditeur et du destinataire
                    $mail->setFrom('pharfind@gmail.com', 'PharmFind');
                    $mail->addAddress($email, $nom);  // Remplacez par l'adresse du pharmacien
    
                    // Contenu de l'e-mail
                    $mail->isHTML(true);
                    $mail->Subject = 'Confirmation d\'inscription';
                    $mail->Body    = "Bonjour " . $nom . ",<br><br>Votre inscription en tant que patient est confirmée.<br> Voici les détails de votre inscription :<br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Téléphone  : &nbsp;&nbsp;$tel<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Password  : &nbsp;&nbsp;  $pass <br><br>Merci de vous être inscrit sur PharmFind.";
    
                    // Envoi de l'e-mail
                    $mail->send();
                    echo "<script>alert('E-mail de confirmation envoyé avec succès !');</script>";
    
                } catch (Exception $e) {
                    echo "Erreur lors de l'envoi de l'e-mail: {$mail->ErrorInfo}";
                }
                echo "<script> window.location.href = 'login.html'; </script>";
            } else {
                echo "<script>alert('Erreur lors de l\'ajout du patient.');</script>";
            }
        } else {
            echo "<script>alert('Le numéro de téléphone existe déjà dans la base de données !');</script>";
        }
    }
    else{
        $req4=mysqli_query($conn, "SELECT * FROM entreprise WHERE tel = '$tel'");
        if (mysqli_num_rows($req4) == 0) {
            // Insérer les données dans la table 'phar' (pour les pharmaciens)
            $id2 = rand(7500, 9999999);
            $req2 = mysqli_query($conn, "INSERT INTO entreprise (id,email, tel, passworde, nom, prenom, gender, datee, address1, address2, statee, zip, typee, nom_de_entreprise) 
                                        VALUES ('$id2','$email', '$tel', '$pass', '$nom', '$prenom', '$gender', '$date', '$address', '$address2', '$state', '$zip', '$role', '$nomphar')");
    
            if ($req2) {
                echo "<script>alert('$nom ajouté avec succès!')</script>";
                $id_pharmacie = mysqli_insert_id($conn);
                // Envoi de l'e-mail de confirmation
                require 'vendor/autoload.php'; // Charge PHPMailer
                $mail = new PHPMailer(true);
    
                try {
                    // Configurer le serveur SMTP
                    $mail->isSMTP();
                    $mail->Host = 'smtp.gmail.com';  // Utilisation du serveur SMTP de Gmail
                    $mail->SMTPAuth = true;          // Activation de l'authentification SMTP
                    $mail->Username = 'pharfind@gmail.com';  // Remplacez par votre adresse e-mail Gmail
                    $mail->Password = 'rfqdlvatmnuklgtb';  // Utilisez le mot de passe d'application
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;  // Utilisation de TLS pour sécuriser la connexion
                    $mail->Port = 587;  // Port utilisé par Gmail pour TLS
    
                    // Informations de l'expéditeur et du destinataire
                    $mail->setFrom('pharfind@gmail.com', 'PharmFind');
                    $mail->addAddress($email, $nom);  // Remplacez par l'adresse du pharmacien
    
                    // Contenu de l'e-mail
                    $mail->isHTML(true);
                    $mail->Subject = 'Confirmation d\'inscription';
                    $mail->Body    = "Bonjour " . $nom  . ",<br><br>Votre inscription en tant que Livrire est confirmée.<br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Identifiant :&nbsp;&nbsp;   $id2 <br><br>Merci de vous être inscrit sur PharmFind.";
                    $mail->AltBody = 'Bonjour ' . $nom . ', Votre inscription en tant que pharmacien est confirmée. Telephone : ' . $tel;
    
                    // Envoi de l'e-mail
                    $mail->send();
                    echo "<script>alert('E-mail de confirmation envoyé avec succès !');</script>";
                    echo "<script> window.location.href = 'login.html'; </script>";
    
                } catch (Exception $e) {
                    echo "Erreur lors de l'envoi de l'e-mail: {$mail->ErrorInfo}";
                }
    
            } else {
                echo "<script>alert('Erreur lors de l\'ajout du livrire.');</script>";
            }
        } else {
            echo "<script>alert('Le numéro de téléphone existe déjà dans la base de données !');</script>";
        }
    }
}

// Fermer la connexion
mysqli_close($conn);
?>
