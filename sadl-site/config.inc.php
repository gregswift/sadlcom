<?php
  //Load the site's secret data
  require_once '../sadlcom-config.inc.php';

  //Ensure that the non-www version of the site is the primary
  $requestedDomain = $_SERVER["SERVER_NAME"];
  if ($requestedDomain != $primaryDomain) {
   header( "HTTP/1.1 301 Moved Permanently" );
   header("location: https://" . $primaryDomain . $_SERVER['PHP_SELF']); // grab full request slugs, primarily to facilitate drafts
  }

  //Set details of each page centrally so we can just look it up
  $pageDetails = [
    'index.php'   => [
      'navTitle'  => '',
      'pageTitle' => 'Texas Social Security Disability Attorney',
      'icon'      => 'images/icons/home-page-icon.svg',
      'schema'    => '/schemas/index.jsonld'
    ],
    'profile.php' => [
      'navTitle'  => 'Profile',
      'pageTitle' => 'Michael F. Archer, Attorney at Law',
      'icon'      => 'images/icons/attorney-profile-icon.svg',
      'schema'    => '/schemas/profile.jsonld'
    ],
    'faqs.php'    => [
      'navTitle'  => 'FAQs',
      'pageTitle' => 'Frequently Asked Questions',
      'icon'      => 'images/icons/faq-icon.svg',
      'schema'    => '/schemas/faqs.jsonld'
    ],
    'contact.php' => [
      'navTitle'  => 'Contact',
      'pageTitle' => 'Contact Us',
      'icon'      => 'images/icons/contact-form-icon.svg',
      'schema'    => '/schemas/contact.jsonld'
    ]
  ];

  //Load the current page
  $currentPage = basename($_SERVER['PHP_SELF']);
  $pageTitle   = $pageDetails[$currentPage]['pageTitle'];
  $schemaFile  = $pageDetails[$currentPage]['schema'];
  $navTitle    = $pageDetails[$currentPage]['navTitle'];
  $icon        = $pageDetails[$currentPage]['icon'];

  $metaTitle       = 'San Antonio Social Security Disability Lawyer | Michael Archer';
  $metaDescription = 'Need help with a Social Security disability claim in San Antonio? Attorney Michael Archer fights for your SSDI/SSI benefits. Call 210-699-4640 for a free consultation.';

  $schema = file_get_contents(__DIR__ . $schemaFile);  
?>
