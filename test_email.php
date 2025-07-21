<?php
$to = "sussiif37@gmail.com";
$subject = "Test d'envoi de mail depuis XAMPP";
$message = "Bonjour ! Ceci est un test envoyé depuis mon projet PHP.";
$headers = "From: sussiif37@gmail.com";

if (mail($to, $subject, $message, $headers)) {
    echo "✅ Email envoyé avec succès.";
} else {
    echo "❌ Échec de l'envoi.";
}
?>
