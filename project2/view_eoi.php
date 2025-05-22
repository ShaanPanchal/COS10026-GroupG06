<?php
session_start();
$pageTitle = "EOI Details | SRN Careers";
require_once 'settings.php';
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
    echo "<h1 class='section-headline'>Applicant #: " . htmlspecialchars($row['EOInumber']) . "</h1>";

    echo "<p><strong>Full Name:</strong> " . htmlspecialchars($row['first_name']) . " " . htmlspecialchars($row['last_name']) . "</p>";
    echo "<p><strong>Email:</strong> " . htmlspecialchars($row['email']) . "</p>";
    echo "<p><strong>Phone:</strong> " . htmlspecialchars($row['phone']) . "</p>";
    echo "<p><strong>Job Reference:</strong> " . htmlspecialchars($row['job_ref_number']) . "</p>";

    echo "<p><strong>Street Address:</strong> " . htmlspecialchars($row['street_address']) . "</p>";
    echo "<p><strong>Suburb:</strong> " . htmlspecialchars($row['suburb']) . "</p>";
    echo "<p><strong>State:</strong> " . htmlspecialchars($row['state']) . "</p>";
    echo "<p><strong>Postcode:</strong> " . htmlspecialchars($row['postcode']) . "</p>";

    echo "<p><strong>Skill 1:</strong> " . htmlspecialchars($row['skill1'] ?? 'Not selected') . "</p>";
    echo "<p><strong>Skill 2:</strong> " . htmlspecialchars($row['skill2'] ?? 'Not selected') . "</p>";
    echo "<p><strong>Other Skills:</strong> " . nl2br(htmlspecialchars($row['other_skills'] ?? 'None')) . "</p>";

    echo "<p><strong>Application Status:</strong> " . htmlspecialchars($row['status']) . "</p>";
    echo "<p><strong>Submitted On:</strong> " . htmlspecialchars(date('d M Y', strtotime($row['submission_date'] ?? ''))) . "</p>";

    echo "<br><a href='manage.php' class='primary-button'>⬅️ Back to Dashboard</a>";
    echo "</div>";
    echo "</main>";
} else {
    echo "<main class='application-section'>";
    echo "<div class='form-container'>";
    echo "<h1 class='section-headline'>EOI Not Found</h1>";
    echo "<p class='paragraph'>We couldn't find an application with this ID. 😕</p>";
    echo "<a href='manage.php' class='primary-button'>⬅️ Back</a>";
    echo "</div>";
    echo "</main>";
}

mysqli_close($conn);
require_once 'footer.inc';
?>