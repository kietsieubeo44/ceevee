<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Load PHPMailer classes
require 'vendor/autoload.php';

// Replace with your email address
$siteOwnersEmail = 'kietsieubeo44@gmail.com';

if ($_POST) {
    // Sanitize and validate form inputs
    $name = trim(stripslashes($_POST['contactName']));
    $email = trim(stripslashes($_POST['contactEmail']));
    $subject = trim(stripslashes($_POST['contactSubject']));
    $contact_message = trim(stripslashes($_POST['contactMessage']));

    // Initialize an array to hold errors
    $error = [];

    // Validate Name
    if (strlen($name) < 2) {
        $error['name'] = "Vui lòng nhập tên của bạn.";
    }

    // Validate Email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error['email'] = "Vui lòng nhập một địa chỉ email hợp lệ.";
    }

    // Validate Message
    if (strlen($contact_message) < 15) {
        $error['message'] = "Vui lòng nhập tin nhắn của bạn. Tin nhắn phải có ít nhất 15 ký tự.";
    }

    // Default Subject if empty
    if (empty($subject)) {
        $subject = "Thư Gửi Từ Biểu Mẫu Liên Hệ";
    }

    // If no errors, proceed with email sending
    if (empty($error)) {
        try {
            // Create a new PHPMailer instance
            $mail = new PHPMailer(true);

            // Server settings
            $mail->isSMTP();
            $mail->Host = 'smtp.example.com'; // Specify main and backup SMTP servers
            $mail->SMTPAuth = true;           // Enable SMTP authentication
            $mail->Username = 'your_smtp_username'; // SMTP username
            $mail->Password = 'your_smtp_password'; // SMTP password
            $mail->SMTPSecure = 'tls';        // Enable TLS encryption, `ssl` is also accepted
            $mail->Port = 587;                // TCP port to connect to

            // Recipients
            $mail->setFrom($email, $name);
            $mail->addAddress($siteOwnersEmail); // Add a recipient

            // Content
            $mail->isHTML(true); // Set email format to HTML
            $mail->Subject = $subject;
            $mail->Body    = "Email từ: $name <br />Địa chỉ email: $email <br />Tin nhắn: <br />$contact_message <br /> ----- <br /> Thư này được gửi từ biểu mẫu liên hệ trên trang web của bạn.";

            // Send the email
            $mail->send();
            echo "OK"; // Email sent successfully
        } catch (Exception $e) {
            echo "Không thể gửi tin nhắn. Lỗi Mailer: {$mail->ErrorInfo}";
        }
    } else {
        // Output errors
        foreach ($error as $err) {
            echo $err . "<br />\n";
        }
    }
}
?>
