<?php
require("connect.php");  // Inclure le fichier de connexion à la base de données

// Inclure PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';  // Autoload de Composer pour PHPMailer

// Vérification si les informations ont été envoyées via POST
if (isset($_POST['date']) && isset($_POST['id'])) {
    // Récupérer la date de livraison soumise par le formulaire et l'ID de l'entreprise
    $date = $_POST['date'];
    $id = $_POST["id"];

    // Préparer la requête SQL pour obtenir les livraisons de cette date et de l'entreprise
    $sql = "SELECT pharmacie_livraison.id, pharmacie_livraison.email_patient, 
                   pharmacie_livraison.medicament_nom, 
                   pharmacie_livraison.medicament_quantite, 
                   pharmacie_livraison.medicament_prix, 
                   pharmacie_livraison.total, 
                   pharmacie_livraison.datee, 
                   pharmacie_livraison.email_sent,
                   phar.nomphar, 
                   phar.tel, 
                   phar.address1, 
                   phar.address2, 
                   phar.statee, 
                   phar.zip 
            FROM pharmacie_livraison 
            INNER JOIN phar ON pharmacie_livraison.pharmacy_id = phar.id 
            INNER JOIN entreprise ON pharmacie_livraison.entreprise = entreprise.nom_de_entreprise 
            WHERE entreprise.id = '$id' 
            AND pharmacie_livraison.datee = '$date'";

    // Exécuter la requête
    $result = mysqli_query($conn, $sql);
}

