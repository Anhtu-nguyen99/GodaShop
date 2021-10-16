<?php 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
	class ContactController {
		function form() {
			include_once "view/contact/form.php";
		}

		function send() {
			$fullname = $_POST["fullname"];
			$mobile = $_POST["mobile"];
			$email = $_POST["email"];
			$content = $_POST["content"];
			$mail = new PHPMailer(true);                              // Passing `true` enables exceptions
			try {
			    //Server settings
			    $mail->SMTPDebug = 0; // Enable verbose debug output          
			    $mail->isSMTP();   
			    $mail->CharSet  = "utf-8";                                   // Set mailer to use SMTP
			    $mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
			    $mail->SMTPAuth = true;                               // Enable SMTP authentication
			    $mail->Username = "natgeneral99@gmail.com";                 // SMTP username
			    $mail->Password = "uixxevoqlxbmxbby";                           // SMTP password
			    $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
			    $mail->Port = 587;                                    // TCP port to connect to
			 
			    //Recipients
			    $mail->setFrom($email);
			    $mail->addAddress("natgeneral99@gmail.com");     // Add a recipient
			    $mail->addReplyTo($email);

			    $content_sent = "Tên: $fullname<br> Sdt: $mobile <br> Email: $email <br>" . $content;
			    $mail->Body    = $content_sent;
			    $mail->AltBody = $content_sent;
			    $mail->Subject = $fullname . " gởi thông tin liên hệ từ trang " . get_link_site();
			 
			    $mail->send();
			    echo "Đã gởi thành công";
			} catch (Exception $e) {
			    echo $e->getMessage();
			}
		}
	}
?>