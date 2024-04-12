<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Tải các lớp của PHPMailer
require 'vendor/autoload.php';

// Thay thế địa chỉ email của bạn vào đây
$siteOwnersEmail = 'kietsieubeo44@gmail.com';

if($_POST) {
    $name = trim(stripslashes($_POST['contactName']));
    $email = trim(stripslashes($_POST['contactEmail']));
    $subject = trim(stripslashes($_POST['contactSubject']));
    $contact_message = trim(stripslashes($_POST['contactMessage']));

    // Kiểm tra Tên
    if (strlen($name) < 2) {
        $error['name'] = "Vui lòng nhập tên của bạn.";
    }
    // Kiểm tra Email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error['email'] = "Vui lòng nhập một địa chỉ email hợp lệ.";
    }
    // Kiểm tra Tin nhắn
    if (strlen($contact_message) < 15) {
        $error['message'] = "Vui lòng nhập tin nhắn của bạn. Tin nhắn phải có ít nhất 15 ký tự.";
    }
    // Chủ đề
    if ($subject == '') { $subject = "Thư Gửi Từ Biểu Mẫu Liên Hệ"; }

    if (!isset($error)) {
        try {
            // Tạo một phiên bản mới của PHPMailer
            $mail = new PHPMailer(true);

            // Cài đặt mailer để sử dụng SMTP
            $mail->isSMTP();

            // Cài đặt SMTP
            $mail->Host       = 'smtp.example.com'; // Chỉ định máy chủ SMTP chính và phụ
            $mail->SMTPAuth   = true; // Bật xác thực SMTP
            $mail->Username   = 'your_smtp_username'; // Tên người dùng SMTP
            $mail->Password   = 'your_smtp_password'; // Mật khẩu SMTP
            $mail->SMTPSecure = 'tls'; // Bật mã hóa TLS, `ssl` cũng được chấp nhận
            $mail->Port       = 587; // Cổng TCP để kết nối

            // Người nhận
            $mail->setFrom($email, $name);
            $mail->addAddress($siteOwnersEmail); // Thêm một người nhận

            // Nội dung
            $mail->isHTML(true); // Đặt định dạng email là HTML
            $mail->Subject = $subject;
            $mail->Body    = "Email từ: $name <br />Địa chỉ email: $email <br />Tin nhắn: <br />$contact_message <br /> ----- <br /> Thư này được gửi từ biểu mẫu liên hệ trên trang web của bạn.";

            // Gửi email
            $mail->send();
            
            echo "OK"; // Email gửi thành công
        } catch (Exception $e) {
            echo "Không thể gửi tin nhắn. Lỗi Mailer: {$mail->ErrorInfo}";
        }
    } else {
        $response = isset($error['name']) ? $error['name'] . "<br /> \n" : '';
        $response .= isset($error['email']) ? $error['email'] . "<br /> \n" : '';
        $response .= isset($error['message']) ? $error['message'] . "<br />" : '';
        echo $response;
    }
}
?>
