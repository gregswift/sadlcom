<?php
$currentPage = basename($_SERVER['PHP_SELF']);
$navItems = [
    'index.php' => 'Home',
    'profile.php' => 'Profile',
    'faqs.php' => 'FAQs',
    'contact.php' => 'Contact'
];


$phoneNumber = "+12106994640";
$phoneDisplay = "(210) 699-4640";
?>
<div class="site-header">
    <div class="logo-container">
        <a class="company-name" href="index.php">
            San Antonio Disability Lawyer
        </a>
        <p class="subheader-name">Michael F. Archer</p>
    </div>

    <nav id="navbar" class="nav">
        <ul class="navbar-container">
            <?php foreach ($navItems as $url => $title): ?>
                <li class="nav-items<?php echo ($currentPage == $url) ? ' current-item' : ''; ?>">
                    <a href="<?php echo $url; ?>" 
                       class="nav-link<?php echo ($currentPage == $url) ? ' active' : ''; ?>">
                        <?php echo $title; ?>
                    </a>
                </li>
            <?php endforeach; ?>
            <!-- Phone number link -->
            <li class="call-now-btn">
                <a href="tel:<?php echo $phoneNumber; ?>">
                    <i class="phone-icon"></i> <?php echo $phoneDisplay; ?>
                </a>
            </li>
        </ul>
    </nav>
</div>
