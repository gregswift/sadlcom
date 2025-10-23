<?php
  $metaTitle       = $pageTitle . ' | San Antonio Disability Lawyer | Michael Archer';
  $metaDescription = 'Experienced and trusted legal help with your disability claim. Get what you deserve. Call Michael Archer now at '. $phoneNumber;
?>
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
{
  "@context": "https://schema.org",
  "@type": ["LegalService", "Attorney"],
  "name": "Michael Archer, San Antonio Disability Lawyer",
  "url": "https://sanantoniodisabilitylawyer.com/",
  "description": "San Antonio Attorney Michael Archer helps clients secure Social Security and disability benefits across Texas. Call for trusted representation.",
  "telephone": "<?php echo $phoneNumber; ?>",
  "priceRange": "$",
  "address": {
    "@type": "PostalAddress",
    "streetAddress": "300 E Ramsey Rd, Suite 305",
    "addressLocality": "San Antonio",
    "addressRegion": "TX",
    "postalCode": "78216",
    "addressCountry": "US"
  },
  "geo": {
    "@type": "GeoCoordinates",
    "latitude": 29.5282,
    "longitude": -98.4938
  },
  "areaServed": "San Antonio, Texas",
  "contactPoint": [
    {
      "@type": "ContactPoint",
      "contactType": "Mailing",
      "email": "contact@sanantoniodisabilitylawyer.com",
      "availableLanguage": "English",
      "address": {
        "@type": "PostalAddress",
        "streetAddress": "1150 N Loop 1604 W, #108-420",
        "addressLocality": "San Antonio",
        "addressRegion": "TX",
        "postalCode": "78248",
        "addressCountry": "US"
      }
    }
  ],
  "openingHoursSpecification": [
    {
      "@type": "OpeningHoursSpecification",
      "dayOfWeek": [
        "Monday", "Tuesday", "Wednesday", "Thursday", "Friday"
      ],
      "opens": "09:00",
      "closes": "17:00"
    }
  ],
  "founder": {
    "@type": "Person",
    "name": "Michael Archer"
  },
  "makesOffer": [
    {
      "@type": "Offer",
      "itemOffered": {
        "@type": "Service",
        "name": "Social Security Disability Representation",
        "serviceType": "Disability Law"
      }
    }
  ],
  "hasMap": "https://maps.app.goo.gl/judsNN9U8g1h3CK6A"
}
</script>
<!-- Styling -->
<link rel="stylesheet" href="/public/css/normalize.css">
<link rel="stylesheet" href="styles/main.css" />
<style>
  @import url("https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap");
</style>
