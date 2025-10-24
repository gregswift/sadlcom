<?php
  //Load the site's secret data
  require_once '../sadlcom-config.inc.php';

  //Set details of each page centrally so we can just look it up
  $pageDetails = [
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
      'schema'    => '/schemas/faq.jsonld'
    ],
    'contact.php' => [
      'navTitle'  => 'Contact',
      'pageTitle' => 'Contact Us',
      'icon'      => 'images/icons/contact-form-icon.svg',
      'schema'    => '/schemas/contact.jsonld'
    ],
    'index.php'   => [
      'navTitle'  => '',
      'pageTitle' => 'Texas Social Security Disability Attorney',
      'icon'      => '',
      'schema'    => '/schemas/index.jsonld'
    ]
  ];

  //Load the current page
  $currentPage = basename($_SERVER['PHP_SELF']);
  $pageTitle   = $pageDetails[$currentPage]['pageTitle'];
  $schemaFile  = $pageDetails[$currentPage]['schema'];
  $navTitle    = $pageDetails[$currentPage]['navTitle'];
  $icon        = $pageDetails[$currentPage]['icon'];

  $schema = file_get_contents(__DIR__ . $schemaFile);  
?>
