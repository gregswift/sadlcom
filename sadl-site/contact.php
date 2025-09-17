<?php
require_once '../config.inc.php';
require 'PHPMailerAutoload.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['g-recaptcha-response']) && !empty($_POST['g-recaptcha-response'])) {
        $token = $_POST['g-recaptcha-response'];
        $url = 'https://www.google.com/recaptcha/api/siteverify';
        $data = array(
            'secret' => $secretKey,
            'response' => $token,
            'remoteip' => $_SERVER['REMOTE_ADDR']
        );

        $options = array(
            'http' => array(
                'method' => 'POST',
                'content' => http_build_query($data)
            )
        );
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
            $mail->Host = 'your_smtp_host';  // Specify main and backup SMTP servers
            $mail->SMTPAuth = true;                               // Enable SMTP authentication
            $mail->Username = 'your_smtp_username';                 // SMTP username
            $mail->Password = 'your_smtp_password';                           // SMTP password
            $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
            $mail->Port = 587;                                    // TCP port to connect to

            $mail->setFrom('from@example.com', 'Mailer');
            $mail->addAddress('recipient@example.com', 'Joe User');     // Add a recipient
            // $mail->addAddress('ellen@example.com');               // Name is optional
            // $mail->addReplyTo('info@example.com', 'Information');
            // $mail->addCC('cc@example.com');
            // $mail->addBCC('bcc@example.com');

            // $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
            // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
            $mail->isHTML(true);                                  // Set email format to HTML

            $mail->Subject = 'Contact Form Submission';
            $mail->Body    = "Name: $name<br>Email: $email<br>Message: $message";
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
<!DOCTYPE html>
<html lang="en-US">

  <head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Contact Us</title>
    <meta name="description" content="" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="styles/main.css" />
    <link rel="stylesheet" href="styles/contact.css" />
    <link rel="stylesheet"
      href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0&icon_names=help,person,home,article,call" />
    <style>
      @import url("https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap");
    </style>
    <script src="https://www.google.com/recaptcha/enterprise.js?render=<?php print $recaptchaSiteKey; ?>"></script>
    <script>
      document.addEventListener("DOMContentLoaded", function() {
        const form = document.getElementById("client-form");
        const submitButton = document.querySelector(".form-btn");
        
        submitButton.addEventListener("click", function(event) {
          event.preventDefault(); 
         
          grecaptcha.ready(function() {
            grecaptcha
              .execute("<?php echo $siteKey; ?>", {
                action: "submit"
              })
              .then(function(token) {
                document.getElementById("g-recaptcha-response").value = token;
                form.submit(); 
              });
          });
        });
      });
    </script>
  </head>

  <body>
    <a href="#main-content" class="skip-link">Skip to main content</a>
    <?php include 'navigation.php'; ?>
    <div class="page-title-container">
      <h1 class="page-title-header">Contact Us</h1>
    </div>
    <main id="main-content">
      <div class="contact-us-container">
      <div class="address-section">
        <p class="address-line-1">1150 N Loop 1604 W, #108-420</p>
        <p class="address-line-2">San Antonio, TX 78248</p>
        <iframe class="google-map"
          src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3468.9107765654076!2d-98.5128077237558!3d29.606279875147237!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x865c618a479d9bb3%3A0x31a63bb17742b178!2s1150%20N%20Loop%201604%20W%20108%20420%2C%20San%20Antonio%2C%20TX%2078248!5e0!3m2!1sen!2sus!4v1727231668222!5m2!1sen!2sus"
          width="346" height="300"></iframe>
      </div>
      <form id="client-form" method="post">
          <label class="label-header" for="name">Your Name: (required)</label>
          <input type="text" id="name" name="name" aria-required="true" required />
          <span class="error" id="name-error" aria-live="polite"></span>

          <label class="label-header" for="email">
            Your Email: (required)
          </label>
          <input type="email" id="email" name="email" aria-required="true" required />

          <label class="label-header" for="subject-line">Subject</label>
          <input type="text" id="subject-line" name="subject"/>

          <label class="label-header" for="message">Your Message</label>
          <textarea  name="message" id="message" rows="10" cols="50"></textarea>

          <button class="g-recaptcha" data-sitekey="<?php print $recaptchaSiteKey; ?>" data-callback="onSubmit" data-action="submit" type="submit">
            Send
          </button>
          <?php if ($recaptcha_success): ?>
              <div class="success-message">Form submitted successfully!</div>
          <?php endif; ?>
      </form>
      </div>
    </main>
    <?php include "footer.php" ?>
  </body>

</html>
