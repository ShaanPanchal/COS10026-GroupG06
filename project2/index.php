<?php
session_start(); // Start session for login tracking
$pageTitle = "SRN Careers | Talent Acquisition";
require_once 'header.inc';
require_once 'nav.inc';
?>

<!-- Hero Section -->
<section class="hero-section">
    <div class="hero-content">
        <h1 class="hero-headline">Career Excellence.<br>Redefined.</h1>
        <p class="hero-subhead">2025 Talent Solutions</p>

        <?php if (isset($_SESSION['eoi_number'])): ?>
            <p class="welcome-msg">
                Welcome back, applicant #<?php echo $_SESSION['eoi_number']; ?> 👋
            </p>
        <?php endif; ?>

        <a href="jobs.php" class="primary-button large btn-view-jobs">View Positions</a>

        <div class="home-action-buttons">
  <a href="apply.php" class="primary-button">💼 Apply for a Job</a>

  <?php if (!isset($_SESSION['eoi_number']) && !isset($_SESSION['staff_logged_in'])): ?>
    <a href="login.php" class="primary-button">🔐 Check Application Status</a>
    <a href="manager_login.php" class="primary-button">🧑‍💼 Staff Login</a>
  
  <?php elseif (isset($_SESSION['eoi_number'])): ?>
    <a href="status.php" class="primary-button">📄 View My Application</a>
    <a href="logout.php" class="primary-button">🚪 Log Out</a>

  <?php elseif (isset($_SESSION['staff_logged_in'])): ?>
    <a href="manage.php" class="primary-button">📋 Manage EOIs</a>
    <a href="logout.php" class="primary-button">🚪 Log Out</a>
  <?php endif; ?>
</div>
    </div>
</section>

<?php include 'benefits.inc'; ?>

<?php require_once 'footer.inc'; ?>