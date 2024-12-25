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
$gender = $_POST['check1'];
 // Genre (Homme ou Femme)

// Vérifier la connexion à la base de données
if (!$conn) {
    die("Connexion échouée : " . mysqli_connect_error());
}

// Vérifier si le numéro de téléphone existe déjà dans la table phar
        $req3 = mysqli_query($conn, "SELECT * FROM passient WHERE tel = '$tel'");
        if (mysqli_num_rows($req3) == 0) {
            // Insérer les données dans la table 'passient' (pour les patients)
            $req2 = mysqli_query($conn, "INSERT INTO passient (email, tel, passworde, nom, prenom, gender, datee, address1, address2, statee, zip, typee) 
                                        VALUES ('$email', '$tel', '$pass', '$nom', '$prenom', '$gender', '$date', '$address', '$address2', '$state', '$zip', 'Passient')");
    
            if ($req2) {
    
                //echo "<script>alert('$nom ajouté avec succès!')</script>";
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
                    $mail->Body = "
    <html>
    <head>
        <title>Confirmation d'inscription - Patient</title>
        <style>
            body {
                font-family: Arial, sans-serif;
                background-color: #f4f4f4;
                margin: 0;
                padding: 0;
            }
            .container {
                background-color: #ffffff;
                width: 80%;
                max-width: 600px;
                margin: 30px auto;
                padding: 20px;
                border-radius: 8px;
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            }
            h2 {
                color: #8a70a5; /* Vert pour le patient */
            }
            p {
                font-size: 16px;
                color: #333333;
                line-height: 1.6;
            }
            .info {
                background-color: #f0f0f0;
                padding: 10px;
                border-left: 4px solid #8a70a5; /* Bordure verte pour patient */
                margin-top: 20px;
                font-size: 16px;
            }
            .footer {
                font-size: 14px;
                text-align: center;
                color: #777777;
                margin-top: 30px;
            }
        </style>
    </head>
    <body>
        <div class='container'>
            <h2>Bonjour $nom,</h2>
            <p>Votre inscription en tant que patient sur <strong>PharmFind</strong> a été confirmée avec succès.</p>
            <p>Voici les détails de votre inscription :</p>
            
            <div class='info'>
                <strong>Téléphone :</strong> $tel <br>
                <strong>Mot de passe :</strong> $pass
            </div>
            
            <p>Nous vous remercions de vous être inscrit sur PharmFind. Vous êtes maintenant prêt à utiliser nos services.</p>
            <p>Si vous avez des questions ou besoin d'assistance, n'hésitez pas à nous contacter.</p>
            
            <p class='footer'>Cordialement,<br>L'équipe PharmFind</p>
        </div>
    </body>
    </html>
";

    
                    // Envoi de l'e-mail
                    $mail->send();
                    //echo "<script>alert('E-mail de confirmation envoyé avec succès !');</script>";
    
                } catch (Exception $e) {
                    echo "Erreur lors de l'envoi de l'e-mail: {$mail->ErrorInfo}";
                }
                echo "<script> window.location.href = 'logvis.html'; </script>";
            } else {
                //echo "<script>alert('Erreur lors de l\'ajout du patient.');</script>";
            }
        }
         else {
            echo "<script>alert('Le numéro de téléphone existe déjà dans la base de données !');</script>";
        }
    

// Fermer la connexion
mysqli_close($conn);
?>
