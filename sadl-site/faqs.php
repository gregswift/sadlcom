<?php require_once 'config.inc.php'; ?>
<!DOCTYPE html>
<html lang="en-US">
<head>
<?php include 'head.inc.php'; ?>
</head>
<body>
<?php include 'navigation.inc.php'; ?>
<div class="faq-page-body">
  <div class="page-title-container">
    <h1 class="page-title-header faq"><?php echo $pageTitle; ?></h1>
  </div>
  <main id="main-content">
    <div class="content-body">
<?php
$faqData = json_decode($schema, true);
foreach ($faqData['mainEntity'] as $item) {
    echo "      <h2>" . htmlspecialchars($item['name']) . "</h2>";
    echo "      <p>" . htmlspecialchars($item['acceptedAnswer']['text']) . "</p>";
}
?>
    </div>
  </main>
</div>
</body>
<?php include 'footer.inc.php' ?>
</html>
