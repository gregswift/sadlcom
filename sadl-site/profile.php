<?php
// Page specific data
$pageTitle = 'Attorney Profile';

//Load the site's config data
require_once '../sadlcom-config.inc.php';
?>
<!DOCTYPE html>
<html lang="en-US">
<head>
<?php include 'head.inc.php'; ?>
</head>
<body>
  <a href="#main-content" class="skip-link">Skip to main content</a>
  <?php include 'navigation.inc.php'; ?>
  <div class="page-title-container">
    <h1 class="page-title-header">Michael F. Archer, Attorney at Law</h1>
  </div>
  <main id="main-content">
    <div class="content-body">
      <div class="content-areas-of-practice-section">
        <h2>Practice Areas</h2>
        <ul>
          <li>Social Security</li>
          <li>Personal Injury</li>
          <li>General Civil Litigation</li>
          <li>Family Law</li>
          <li>Wills</li>
          <li>Adoption</li>
          <li>Probate</li>
        </ul>
      </div>
      <div class="content-admitted-section">
        <h2>Admitted:</h2>
        <ul>
          <li>1976, Texas</li>
          <li>1980, U.S. District Court, Western District of Texas</li>
          <li>1981, U.S. Court of Appeals, Fifth Circuit</li>
          <li>
            1987, U.S. District Court, Northern District of Texas and U.S.
            Supreme Court
          </li>
        </ul>
      </div>
      <div class="content-law-school-section">
        <h2>Law School</h2>
        <ul>
          <li>St. Mary’s University School of Law, J.D., 1975</li>
          <li>University of Texas, Masters of Law Program, 1976.</li>
        </ul>
      </div>
      <div class="content-college-section">
        <h2>College</h2>
        <p>University of Texas, B.A., 1973</p>
      </div>
      <div class="content-member-of-section">
        <h2>Member:</h2>
        <ul>
          <li>San Antonio Bar Association</li>
          <li>State Bar of Texas</li>
          <li>Social security lawyers</li>
        </ul>
      </div>
      <div class="content-biography">
        <h2>Biography</h2>
        <ul>
          <li>Associate Editor, St. Mary’s Law Journal, 1975</li>
          <li>
            Co-Author: Student Symposium, ” Texas Land Titles, Part II,” Volume
            7, No. 1, St. Mary’s Law Journal 58, 1975
          </li>
          <li>
            National Organization of Social Security Claimant’s Representatives
            (Sustaining Member, 1985-)
          </li>
        </ul>
        <p>Born: Yoakum, Texas, May 12, 1951.</p>
      </div>
    </div>
  </main>
</body>
<?php include 'footer.inc.php' ?>
</html>
