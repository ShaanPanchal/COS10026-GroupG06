<?php
session_start();
require_once 'settings.php';
$pageTitle = "EOI Details | SRN Careers";
require_once 'header.inc';
require_once 'nav.inc';

$conn = mysqli_connect($host, $user, $pwd, $sql_db);
if (!$conn) {
    die("<main><p class='mgmt-empty'>❌ Database connection failed.</p></main>");
}

$eoi_id = isset($_GET['eoi_id']) ? intval($_GET['eoi_id']) : 0;

$query = "SELECT * FROM eoi WHERE EOInumber = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "i", $eoi_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if ($row = mysqli_fetch_assoc($result)) {
    echo "<main class='application-section'>";
    echo "<div class='form-container'>";
    echo "<h1 class='section-headline'>EOI Details for #{$row['EOInumber']}</h1>";
    
    echo "<p><strong>Name:</strong> " . htmlspecialchars($row['first_name'] ?? '') . " " . htmlspecialchars($row['last_name'] ?? '') . "</p>";
    echo "<p><strong>Email:</strong> " . htmlspecialchars($row['email'] ?? '') . "</p>";
    echo "<p><strong>Phone:</strong> " . htmlspecialchars($row['phone'] ?? '') . "</p>";
    echo "<p><strong>Job Ref:</strong> " . htmlspecialchars($row['job_ref_number'] ?? '') . "</p>";
    echo "<p><strong>Skills:</strong> " . htmlspecialchars($row['skills'] ?? 'Not provided') . "</p>";
    echo "<p><strong>Availability:</strong> " . htmlspecialchars($row['availability'] ?? 'Not provided') . "</p>";
    echo "<p><strong>Other Info:</strong> " . nl2br(htmlspecialchars($row['other_info'] ?? 'None')) . "</p>";
    
    echo "<br><a href='manage.php' class='primary-button'>⬅️ Back to Dashboard</a>";
    echo "</div>";
    echo "</main>";
} else {
    echo "<main class='application-section'>";
    echo "<div class='form-container'>";
    echo "<h1 class='section-headline'>EOI not found</h1>";
    echo "<p class='paragraph'>No application found with this ID.</p>";
    echo "<a href='manage.php' class='primary-button'>⬅️ Back</a>";
    echo "</div>";
    echo "</main>";
}

mysqli_close($conn);
require_once 'footer.inc';
?>