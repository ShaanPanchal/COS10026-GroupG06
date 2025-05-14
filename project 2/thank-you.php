<?php
$pageTitle = "Thank You | SRN Careers";
require_once 'header.inc';
require_once 'nav.inc';

// Get EOI number from session or URL if available
$eoiNumber = '';
if (isset($_SESSION['last_eoi_number'])) {
    $eoiNumber = htmlspecialchars($_SESSION['last_eoi_number']);
    unset($_SESSION['last_eoi_number']); // Clear after displaying
} elseif (isset($_GET['eoi'])) {
    $eoiNumber = htmlspecialchars($_GET['eoi']);
}
?>

<!-- Thank You Section -->
<section class="thank-you-section">
    <div class="thank-you-icon">✓</div>
    <h1 class="large-title">Thank You for Applying</h1>
    
    <?php if ($eoiNumber): ?>
        <div class="confirmation-number">
            <p>Your Expression of Interest number is:</p>
            <div class="eoi-number"><?php echo $eoiNumber; ?></div>
        </div>
    <?php endif; ?>
    
    <p class="title-3" style="color: #86868b; margin-bottom: 30px;">
        We've received your application and will be in touch soon.
    </p>
    <a href="jobs.php" class="primary-button large">View Other Positions</a>
</section>

<?php require_once 'footer.inc'; ?>