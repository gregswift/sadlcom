<?php $activeClassSuffix = ' active" aria-current="page"'; ?>
<a href="#main-content" class="skip-link">Skip to main content</a>
<div class="site-header">
<div class="logo-container">
  <a class="company-name" rel="home" href="index.php" rel="canonical">San Antonio Disability Lawyer</a>
  <p class="subheader-name">Michael F. Archer</p>
</div>
<!-- Desktop Navigation -->
<nav id="navbar" class="nav">
  <ul class="navbar-container">
<?php foreach ($pageDetails as $url => $item): ?>
    <li class="nav-items<?php echo ($currentPage == $url) ? ' current-item' : ''; ?>">
      <a href="<?php echo $url; ?>" class="nav-link<?php echo ($currentPage == $url) ? $activeClassSuffix : '"'; ?>>
         <?php echo $item['navTitle']; ?>
      </a>
    </li>
<?php endforeach; ?>
    <!-- Phone number link -->
    <li class="call-now-btn">
      <a href="tel:<?php echo $phoneNumber; ?>"><i class="phone-icon"></i><?php echo $phoneDisplay; ?></a>
    </li>
  </ul>
</nav>

<!-- Mobile Navigation -->
<nav class="mobile-nav-container">
  <ul class="mobile-container">
<?php foreach ($pageDetails as $url => $item): ?>
    <li>
      <a href="<?php echo $url; ?>" class="nav-link<?php echo ($currentPage == $url) ? $activeClassSuffix : '"'; ?>>
         <img src="<?php echo $item['icon']; ?>" alt="<?php echo $item['navTitle']; ?>" />
      </a>
    </li>
<?php endforeach; ?>
    <li>
      <a href="tel:<?php echo $phoneNumber; ?>">
        <img src="images/icons/call-us-icon.svg" alt="Call Us" />
      </a>
    </li>
  </ul>
</nav>
</div>
