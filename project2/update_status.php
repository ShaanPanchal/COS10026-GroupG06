<?php
session_start();
require_once 'settings.php';

// 🔒 Check if manager is logged in
if (!isset($_SESSION['manager_logged_in']) || $_SESSION['manager_logged_in'] !== true) {
    header("Location: manager_login.php");
    exit();
}

// 🚀 Handle POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $eoi_id = intval($_POST['eoi_id'] ?? 0);
    $status = $_POST['status'] ?? '';

    $allowed_statuses = ['Accepted', 'Rejected', 'On Hold'];
    if (!in_array($status, $allowed_statuses)) {
        $_SESSION['message'] = '❌ Invalid status selected.';
        $_SESSION['message_type'] = 'error';
        header("Location: manage.php");
        exit();
    }

    // 🧠 Decide new stage
    $stage = ($status === 'Accepted' || $status === 'Rejected') ? 'Final' : 'Current';

    $conn = mysqli_connect($host, $user, $pwd, $sql_db);
    if (!$conn) {
        $_SESSION['message'] = '❌ Database connection failed.';
        $_SESSION['message_type'] = 'error';
        header("Location: manage.php");
        exit();
    }

    // 🛠 Update status & stage
    $query = "UPDATE eoi SET status = ?, stage = ? WHERE EOInumber = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'ssi', $status, $stage, $eoi_id);

    if (mysqli_stmt_execute($stmt)) {
        $_SESSION['message'] = '✅ Application status updated!';
        $_SESSION['message_type'] = 'success';
    } else {
        $_SESSION['message'] = '❌ Failed to update application.';
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