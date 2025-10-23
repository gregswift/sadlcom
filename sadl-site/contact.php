<?php
// Page specific data
$pageTitle = 'Contact Us';

//Load the site's config data
require_once '../sadlcom-config.inc.php';

//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader (created by composer, not included with PHPMailer)
require 'vendor/autoload.php';

$form_message       = '';
$form_message_class = '';

$FAILURE_MESSAGE_VERIFY = 'Verification failed. Please try again later or call me!';
$FAILURE_MESSAGE_MAIL   = 'Message could not be sent. Please try again later or call me!';

$FAILURE_CLASS  = 'failure-message';
$SUCCESS_CLASS = 'success-message';

// reCAPTCHA Enterprise Verification via Assessment API using cURL
function verifyRecaptchaEnterprise($projectId, $apiKey, $siteKey, $token, $expectedAction) {
    $url       = "https://recaptchaenterprise.googleapis.com/v1/projects/{$projectId}/assessments?key={$apiKey}";

    $payload = [
        "event" => [
            "token" => $token,
            "siteKey" => $siteKey,
            "expectedAction" => $expectedAction
        ]
    ];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [ 'Content-Type: application/json' ]);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);

    $response = curl_exec($ch);

    if (curl_errno($ch)) {
        //error_log("reCAPTCHA Enterprise: cURL error: " . curl_error($ch));
        curl_close($ch);
        return false;
    }

    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($httpCode !== 200) {
        error_log("reCAPTCHA Enterprise: HTTP {$httpCode} response: {$response}");
        return false;
    }

    $result = json_decode($response, true);
    //error_log("reCAPTCHA Enterprise raw response: " . print_r($result, true));

    // Validation logic
    $risk = $result['riskAnalysis'] ?? [];
    $score = $risk['score'] ?? 0;
    $action = $result['event']['expectedAction'] ?? '';
    $reasons = implode(', ', $risk['reasons'] ?? []);

    if ($score >= 0.5 && $action === $expectedAction) {
        return true;
    } else {
        error_log("reCAPTCHA Enterprise failed: score={$score}, reasons={$reasons}");
        return false;
    }
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $token = $_POST['g-recaptcha-response'] ?? '';
    if (empty($token)) {
        error_log("reCAPTCHA Enterprise: No token in POST");
        $form_message       = $FAILURE_MESSAGE_VERIFY;
        $form_message_class = $FAILURE_CLASS;
    } else {
        $verified = verifyRecaptchaEnterprise($googleProjectID, $recaptchaAPIKey, $recaptchaSiteKey, $token, "submit");
        if ($verified === false) {
            $form_message       = $FAILURE_MESSAGE_VERIFY;
            $form_message_class = $FAILURE_CLASS;
        } else {
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

            $mail->Subject = $smtpSubjectPrefix . " " . $subject;
            $mail->Body    = "Name: $name<br />Email: $email<br />Message:<br />$message";
            $mail->AltBody = "Name: $name\nEmail: $email\nMessage:\n$message";

            if(!$mail->send()) {
                $form_message       = $FAILURE_MESSAGE_MAIL;
                error_log('Mailer Error: ' . $mail->ErrorInfo);
                $form_message_class = $FAILURE_CLASS;
            } else {
                $form_message       = 'Message has been sent';
                $form_message_class = $SUCCESS_CLASS;
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en-US">
<head>
<?php include 'head.inc.php'; ?>
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0&icon_names=article,call,help,home,person" />
<style>
  @import url("https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap");
</style>
<script src="https://www.google.com/recaptcha/enterprise.js?render=<?php echo urlencode($recaptchaSiteKey); ?>" async="" defer=""></script>
<script>
document.addEventListener("DOMContentLoaded", function() {
  const form = document.getElementById("contact-form");
  const tokenField = document.getElementById("g-recaptcha-response");

  if (!form) {
    console.error("[reCAPTCHA DEBUG] Form with ID 'contact-form' not found!");
    return;
  } else {
    console.log("[reCAPTCHA DEBUG] Form element found:", !!form);
  }
  console.log("[reCAPTCHA DEBUG] Hidden token field found:", !!tokenField);

  form.addEventListener("submit", function(e) {
    e.preventDefault(); // stop form from submitting right away

    console.log("[reCAPTCHA DEBUG] Submit event triggered");
    console.log("[reCAPTCHA DEBUG] grecaptcha object:", typeof grecaptcha);

    if (typeof grecaptcha === "undefined") {
      console.error("[reCAPTCHA DEBUG] grecaptcha is undefined — reCAPTCHA script failed to load!");
      alert("reCAPTCHA script did not load. Check your site key and script URL.");
      return;
    }

    grecaptcha.enterprise.ready(function() {
      console.log("[reCAPTCHA DEBUG] grecaptcha.ready() called — requesting token...");

      grecaptcha.enterprise.execute('<?php echo $recaptchaSiteKey; ?>', {action: 'submit'}).then(function(token) {
        console.log("[reCAPTCHA DEBUG] Token received:", token ? token.substring(0, 20) + "..." : "EMPTY");
        if (!token) {
          console.error("[reCAPTCHA DEBUG] No token received — reCAPTCHA failed.");
          alert("Unable to generate reCAPTCHA token. Please try again.");
          return;
        }

        if (!tokenField) {
          console.error("[reCAPTCHA DEBUG] No hidden field found for 'g-recaptcha-response'.");
          alert("Form misconfigured: missing hidden input for reCAPTCHA.");
          return;
        }

        tokenField.value = token;
        console.log("[reCAPTCHA DEBUG] Token field set. Submitting form now.");
        form.submit();
      }).catch(function(err) {
        console.error("[reCAPTCHA DEBUG] Error executing grecaptcha:", err);
        alert("reCAPTCHA execution error — see console for details.");
      });
    });
  });
});
</script>
</head>

<body>
  <a href="#main-content" class="skip-link">Skip to main content</a>
  <?php include 'navigation.inc.php'; ?>
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
      <form id="contact-form" method="post" action="contact.php">
        <label class="label-header" for="name">Your Name: (required)</label>
        <input type="text" id="name" name="name" aria-required="true" autocomplete="name" required />
        <span class="error" id="name-error" aria-live="polite"></span>

        <label class="label-header" for="email">Your Email: (required)</label>
        <input type="email" id="email" name="email" aria-required="true" autocomplete="email" required />

        <label class="label-header" for="subject-line">Subject</label>
        <input type="text" id="subject-line" name="subject" />

        <label class="label-header" for="message">Your Message</label>
        <textarea name="message" id="message" rows="10" cols="50" /></textarea>

        <input type="hidden" id="g-recaptcha-response" name="g-recaptcha-response" />

        <button class="g-recaptcha" id="submit-btn" type="submit">Send</button>
      </form>
    </div>
  </main>
</body>
<?php include "footer.inc.php" ?>
</html>
