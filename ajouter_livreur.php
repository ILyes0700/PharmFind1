<?php
// Connexion à la base de données
include('connect.php');  // Remplace par ton fichier de connexion à la base de données
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Récupération des données du formulaire
    $tel = mysqli_real_escape_string($conn, $_POST['tel']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $nom = mysqli_real_escape_string($conn, $_POST['nom']);
    $prenom = mysqli_real_escape_string($conn, $_POST['prenom']);
    $id = mysqli_real_escape_string($conn, $_POST['id']);

    // Vérifier si l'email existe déjà dans la base de données
    $checkEmail = "SELECT * FROM entre_liv WHERE email='$email'";
    $result = mysqli_query($conn, $checkEmail);

    if (mysqli_num_rows($result) > 0) {
        // Si l'email existe déjà
        echo "<script>alert('Cet email est déjà utilisé.');</script>";
        echo "<script> window.location.href = 'ajliv.html'; </script>";
    } else {
        // Insertion des données dans la base de données
        $query = "INSERT INTO entre_liv (id,tel, email, nom, prenom) VALUES ('$id','$tel', '$email', '$nom', '$prenom')";
        if (mysqli_query($conn, $query)) {
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
        <title>Confirmation d'inscription - Livreur</title>
        <style>
            body {
                font-family: 'Arial', sans-serif;
                background-color: #f8f9fa;
                margin: 0;
                padding: 0;
            }
            .container {
                background-color: #ffffff;
                width: 90%;
                max-width: 650px;
                margin: 40px auto;
                padding: 30px;
                border-radius: 10px;
                box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
            }
            h2 {
                color: #007bff; /* Bleu pour un ton plus professionnel */
                font-size: 24px;
                margin-bottom: 10px;
            }
            p {
                font-size: 16px;
                color: #333333;
                line-height: 1.7;
            }
            .info {
                background-color: #f0f9ff;
                padding: 15px;
                border-left: 5px solid #007bff; /* Bordure bleue pour cohérence */
                margin-top: 25px;
                font-size: 16px;
                border-radius: 5px;
            }
            .footer {
                font-size: 14px;
                text-align: center;
                color: #777777;
                margin-top: 40px;
            }
            .footer a {
                color: #007bff;
                text-decoration: none;
            }
            .footer a:hover {
                text-decoration: underline;
            }
            .button {
                background-color: #007bff;
                color: white;
                padding: 10px 20px;
                border-radius: 5px;
                text-decoration: none;
                font-weight: bold;
                display: inline-block;
                margin-top: 20px;
            }
            .button:hover {
                background-color: #0056b3;
            }
        </style>
    </head>
    <body>
        <div class='container'>
            <h2>Bonjour $nom,</h2>
            <p>Nous avons le plaisir de vous informer que votre inscription en tant que <strong>Livreur</strong> sur <strong>PharmFind</strong> a été confirmée avec succès ! 🎉</p>
            
            <p>Félicitations, vous êtes désormais prêt à rejoindre notre plateforme et à commencer vos livraisons en toute simplicité. Nous sommes heureux de vous compter parmi nous.</p>
            
            <div class='info'>
                <p><strong>Restez connecté, car la livraison sera envoyée par email.</strong></p>
                <p>Nous vous enverrons tous les détails relatifs à vos prochaines livraisons directement par email, y compris les informations sur les commandes à livrer, les horaires, et les adresses. Assurez-vous de vérifier régulièrement votre boîte de réception pour rester à jour !</p>
            </div>
            
            <p>Si vous avez des questions ou besoin d'assistance, notre équipe est à votre disposition pour vous aider.</p>
            
            <p class='footer'>Cordialement,<br>L'équipe <strong>PharmFind</strong></p>
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
            //echo "<script>alert('Le livreur a été ajouté avec succès.');</script>";
            echo "<script> window.location.href = 'ajliv.html'; </script>";
        } else {
            //echo "<script>alert('Erreur lors de l\'ajout du livreur : " . mysqli_error($conn) . "');</script>";
            echo "<script> window.location.href = 'ajliv.html'; </script>";
        }
    }
}
?>

<!-- Tu peux rediriger l'utilisateur vers une autre page après insertion ou afficher un message de succès -->