// Envoi de l'email lorsque le patient est sélectionné
if (isset($_POST['send_email']) && isset($_POST['email'])) {
$email = $_POST['email'];
$medicamentNom = $_POST['medicament_nom'];
$medicamentQuantite = $_POST['medicament_quantite'];
$medicamentPrix = $_POST['medicament_prix'];
$total = $_POST['total'];
$dateLivraison = $_POST['date_livraison'];
$pharmacieNom = $_POST['pharmacie_nom'];
$livraisonId = $_POST['livraison_id'];
$tellir = $_POST["livreur_" . $livraisonId]; // Notez l'utilisation de la concaténation
$fo="select tel,nom,prenom,address1,address2,statee,zip from passient WHERE email='$email' ";
$res2 = mysqli_query($conn, $fo);
if ($res2 && mysqli_num_rows($res2) > 0) {
    // Récupérer les informations du patient
    $patient = mysqli_fetch_assoc($res2);
    $patientTel = $patient['tel'];
    $patientNom = $patient['nom'];
    $patientPrenom = $patient['prenom'];
    $patientAddress1 = $patient['address1'];
    $patientAddress2 = $patient['address2'];
    $patientStatee = $patient['statee'];
    $patientZip = $patient['zip'];
} else {
    // Si aucune information n'est trouvée, on peut afficher un message d'erreur ou gérer le cas autrement
    $patientNom = "Inconnu";
    $patientPrenom = "Inconnu";
    $patientTel = "Inconnu";
    $patientAddress1 = "Inconnu";
    $patientAddress2 = "Inconnu";
    $patientStatee = "Inconnu";
    $patientZip = "Inconnu";
}
if (isset($_POST['liv_em'])) {
    $livreurEmail = $_POST['liv_em'];
    // Afficher tout dans la console JavaScript
} else {
    //echo "<script>alert('liv_em n\'est pas défini dans la requête POST.');</script>";
}
$livt="select tel FROM entre_liv WHERE email='$livreurEmail'";
$res3=mysqli_query($conn, $livt);
$num1 = mysqli_fetch_assoc($res3);
$nem = $num1['tel'];
    // Vérifier si l'email a déjà été envoyé
$checkEmailSentQuery = "SELECT email_sent FROM pharmacie_livraison WHERE id = '$livraisonId'";
$resultCheck = mysqli_query($conn, $checkEmailSentQuery);
$rowCheck = mysqli_fetch_assoc($resultCheck);

// Si l'email n'a pas encore été envoyé


if ($rowCheck['email_sent'] == 0) {

    // Créer une instance de PHPMailer pour l'email du patient
    $mailPatient = new PHPMailer(true);

    try {

        // Configurer le serveur SMTP pour l'email du patient
        $mailPatient->isSMTP();
        $mailPatient->Host = 'smtp.gmail.com';  // Utilisation du serveur SMTP de Gmail
        $mailPatient->SMTPAuth = true;          // Activation de l'authentification SMTP
        $mailPatient->Username = 'pharfind@gmail.com';  // Remplacez par votre adresse e-mail Gmail
        $mailPatient->Password = 'rfqdlvatmnuklgtb';  // Utilisez le mot de passe d'application
        $mailPatient->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;  // Utilisation de TLS pour sécuriser la connexion
        $mailPatient->Port = 587;  // Port utilisé par Gmail pour TLS

        // Informations de l'expéditeur et du destinataire
        $mailPatient->setFrom('pharfind@gmail.com', 'PharmFind');
        $mailPatient->addAddress($email);  // L'adresse du patient

        // Contenu de l'e-mail avec un joli tableau HTML pour le patient
        $mailPatient->isHTML(true);
        $mailPatient->Subject = 'Confirmation de livraison';

        // Corps du message avec un joli tableau HTML
        $mailPatient->Body = "
<html>
<head>
    <title>Confirmation de Livraison</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Arial, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 90%;
            max-width: 650px;
            background-color: #ffffff;
            margin: 40px auto;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
        }
        h2 {
            font-size: 24px;
            color: #333;
            text-align: center;
            margin-bottom: 20px;
        }
        h3 {
            font-size: 20px;
            color: #4CAF50; /* Green for confirmation */
            margin-top: 30px;
        }
        p {
            font-size: 16px;
            color: #555;
            line-height: 1.6;
        }
        table {
            width: 100%;
            border-spacing: 0;
            margin-top: 20px;
            border-collapse: separate;
        }
        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #4CAF50;
            color: white;
            font-weight: bold;
        }
        tr:last-child td {
            border-bottom: none;
        }
        .highlight {
            background-color: #f1f8f1; /* Soft green highlight for important rows */
        }
        .important {
            background-color: #e8f5e8;
            padding: 12px;
            margin-top: 20px;
            border-left: 4px solid #4CAF50;
            color: #4CAF50;
            font-weight: bold;
        }
        .footer {
            text-align: center;
            font-size: 14px;
            color: #888;
            margin-top: 30px;
        }
        .footer a {
            color: #4CAF50;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class='container'>
        <h2>Confirmation de Livraison</h2>
        <p>Bonjour,</p>
        <p>Nous avons le plaisir de vous informer que votre livraison est prête pour acceptation. Voici les détails de votre livraison :</p>

        <h3>Détails de la Livraison</h3>
        <table>
            <tr>
                <th>Nom du médicament</th>
                <th>Quantité</th>
                <th>Prix Unitaire (d)</th>
                <th>Total (d)</th>
                <th>Date de Livraison</th>
                <th>Nom de la Pharmacie</th>
                <th>Livrée par</th>
            </tr>
            <tr class='highlight'>
                <td>$medicamentNom</td>
                <td>$medicamentQuantite</td>
                <td>$medicamentPrix</td>
                <td>$total</td>
                <td>$dateLivraison</td>
                <td>$pharmacieNom</td>
                <td>$nem</td>
            </tr>
        </table>

        <div class='important'>
            <p>Merci de confirmer votre réception dès que possible.</p>
        </div>

        <p>Nous vous remercions pour votre confiance et restons à votre disposition pour toute information complémentaire.</p>
        <p>Cordialement,</p>
        <p>L'équipe PharmFind</p>

        <p class='footer'>Si vous avez des questions, n'hésitez pas à <a href='mailto:pharfind@gmail.com'>nous contacter</a>.</p>
    </div>
</body>
</html>
";



        // Envoi de l'email au patient
        $mailPatient->send();
        // Créer une instance de PHPMailer pour l'email du livreur
        $mailLivreur = new PHPMailer(true);
        // Configurer le serveur SMTP pour l'email du livreur
        $mailLivreur->isSMTP();
        $mailLivreur->Host = 'smtp.gmail.com';  // Utilisation du serveur SMTP de Gmail
        $mailLivreur->SMTPAuth = true;          // Activation de l'authentification SMTP
        $mailLivreur->Username = 'pharfind@gmail.com';  // Remplacez par votre adresse e-mail Gmail
        $mailLivreur->Password = 'rfqdlvatmnuklgtb';  // Utilisez le mot de passe d'application
        $mailLivreur->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;  // Utilisation de TLS pour sécuriser la connexion
        $mailLivreur->Port = 587;  // Port utilisé par Gmail pour TLS

        // Informations de l'expéditeur et du destinataire
        $mailLivreur->setFrom('pharfind@gmail.com', 'PharmFind');
        $mailLivreur->addAddress($livreurEmail);  // L'adresse du livreur

        // Contenu de l'e-mail avec un joli tableau HTML pour le livreur
        $mailLivreur->isHTML(true);
        $mailLivreur->Subject = 'Confirmation de livraison';

        // Corps du message avec un joli tableau HTML
        $mailLivreur->Body = "
<html>
<head>
    <title>Confirmation de Livraison</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Arial, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 90%;
            max-width: 650px;
            background-color: #ffffff;
            margin: 40px auto;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
        }
        h2 {
            font-size: 24px;
            color: #333;
            text-align: center;
            margin-bottom: 20px;
        }
        h3 {
            font-size: 20px;
            color: #4CAF50; /* Green for confirmation */
            margin-top: 30px;
        }
        p {
            font-size: 16px;
            color: #555;
            line-height: 1.6;
        }
        table {
            width: 100%;
            border-spacing: 0;
            margin-top: 20px;
            border-collapse: separate;
        }
        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #4CAF50;
            color: white;
            font-weight: bold;
        }
        tr:last-child td {
            border-bottom: none;
        }
        .highlight {
            background-color: #f1f8f1; /* Soft green highlight for important rows */
        }
        .important {
            background-color: #ffe9e9;
            padding: 10px;
            margin-top: 20px;
            border-left: 4px solid #f44336;
            color: #f44336;
            font-weight: bold;
        }
        .footer {
            text-align: center;
            font-size: 14px;
            color: #888;
            margin-top: 30px;
        }
        .footer a {
            color: #4CAF50;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class='container'>
        <h2>Confirmation de Livraison</h2>
        <p>Bonjour,</p>
        <p>Nous avons le plaisir de vous confirmer que les détails de votre livraison sont les suivants :</p>

        <h3>Détails de la Livraison</h3>
        <table>
            <tr>
                <th>Nom du médicament</th>
                <th>Quantité</th>
                <th>Prix Unitaire (d)</th>
                <th>Total (d)</th>
                <th>Date de Livraison</th>
                <th>Nom de la Pharmacie</th>
                <th>Livrée à</th>
            </tr>
            <tr class='highlight'>
                <td>$medicamentNom</td>
                <td>$medicamentQuantite</td>
                <td>$medicamentPrix</td>
                <td>$total</td>
                <td>$dateLivraison</td>
                <td>$pharmacieNom</td>
                <td>$email</td>
            </tr>
        </table>

        <h3>Détails du Patient</h3>
        <table>
            <tr>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Téléphone</th>
                <th>Adresse</th>
                <th>Code Postal</th>
                <th>État</th>
            </tr>
            <tr>
                <td>$patientNom</td>
                <td>$patientPrenom</td>
                <td>$patientTel</td>
                <td>$patientAddress1 $patientAddress2</td>
                <td>$patientZip</td>
                <td>$patientStatee</td>
            </tr>
        </table>

        <div class='important'>
            <p>Nous vous encourageons à confirmer la réception de cette livraison dès que possible.</p>
        </div>

        <p>Cordialement,</p>
        <p>L'équipe PharmFind</p>

        <p class='footer'>Pour toute question, <a href='mailto:pharfind@gmail.com'>contactez-nous</a>.</p>
    </div>
</body>
</html>
";


        // Envoi de l'email au livreur
        $mailLivreur->send();

        // Mise à jour du champ email_sent à 1 dans la base de données après les deux envois
        $updateEmailSentQuery = "UPDATE pharmacie_livraison SET email_sent = 1 WHERE id = '$livraisonId'";
        mysqli_query($conn, $updateEmailSentQuery);

       // echo "<script>alert('E-mails de confirmation envoyés avec succès !');</script>";
    } catch (Exception $e) {
        echo "<script>alert('Erreur lors de l\'envoi des e-mails: {$mailPatient->ErrorInfo}');</script>";
    }
} else {
    echo "<script>alert('L\'email a déjà été envoyé pour cette livraison.');</script>";
}
// Récupérer les informations du client à partir de la base de données
// Récupérer les informations du client




}
// Récupérer les livraisons avec email_sent = 1 pour la même date
if (isset($_POST['date']) && isset($_POST['id'])) {
    $date = $_POST['date'];
    $id = $_POST['id'];
    
    $sql_sent = "SELECT pharmacie_livraison.id, pharmacie_livraison.email_patient, 
                        pharmacie_livraison.medicament_nom, 
                        pharmacie_livraison.medicament_quantite, 
                        pharmacie_livraison.medicament_prix, 
                        pharmacie_livraison.total, 
                        pharmacie_livraison.datee, 
                        pharmacie_livraison.email_sent,
                        phar.nomphar, 
                        phar.tel, 
                        phar.address1, 
                        phar.address2, 
                        phar.statee, 
                        phar.zip 
                 FROM pharmacie_livraison 
                 INNER JOIN phar ON pharmacie_livraison.pharmacy_id = phar.id 
                 INNER JOIN entreprise ON pharmacie_livraison.entreprise = entreprise.nom_de_entreprise 
                 WHERE entreprise.id = '$id' 
                 AND pharmacie_livraison.datee = '$date' 
                 AND pharmacie_livraison.email_sent = 1";

    $result_sent = mysqli_query($conn, $sql_sent);
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Kanit:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <title>PharmFind</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <style>
        .container {
            margin-top: 30px;
        }

        .table {
            margin-top: 20px;
        }

        .table th {
            background-color: #4CAF50;
            color: white;
        }

        .sendEmailBtn {
            padding: 8px 12px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 5px;
        }

        .sendEmailBtn:hover {
            background-color: #45a049;
        }
        .declineOrderBtn:hover {
            background-color: rgb(247, 83, 83);
        }
        .declineOrderBtn{
            padding: 8px 12px;
            background-color:rgb(243, 96, 96);
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 5px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .navbar {
            margin-top: -30px;
            
        }

        .navbar-brand {
            color: white;
        }

        .navbar-brand:hover {
            color: #fff;
        }
        .ab{
            display: inline-block;
            padding: 10px 10px;
        }
        .ac{
            display: flex;
            gap: 10px; /* Espacement entre les boutons */
            align-items: center;
        }
        .an{
            color: black;
        }
        .kanit-regular {
  font-family: "Kanit", serif;
  font-weight: 400;
  font-style: normal;
}
            </style>
</head>
<body  class="kanit-regular">
<nav class="navbar navbar-expand-lg" style=" box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);">
  <div class="container">
    <a class="navbar-brand d-flex align-items-center" href="livr.php">
      <img src="i1.png" alt="Logo PharmFind" class="me-2" style="width: 40px; height: 40px;">
      <h3 class="mb-0" style=" color: #002060;">PharmFind</h3>
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" href="ajliv.html" style="color: #75b1da; font-weight: bold; text-transform: uppercase; padding: 8px 15px; border-radius: 5px;">
            <h5 class="mb-0" style="font-size: 18px;">Ajouter Un Livreur</h5>
          </a>
        </li>
      </ul>
    </div>
  </div>
</nav>

<div class="container mt-4">
    <h2>Recherche de Livraisons</h2>

    <!-- Formulaire de soumission de la date et ID de l'entreprise -->
    <form method="POST" action="" class="mb-4">
        <div class="form-group">
            <label for="date">Date de livraison :</label>
            <input type="date" name="date" class="form-control" required>
        </div>
        <div class="form-group mt-3">
            <label for="id">ID de l'entreprise :</label>
            <input type="number" name="id" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary mt-3" style="background-color: #4CAF50; color: white; border: none;">Afficher les Livraisons</button>
    </form>

    <?php if (isset($result)): ?> 
        <h3 class="mt-4">Livraisons à envoyer</h3>
        <table class="table table-striped table-responsive">
            <thead>
                <tr>
                    <th>Email de patient</th>
                    <th>État du patient</th>
                    <th>Adresse du patient</th>
                    <th>Nom du médicament</th>
                    <th>Quantité</th>
                    <th>Prix Total</th>
                    <th>Date de Livraison</th>
                    <th>Nom de la Pharmacie</th>
                    <th>Livraison par</th>
                    <th>Envoyer Email</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                // Récupérer les livreurs une seule fois avant de parcourir les lignes
                $sql_livreurs = "SELECT id, nom, prenom, tel, email FROM entre_liv WHERE id = '$id'";
                $result_livreurs = mysqli_query($conn, $sql_livreurs);
                $livreurs = [];
                while ($livreur = mysqli_fetch_assoc($result_livreurs)) {
                    $livreurs[$livreur['email']] = $livreur; // Utiliser l'email comme clé
                }

                // Boucle sur les livraisons
                while ($row = mysqli_fetch_assoc($result)):  
                    $pasres = mysqli_query($conn, "SELECT statee, address1 FROM passient WHERE email = '" . $row['email_patient'] . "' LIMIT 1");
                    $row2= mysqli_fetch_assoc($pasres);
                    $statee = $row2['statee'];
                    $address1 = $row2['address1'];
                ?>
                    <tr>
                        <td><?= $row['email_patient'] ?></td>
                        <td><?= $statee  ?></td>
                        <td><?=  $address1 ?></td>
                        <td><?= $row['medicament_nom'] ?></td>
                        <td><?= $row['medicament_quantite'] ?></td>
                        <td><?= $row['total'] ?></td>
                        <td><?= $row['datee'] ?></td>
                        <td><?= $row['nomphar'] ?></td>
                        <td>
                            <!-- Sélection du livreur pour cette ligne -->
                            <select name="livreur_<?= $row['id'] ?>" class="form-control">
                                <option value="">Choisir un livreur</option>
                                <?php foreach ($livreurs as $livreur): ?>
                                    <option value="<?= $livreur['email'] ?>"><?= $livreur['prenom'] . " " . $livreur['nom'] . " - Tel: " . $livreur['tel'] . " - Email: " . $livreur['email'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </td>
                        <td class="ac">
                            <?php if ($row['email_sent'] == 0): ?>
                                <button class="sendEmailBtn ab" data-email="<?= $row['email_patient'] ?>" 
                                        data-medicament-nom="<?= $row['medicament_nom'] ?>" 
                                        data-medicament-quantite="<?= $row['medicament_quantite'] ?>" 
                                        data-medicament-prix="<?= $row['medicament_prix'] ?>"
                                        data-total="<?= $row['total'] ?>" 
                                        data-date-livraison="<?= $row['datee'] ?>"
                                        data-pharmacie-nom="<?= $row['nomphar'] ?>" 
                                        data-livraison-id="<?= $row['id'] ?>">Accepter</button>
                                <button class="declineOrderBtn ab" data-email="<?= $row['email_patient'] ?>" 
                                        data-medicament-nom="<?= $row['medicament_nom'] ?>" 
                                        data-medicament-quantite="<?= $row['medicament_quantite'] ?>"
                                        data-pharmacie-nom="<?= $row['nomphar'] ?>"
                                        data-livraison-id="<?= $row['id'] ?>">Réfusée</button>
                            <?php else: ?>
                                <span class="ab">Email déjà envoyé</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php endif; ?>


    <?php if (isset($result_sent)): ?>
        <h3 class="mt-4">Livraisons confirmées (Email envoyé)</h3>
        <table class="table table-striped table-responsive">
            <thead>
                <tr>
                    <th>Email patient</th>
                    <th>Nom du médicament</th>
                    <th>Quantité</th>
                    <th>Prix Total</th>
                    <th>Date de Livraison</th>
                    <th>Nom de la Pharmacie</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result_sent)): ?>
                    <tr>
                        <td><?= $row['email_patient'] ?></td>
                        <td><?= $row['medicament_nom'] ?></td>
                        <td><?= $row['medicament_quantite'] ?></td>
                        <td><?= $row['total'] ?></td>
                        <td><?= $row['datee'] ?></td>
                        <td><?= $row['nomphar'] ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>

    <script>
   document.querySelectorAll('.declineOrderBtn').forEach(button => {
    button.addEventListener('click', function() {
        const email = this.getAttribute('data-email');
        const medicamentNom = this.getAttribute('data-medicament-nom');
        const medicamentQuantite = this.getAttribute('data-medicament-quantite');
        const pharmacieNom = this.getAttribute('data-pharmacie-nom');
        const livraisonId = this.getAttribute('data-livraison-id');  // Id de livraison
        
        // Création de la requête POST pour envoyer l'email
        fetch('decline_order.php', {
            method: 'POST',
            body: new URLSearchParams({
                decline_order: '1',
                email_patient: email,
                medicament_nom: medicamentNom,
                medicament_quantite: medicamentQuantite,
                pharmacie_nom: pharmacieNom,
                livraison_id: livraisonId
            })
        })
        .then(response => response.text())
        .then(data => {
            // Afficher un message à l'utilisateur après la réponse
            //alert('Commande refusée de ' + email + ' (ID: ' + livraisonId + ')');
        })
        .catch(error => {
            console.error('Erreur:', error);
            alert('Une erreur est survenue lors de la demande.');
        });
    });
});

        // Ajouter un événement click à chaque bouton "Envoyer Email"
        document.querySelectorAll('.sendEmailBtn').forEach(button => {
    button.addEventListener('click', function () {
        // Vérifier si les attributs data-* existent avant de les utiliser
        let email = this.getAttribute('data-email');
        let medicamentNom = this.getAttribute('data-medicament-nom');
        let medicamentQuantite = this.getAttribute('data-medicament-quantite');
        let medicamentPrix = this.getAttribute('data-medicament-prix');
        let total = this.getAttribute('data-total');
        let dateLivraison = this.getAttribute('data-date-livraison');
        let pharmacieNom = this.getAttribute('data-pharmacie-nom');
        let tellivr = this.getAttribute('data-tel-liv');
        let livraisonId = this.getAttribute('data-livraison-id');  // Id de livraison

        // Sélectionner le select correspondant au livreur
        const livreurSelect = document.querySelector(`select[name="livreur_${livraisonId}"]`);

        // Vérifier si le select existe et si une valeur est sélectionnée
        const livreurEmail = livreurSelect ? livreurSelect.value : null;

        // Vérifier si toutes les données nécessaires sont présentes
        if (!email || !livreurEmail) {
            alert("Il manque des informations importantes (email ou livreur).");
            return;  // Arrêter l'exécution si une donnée est manquante
        }

        // Créer une requête AJAX pour envoyer l'email
        let xhr = new XMLHttpRequest();
        xhr.open('POST', '', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onload = function () {
            if (xhr.status === 200) {
                //alert('Email envoyé avec succès');
            } else {
                alert('Erreur lors de l\'envoi de l\'email');
            }
        };

        // Envoyer la requête avec les données
        xhr.send('send_email=true' +
         '&email=' + encodeURIComponent(email) +
         '&medicament_nom=' + encodeURIComponent(medicamentNom) +
         '&medicament_quantite=' + encodeURIComponent(medicamentQuantite) +
         '&medicament_prix=' + encodeURIComponent(medicamentPrix) +
         '&total=' + encodeURIComponent(total) +
         '&date_livraison=' + encodeURIComponent(dateLivraison) +
         '&pharmacie_nom=' + encodeURIComponent(pharmacieNom) +
         '&liv_em=' + encodeURIComponent(livreurEmail) +
         '&livraison_id=' + encodeURIComponent(livraisonId));  // envoyer l'id de la livraison
 // envoyer l'id de la livraison
    });
});




    </script>
    <div class="text-center mt-5 mb-0">
    <p class="footer-text mt-5" style="color: #b0b0b0; font-size: 14px; padding-top: 200px;">PharmFind &copy; 2024 | Designed by <strong>Ilyes</strong></p>
</div>
</body>
</html>
