<?php
require '/opt/webstack/vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;

$mail = new PHPMailer(true);
try {
    $mail->isSMTP();
    $mail->Host       = 'smtp.mailgun.org';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'scanner@mailgun.ktp.digital';   // <-- Your Mailgun SMTP user
    $mail->Password   = 'ScanMePlease888';               // <-- Your Mailgun SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;  // Use constant
    $mail->Port       = 587;

    $mail->setFrom('info@ktp.digital', 'KTP Digital Info'); // <-- Any verified sender on your Mailgun domain
    $mail->addAddress('leads@ktp.digital');                 // Or your real/personal email

    $mail->Subject = 'Test Email from PHPMailer via Mailgun';
    $mail->Body    = 'This is a test email sent using PHPMailer and Mailgun SMTP.';

    $mail->SMTPDebug = 2;        // Enable for troubleshooting
    $mail->Debugoutput = 'html'; // Format debug output as HTML

    $mail->send();
    echo "Message sent!\n";
} catch (Exception $e) {
    echo "Mailer Error: {$mail->ErrorInfo}\n";
}
