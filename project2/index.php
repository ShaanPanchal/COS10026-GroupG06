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
        <?php if (!isset($_SESSION['eoi_number'])): ?>
        <a href="login.php" class="secondary-button">🔐 Check Application Status</a>
        <a href="manager_login.php" class="secondary-button">🧑‍💼 Staff Login</a>
        <?php else: ?>
        <a href="status.php" class="secondary-button">📄 View My Application</a>
        <a href="logout.php" class="secondary-button">🚪 Log Out</a>
    <?php endif; ?>
</div>
    </div>
</section>

<?php include 'benefits.inc'; ?>

<?php require_once 'footer.inc'; ?>