<?php
session_start();
require_once 'settings.php';

$login_error = '';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Only access $_POST inside this block
    $username = isset($_POST['username']) ? trim($_POST['username']) : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';

    if (empty($username) || empty($password)) {
        $login_error = "Please enter both username and password.";
    } else {
        $conn = mysqli_connect($host, $user, $pwd, $sql_db);
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        $query = "SELECT * FROM managers WHERE username = ?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($row = mysqli_fetch_assoc($result)) {
            if ($password === $row['password']) {
                $_SESSION['manager_logged_in'] = true;
                $_SESSION['manager_username'] = $username;
                header("Location: manage.php");
                exit();
            } else {
                $login_error = "Invalid password.";
            }
        } else {
            $login_error = "User not found.";
        }

        mysqli_close($conn);
    }
}
?>