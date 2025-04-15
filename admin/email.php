<?php
// email.php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php'; // Ensure Composer's autoloader is included



function sendEmail($to, $subject, $message) {
    $mail = new PHPMailer(true);
    
    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com'; // Set your SMTP server
        $mail->SMTPAuth   = true;
        $mail->Username   = 'gaganshriwas5@gmail.com'; // SMTP username
        $mail->Password   = 'csiczfntjofbkcjy'; // SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Enable TLS encryption
        $mail->Port       = 587; // TCP port to connect to

        // Recipients
        $mail->setFrom('gaganshriwas5@gmail.com.com', 'LearnToCode');
        $mail->addAddress($to);

        // Content
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = $message;

        $mail->send();
        return true;
    } catch (Exception $e) {
        return false;
    }
}



// New function to send notification emails
function sendNotificationEmail($userEmail, $notificationMessage) {
    $subject = "New Notification from LearnToCode";
    
	// Constructing the HTML message body
	$message = "<h1>You have a new notification!</h1>";
	$message .= "<p>$notificationMessage</p>"; 

	return sendEmail($userEmail, $subject, nl2br($message));
}

?>


