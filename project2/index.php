<?php
session_start(); // 👈 Needed to check login status
$pageTitle = "SRN Careers | Talent Acquisition";
require_once 'header.inc';
require_once 'nav.inc';
?>

<!-- Hero Section -->
<section class="hero-section">
    <div class="hero-content">
        <h1 class="hero-headline">Career Excellence.<br>Redefined.</h1>
        <p class="hero-subhead">2025 Talent Solutions</p>

        <!-- Greet user if logged in -->
        <?php if (isset($_SESSION['eoi_number'])): ?>
            <p style="margin-top: 15px; font-size: 18px; color: #444;">
                Welcome back, applicant #<?php echo $_SESSION['eoi_number']; ?> 👋
            </p>
        <?php endif; ?>

        <!-- Primary action -->
        <a href="jobs.php" class="primary-button large" style="margin-bottom: 20px;">View Positions</a>

        <!-- Apply + Login buttons -->
        <div style="margin-top: 30px;">
            <a href="apply.php" class="primary-button" style="margin-right: 15px;">💼 Apply for a Job</a>
            <?php if (!isset($_SESSION['eoi_number'])): ?>
                <a href="login.php" class="secondary-button">🔐 Check Application Status</a>
            <?php else: ?>
                <a href="status.php" class="secondary-button">📄 View My Application</a>
                <a href="logout.php" class="secondary-button" style="margin-left: 10px;">🚪 Log Out</a>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- BENEFITS -->
<section class="benefits-section">
    <h2 class="section-headline">Why Partner With Us</h2>
    <div class="benefits-grid">
        <div class="benefit-card">
            <div class="benefit-icon">✓</div>
            <h3>Strategic Matching</h3>
            <p>Precision alignment of talent to organizational needs</p>
        </div>
        <div class="benefit-card">
            <div class="benefit-icon">⌚</div>
            <h3>Efficient Process</h3>
            <p>Streamlined recruitment lifecycle</p>
        </div>
        <div class="benefit-card">
            <div class="benefit-icon">★</div>
            <h3>Premium Network</h3>
            <p>Access to top-tier professionals</p>
        </div>
    </div>
</section>

<?php require_once 'footer.inc'; ?>