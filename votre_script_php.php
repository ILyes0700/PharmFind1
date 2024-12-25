<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';  // Assurez-vous que PHPMailer est bien installé via Composer

if (isset($_POST['decline_order'])) {
    // Récupération des données envoyées dans la requête POST
    $emailPatient = $_POST['email_patient'];
    $medicamentNom = $_POST['medicament_nom'];
    $medicamentQuantite = $_POST['medicament_quantite'];
    $pharmacieNom = $_POST['pharmacie_nom'];

    // Initialisation de PHPMailer
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
        $mailPatient->Subject = 'Désolé, commande non disponible aujourd\'hui';

        // Corps du message avec les détails du refus
        $mailPatient->Body = "
            <html>
            <head>
                <title>Commande Non Disponible</title>
            </head>
            <body>
                <h2>Bonjour,</h2>
                <p>Nous sommes désolés, mais la livraison de votre commande pour le médicament <strong>$medicamentNom</strong> (quantité: $medicamentQuantite) n'est pas disponible aujourd'hui.</p>
                <p>Nous vous prions de nous excuser pour ce désagrément. Nous vous contacterons dès que nous serons en mesure de vous fournir votre commande.</p>
                <p>Merci de votre compréhension.</p>
                <p>Cordialement,</p>
                <p>L'équipe PharmFind</p>
            </body>
            </html>
        ";

        // Envoi de l'email
        $mailPatient->send();
        echo 'Message a été envoyé avec succès.';
    } catch (Exception $e) {
        echo "L'email n'a pas pu être envoyé. Erreur du Mailer: {$mailPatient->ErrorInfo}";
    }
} else {
    echo 'Aucune requête de refus de commande reçue.';
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Refus de Commande</title>
</head>
<body>
    <h2>Confirmation du Refus de Commande</h2>
    <p>Un e-mail a été envoyé au patient pour lui indiquer que la commande n'est pas disponible aujourd'hui.</p>
    <a href="index.php">Retour à la page d'accueil</a>
</body>
</html>
