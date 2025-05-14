<?php
$pageTitle = "Processing Application";
require_once 'header.inc';
require_once 'nav.inc';
require_once 'settings.php';

// Check if form was submitted
if ($_SERVER["REQUEST_METHOD"] != "POST") {
    header("Location: apply.php");
    exit();
}

// Process form data and insert into database
// Add your validation and database insertion code here

// Display confirmation
?>
<main class="confirmation-section">
    <h1>Application Received</h1>
    <p>Thank you for your application. Your EOI number is: <?php echo $newEoiNumber; ?></p>
    <a href="jobs.php" class="primary-button">Back to Jobs</a>
</main>

<?php require_once 'footer.inc'; ?>