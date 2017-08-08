<?php

namespace MyApiCore\System;

use Monolog\Logger as Logger;
use Monolog\Handler\StreamHandler as StreamHandler;
/**
 * class EmailLogger
 * @package Design_Patterns\Strategy
 */
class EmailLogger implements ILogger
{
	/**
	 * @var Logger
	 */
	protected $logger;
	/**
	 * EmailLogger constructor.
	 */
	public function __construct()
	{
		$this->logger = new Logger('mail_logger');
		$this->logger->pushHandler(new StreamHandler('../logs.log', Logger::WARNING));
	}
	/**
	 * Send logging message as an email
	 *
	 * @param string $data
	 * @return void
	 */
	public function log(string $data)
	{
		try {

			$mail = new PHPMailer;

//$mail->SMTPDebug = 3;                               // Enable verbose debug output

			$mail->isSMTP();                                      // Set mailer to use SMTP
			$mail->Host = 'smtp1.example.com;smtp2.example.com';  // Specify main and backup SMTP servers
			$mail->SMTPAuth = true;                               // Enable SMTP authentication
			$mail->Username = 'user@example.com';                 // SMTP username
			$mail->Password = 'secret';                           // SMTP password
			$mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
			$mail->Port = 587;                                    // TCP port to connect to

			$mail->setFrom('errorlog@example.com', 'Mailer');
			$mail->addAddress('joe@example.net', 'Joe User');     // Add a recipient
			$mail->addReplyTo('info@example.com', 'Information');
			$mail->addCC('cc@example.com');
			$mail->addBCC('bcc@example.com');

			$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
			$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
			$mail->isHTML(true);                                  // Set email format to HTML

			$mail->Subject = 'Here is the subject';
			$mail->Body    = 'This is the HTML message body <b>in bold!</b>';
			$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

			if(!$mail->send()) {
				echo 'Message could not be sent.';
				echo 'Mailer Error: ' . $mail->ErrorInfo;
			} else {
				echo 'Message has been sent';
			}


			$to = 'Admin <dre.board@gmail.com>';
			$subject = 'Site Error Log';
			$message = $data;
			$headers = 'From: webmaster@example.com' . "\r\n" .
			           'Reply-To: webmaster@example.com' . "\r\n" .
			           'X-Mailer: PHP/' . phpversion();
			mail($to, $subject, $message, $headers);
		} catch (\Throwable $e) {
			$this->logger->error($e->getMessage());
		}
	}
}