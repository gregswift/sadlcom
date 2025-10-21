<?php
//Load the site's config data
require_once '../sadlcom-config.inc.php';
// Above load provides:
// - $recaptchaAPIKey
// - $recaptchaSiteKey
// - $smtpHost
// - $smtpPort
// - $smtpUsername
// - $smtpPassword
// - $smtpSecure
// - $smtpFromName
// - $smtpSubjectPrefix

//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader (created by composer, not included with PHPMailer)
require 'vendor/autoload.php';

$form_message       = '';
$form_message_class = '';

$FAILURE_CLASS = 'failure-message';
$SUCCESS_CLASS = 'success-message';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $token = $_POST['g-recaptcha-response'] ?? '';

  if (!$token) {
    $form_message       = 'Please complete the reCAPTCHA.';
    $form_message_class = $FAILURE_CLASS;
  } else {
    $verifyURL = 'https://www.google.com/recaptcha/api/siteverify';

    $data = [
      'secret'   => $secretKey,
      'response' => $token,
      'remoteip' => $_SERVER['REMOTE_ADDR'],
    ];

    $options = [
      'http' => [
        'content' => http_build_query($data),
        'header'  => 'Content-Type: application/x-www-form-urlencoded',
        'method'  => 'POST',
        'timeout' => 10
      ],
    ];

    $context = stream_context_create($options);
    $verify  = file_get_contents($verifyURL, false, $context);

    if ($verify === false) {
      $form_message       = 'Verification service is unavailable. Please try again.';
      $form_message_class = $FAILURE_CLASS;
    } else {
      $res = json_decode($verify, true);

      error_log("reCAPTCHA verification response: " . print_r($res, true));

      // set defaults for the the v3 return object
      $isVerified = $res['success'] ?? false;
      $action     = $res['action'] ?? '';
      $score      = $res['score'] ?? 0;
      $host       = $res['hostname'] ?? '';

      if ($isVerified && $action == 'submit' && $score >= 0.5){
        $name    = trim($_POST['name'] ?? '');
        $email   = trim($_POST['email'] ?? '');
        $subject = trim($_POST['subject'] ?? 'Contact Form Submission');
        $message = trim($_POST['message'] ?? '');

        $mail = new PHPMailer;

        $mail->isSMTP();
        $mail->Host       = $smtpHost;
        $mail->SMTPAuth   = true;
        $mail->Username   = $smtpUsername;
        $mail->Password   = $smtpPassword;
        $mail->SMTPSecure = $smtpSecure;
        $mail->Port       = $smtpPort;

        $mail->setFrom($smtpUsername, $smtpFromName);
        $mail->addAddress($smtpTarget);

        $mail->Subject = $smtpSubjectPrefix . $subject;
        $mail->Body    = "Name: $name<br />Email: $email<br />Message:<br />$message";
        $mail->AltBody = "Name: $name\nEmail: $email\nMessage:\n$message";

        if(!$mail->send()) {
            $form_message       = 'Message could not be sent.<br />';
            $form_message      .= 'Mailer Error: ' . $mail->ErrorInfo;
            $form_message_class = $FAILURE_CLASS;
          } else {
             $form_message       = 'Message has been sent';
             $form_message_class = $SUCCESS_CLASS;
          }

      } else {
          $form_message       = 'reCAPTCHA score too low. Please try again.';
          $form_message_class = $FAILURE_CLASS;
      }
    }
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
      href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0&icon_names=article,call,help,home,person" />
    <style>
      @import url("https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap");
    </style>
    <script src="https://www.google.com/recaptcha/api.js?render=<?php echo urlencode($recaptchaSiteKey); ?>" async="" defer="" />
    <script>
function handleSubmit(e) {
  e.preventDefault();
  grecaptcha.ready(function() {
    grecaptcha.execute($recaptchaSiteKey, {action: 'submit'}).then(function(token) {
      document.getElementById('g-recaptcha-response').value = token;
      e.target.submit();
    });
  });
}
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
      <div>
<?php
if ($form_message){
  echo "        <div class=\"{$form_message_class}\">{$form_message}</div>";
}
?>
        <form id="client-form" method="post" action="contact.php" onsubmit="handleSubmit(event)">
          <label class="label-header" for="name">Your Name: (required)</label>
          <input type="text" id="name" name="name" aria-required="true" autocomplete="name" required />
          <span class="error" id="name-error" aria-live="polite"></span>

          <label class="label-header" for="email">Your Email: (required)</label>
          <input type="email" id="email" name="email" aria-required="true" autocomplete="email" required />

          <label class="label-header" for="subject-line">Subject</label>
          <input type="text" id="subject-line" name="subject"/>

          <label class="label-header" for="message">Your Message</label>
          <textarea  name="message" id="message" rows="10" cols="50"></textarea>

          <input type="hidden" id="g-recaptcha-response" name="g-recaptcha-response">

          <button class="g-recaptcha" id="submit-btn" type="submit">Send</button>
        </form>
      </div>
    </main>
  </body>
<?php include "footer.php" ?>
</html>
