<?php
session_start();
require_once 'settings.php';

// Check if manager is logged in
if (!isset($_SESSION['manager_logged_in']) || $_SESSION['manager_logged_in'] !== true) {
    header("Location: manager_login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $eoi_id = intval($_POST['eoi_id'] ?? 0);
    $status = $_POST['status'] ?? '';

    $allowed_statuses = ['New', 'Current', 'Final'];
    if (!in_array($status, $allowed_statuses)) {
        $_SESSION['message'] = '❌ Invalid status selected.';
        $_SESSION['message_type'] = 'error';
        header("Location: manage.php");
        exit();
    }

    $conn = mysqli_connect($host, $user, $pwd, $sql_db);
    if (!$conn) {
        $_SESSION['message'] = '❌ Database connection failed.';
        $_SESSION['message_type'] = 'error';
        header("Location: manage.php");
        exit();
    }

    $query = "UPDATE eoi SET status = ? WHERE EOInumber = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'si', $status, $eoi_id);

    if (mysqli_stmt_execute($stmt)) {
        $_SESSION['message'] = '✅ Status updated successfully!';
        $_SESSION['message_type'] = 'success';
    } else {
        $_SESSION['message'] = '❌ Failed to update status.';
        $_SESSION['message_type'] = 'error';
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);
    header("Location: manage.php");
    exit();
} else {
    header("Location: manage.php");
    exit();
}
?>