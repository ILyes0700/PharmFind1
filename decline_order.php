<?php
require("connect.php");
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'vendor/autoload.php';  // Assurez-vous que PHPMailer est bien installé via Composer

if (isset($_POST['decline_order'])) {
    // Récupération des données envoyées dans la requête POST
    $emailPatient = $_POST['email_patient'];
    $medicamentNom = $_POST['medicament_nom'];
    $medicamentQuantite = $_POST['medicament_quantite'];
    $pharmacieNom = $_POST['pharmacie_nom'];
    
    // Validation de l'ID de la livraison
    $livid = $_POST['livraison_id'];
    // Sécurisation de la requête SQL pour supprimer la livraison
    $mailPatient = new PHPMailer(true);

    try {
        // Configuration de PHPMailer pour utiliser SMTP
        $mailPatient->isSMTP();
        $mailPatient->Host = 'smtp.gmail.com'; // Utilisation du serveur SMTP de Gmail
        $mailPatient->SMTPAuth = true;
        $mailPatient->Username = 'pharfind@gmail.com';  // Votre adresse email Gmail
        $mailPatient->Password = 'rfqdlvatmnuklgtb';  // Utilisez un mot de passe d'application sécurisé
        $mailPatient->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mailPatient->Port = 587;

        // Définir l'expéditeur et le destinataire
        $mailPatient->setFrom('pharfind@gmail.com', 'PharmFind');
        $mailPatient->addAddress($emailPatient);  // L'adresse email du patient

        // Configuration de l'email HTML
        $mailPatient->isHTML(true);
        $mailPatient->Subject = 'Desole, commande non disponible aujourd\'hui';
        $req="DELETE FROM `pharmacie_livraison` WHERE id='$livid'";
        mysqli_query($conn, $req);

        // Corps du message avec les détails du refus
        $mailPatient->Body = "
        <html>
        <head>
            <title>Commande Non Disponible</title>
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
                h3 {
                    color: #e74c3c; /* Rouge pour l'urgence */
                }
                p {
                    font-size: 16px;
                    color: #333333;
                    line-height: 1.6;
                }
                .important {
                    background-color: #f8d7da; /* Rouge pâle pour l'alerte */
                    padding: 10px;
                    border-left: 4px solid #e74c3c;
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
                <h3>Bonjour,</h3>
                <p>Nous sommes désolés,</p>
                <p>Malheureusement, la livraison de votre commande pour le médicament <strong>$medicamentNom</strong> (quantité : $medicamentQuantite) n'est pas disponible aujourd'hui.</p>
                
                <div class='important'>
                    <p>Nous vous prions de bien vouloir choisir une autre date de livraison ou une autre option de livraison pour recevoir votre commande dans les plus brefs délais.</p>
                </div>
    
                <p>Nous vous remercions pour votre compréhension et restons à votre disposition pour toute information complémentaire.</p>
                <p>Cordialement,</p>
                <p>L'équipe PharmFind</p>
    
                <p class='footer'>Si vous avez des questions, n'hésitez pas à nous contacter.</p>
            </div>
        </body>
        </html>
    ";
    


        // Envoi de l'email
        $mailPatient->send();
        //echo 'Message a été envoyé avec succès.';
    } catch (Exception $e) {
        echo "L'email n'a pas pu être envoyé. Erreur du Mailer: {$mailPatient->ErrorInfo}";
    }
} else {
    echo 'Aucune requête de refus de commande reçue.';
}
?>
