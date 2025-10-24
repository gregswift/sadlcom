<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title><?php echo $metaTitle; ?></title>
<meta name="description" content="<?php echo $metaDescription; ?>">
<!-- Open Graph metadata -->
<meta property="og:type" content="website">
<meta property="og:title" content="<?php echo $metaTitle; ?>">
<meta property="og:description" content="<?php echo $metaDescription; ?>">
<!-- Twitter Card metadata -->
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="<?php echo $metaTitle; ?>">
<meta name="twitter:description" content="<?php echo $metaDescription; ?>">
<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-Q4E0FG3R3M"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-Q4E0FG3R3M');
</script>
<!-- schema.org representation -->
<script type="application/ld+json">
<?php echo $schema; ?>
</script>
<!-- Styling -->
<link rel="stylesheet" href="/public/css/normalize.css">
<link rel="stylesheet" href="styles/main.css" />
<style>
  @import url("https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap");
</style>
