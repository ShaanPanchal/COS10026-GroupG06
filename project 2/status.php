<?php
session_start();
$pageTitle = "Application Status | SRN Careers";
require_once 'header.inc';
require_once 'nav.inc';
require_once 'settings.php';

// Check if they're logged in
if (!isset($_SESSION['eoi_number'])) {
    header("Location: login.php");
    exit();
}

$eoi = null;
$conn = @mysqli_connect($host, $user, $pwd, $sql_db);
if ($conn) {
    $eoi_id = $_SESSION['eoi_number'];
    $query = "SELECT * FROM eoi WHERE EOInumber = $eoi_id";
    $result = mysqli_query($conn, $query);
    if ($result && mysqli_num_rows($result) > 0) {
        $eoi = mysqli_fetch_assoc($result);
    }
    mysqli_close($conn);
}
?>

<main class="status-section">
  <h1 class="section-headline">Your Application Status</h1>

  <?php if ($eoi): ?>
    <p><strong>Name:</strong> <?php echo htmlspecialchars($eoi['first_name'] . " " . $eoi['last_name']); ?></p>
    <p><strong>Job Reference:</strong> <?php echo htmlspecialchars($eoi['job_ref_number']); ?></p>
    <p><strong>Status:</strong> <?php echo htmlspecialchars($eoi['status']); ?></p>
    <p><strong>Email:</strong> <?php echo htmlspecialchars($eoi['email']); ?></p>
    <p><strong>Phone:</strong> <?php echo htmlspecialchars($eoi['phone']); ?></p>
    <p><strong>Address:</strong> <?php echo htmlspecialchars($eoi['street_address'] . ", " . $eoi['suburb'] . ", " . $eoi['state'] . " " . $eoi['postcode']); ?></p>
    <p><strong>Skills:</strong> <?php echo htmlspecialchars($eoi['skill1']); ?><?php if ($eoi['skill2']) echo ", " . htmlspecialchars($eoi['skill2']); ?></p>
    <p><strong>Other Skills:</strong> <?php echo nl2br(htmlspecialchars($eoi['other_skills'])); ?></p>

    <a href="logout.php" class="primary-button" style="margin-top: 20px;">Log Out</a>
  <?php else: ?>
    <p>Oops 😬... We couldn’t find your application details.</p>
    <a href="login.php" class="primary-button">Try Logging In Again</a>
  <?php endif; ?>
</main>

<?php require_once 'footer.inc'; ?>