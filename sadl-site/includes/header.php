<?php
function currentPage(){
  $url_array = explode('/', $_SERVER['REQUEST_URI']);
  return end($url_array);
}

function navLink($link, $title){
  $url = currentPage();
  if($link == $url){
    $css_class = 'class="active" '; //class name in css 
  } else {
    $css_class = '';
  }
  echo '<li class="nav-items"><a '.$css_class.'href="'.$link.'">'.$title.'</a></li>';
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>San Antonio Disability Lawyer</title>
    <link rel="stylesheet" href="styles/main.css" />
    <style>
      @import url("https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap");
    </style>
  </head>
  <body>
<?php
if(currentPage() == 'index.php') {
?>
    <section class="hero-page">
      <div class="pages-container">
        <div class="landing-page-navigation navigation-container">
          <div class="logo-container">
            <a class="company-name" href="index.html">
              San Antonio Disability Lawyer
            </a>
            <p class="subheader-name">Michael F. Archer</p>
          </div>
          <nav id="navbar" class="nav">
            <ul class="navbar-container">
              <?php navLink('profile.php', 'Attorney Profile');?>
              <?php navLink('faq.php', 'FAQ');?>
              <?php navLink('contact.php', 'Contact');?>
              <li class="call-now-btn">
                <a href="tel:+12106994640">
                  <span>210-699-4640</span>
                </a>
              </li>
            </ul>
          </nav>
        </div>
<?php
}
?>
