<?php
session_start();
$pageTitle = "Manager Login";
require_once 'header.inc';
require_once 'nav.inc';
require_once 'settings.php';

// Constant credentials for one manager only
$correct_username = 'admin';
$correct_password = 'secure123'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    if ($username === $correct_username && $password === $correct_password) {
        $_SESSION['manager_logged_in'] = true;
        header("Location:manage.php");
        exit();
    } else {
        $error = "Invalid username or password.";
    }
}
?>

<main class="mgmt-container">
  <h1 class="mgmt-title">Manager Login</h1>
  <?php if (!empty($error)) echo "<p class='error-msg'>$error</p>"; ?>

  <form method="POST" class="mgmt-form">
    <label for="username">Username</label>
    <input type="text" name="username" id="username" required placeholder="Enter username">

    <label for="password">Password</label>
    <input type="password" name="password" id="password" required placeholder="Enter password">

    <button type="submit" class="primary-button">Login</button>
  </form>
</main>

<?php require_once 'footer.inc'; ?>