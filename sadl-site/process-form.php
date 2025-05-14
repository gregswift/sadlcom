<?php

require 'vendor/autoload.php';
require_once '../config.inc.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_POST['g-recaptcha-response']) && !empty($_POST['g-recaptcha-response'])) {
        $token = $_POST['g-recaptcha-response'];
        error_log('Token: '.$token);
        $url = 'https://recaptchaenterprise.googleapis.com/v1/projects/websites-459715/assessments?key='.$recaptchaAPIKey;
        $data = [
          "event" => [
            "token" => $token,
            "siteKey" => $recaptchaSiteKey,
          ]
        ];

        $options = [
            'http' => [
                'method' => 'POST',
                'header' => 'Content-Type: application/json\r\n',
                'content' => http_build_query($data),
            ]
        ];
        $context = stream_context_create($options);
        $verify = file_get_contents($url, false, $context);
        $captcha_success = json_decode($verify);

        if ($captcha_success->success) {
            $name = $_POST['name'];
            $email = $_POST['email'];
            $message = $_POST['message'];

            $mail = new PHPMailer;

            // $mail->SMTPDebug = 3;                               // Enable verbose debug output

            $mail->isSMTP();                                      // Set mailer to use SMTP
            $mail->Host = $smtpHost;  // Specify main and backup SMTP servers
            $mail->SMTPAuth = true;                               // Enable SMTP authentication
            $mail->Username = $smtpUsername;                 // SMTP username
            $mail->Password = $smtpPassword;                           // SMTP password
            $mail->SMTPSecure = $smtpSecure;                            // Enable TLS encryption, `ssl` also accepted
            $mail->Port = $smtpPort;                                    // TCP port to connect to

            $mail->setFrom($smtpFromAddress, $smtpFromName);
            $mail->addAddress($smtpTarget);     // Add a recipient
            $mail->addReplyTo($email, $name);
            $mail->addBCC($smtpTarget);

            $mail->isHTML(true);                                  // Set email format to HTML

            $mail->Subject = $smtpSubject;
            $mail->Body    = "Name: $name<p />Email: $email<p />Message: $message";
            $mail->AltBody = "Name: $name\nEmail: $email\nMessage: $message";

            if(!$mail->send()) {
                echo 'Message could not be sent.';
                echo 'Mailer Error: ' . $mail->ErrorInfo;
            } else {
                echo 'Message has been sent';
            }

        } else {
            // CAPTCHA is invalid; display an error message.
            echo "reCAPTCHA verification failed.";
        }
    } else {
        echo "Please complete the reCAPTCHA.";
    }
}
?>
