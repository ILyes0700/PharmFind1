<?php
// Activer l'affichage des erreurs pour le débogage
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Récupérer les données JSON envoyées via AJAX
$data = json_decode(file_get_contents('php://input'), true);

// Vérifier si les données sont valides
if (!$data) {
    echo json_encode(['success' => false, 'error' => 'Données JSON invalides']);
    exit;
}

// Récupérer les informations
$emailPatient = $data['email_patient'];
$medicamentNom = $data['medicament_nom'];
$medicamentQuantite = $data['medicament_quantite'];
$medicamentPrix = $data['medicament_prix'];
$total = $data['total'];
$dateLivraison = $data['date_livraison'];
$pharmacieNom = $data['pharmacie_nom'];
$livreurEmail = $data['livreur_email'];

// Configurer l'email
$subject = "Détails de la livraison";
$message = "
    <h1>Détails de la livraison</h1>
    <p><strong>Nom du médicament:</strong> $medicamentNom</p>
    <p><strong>Quantité:</strong> $medicamentQuantite</p>
    <p><strong>Prix total:</strong> $total</p>
    <p><strong>Date de livraison:</strong> $dateLivraison</p>
    <p><strong>Nom de la pharmacie:</strong> $pharmacieNom</p>
    <p><strong>Livré a :</strong>$emailPatient</p>
";

// En-têtes de l'email
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-Type: text/html; charset=UTF-8" . "\r\n";
$headers .= "From: pharfind@gmail.com" . "\r\n";  // À ajuster avec votre propre email

// Envoyer l'email
$mailSent = mail($livreurEmail, $subject, $message, $headers);

// Vérifier si l'email a été envoyé
if ($mailSent) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'error' => 'Erreur lors de l\'envoi de l\'email']);
}
?>
