<?php
session_start();
require_once 'header.inc';
require_once 'nav.inc';
require_once 'settings.php';

if (!isset($_SESSION['eoi_number'])) {
    header("Location: login.php");
    exit();
}

$eoi_number = $_SESSION['eoi_number'];
$conn = mysqli_connect($host, $user, $pwd, $sql_db);
if (!$conn) {
    echo "<main><p>😢 Connection failed. Try again later.</p></main>";
    require_once 'footer.inc';
    exit();
}

$query = "SELECT * FROM eoi WHERE EOInumber = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, 'i', $eoi_number);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($result) == 1) {
    $row = mysqli_fetch_assoc($result);
    ?>
    <main class="application-status">
        <h1>📄 Application Status</h1>
        <p><strong>Name:</strong> <?php echo htmlspecialchars($row['first_name'] . ' ' . $row['last_name']); ?></p>
        <p><strong>Job Reference:</strong> <?php echo htmlspecialchars($row['job_ref_number']); ?></p>
        <p><strong>Submitted Email:</strong> <?php echo htmlspecialchars($row['email']); ?></p>
        <p><strong>Current Status:</strong> <span style="color: #00c853; font-weight: 600;">
            <?php echo htmlspecialchars($row['status']); ?>
        </span></p>
        <a href="logout.php" class="primary-button">Log Out</a>
    </main>
    <?php
} else {
    echo "<main><p>😔 Sorry, we couldn't find your application.</p></main>";
}

mysqli_stmt_close($stmt);
mysqli_close($conn);
require_once 'footer.inc';
?>