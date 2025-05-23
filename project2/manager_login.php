<?php
session_start();
$pageTitle = "HR Login";
require_once 'settings.php';
require_once 'header.inc';
require_once 'nav.inc';

$login_error = '';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    $conn = @mysqli_connect($host, $user, $pwd, $sql_db);
    if ($conn) {
        $query = "SELECT * FROM managers WHERE username = ?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($row = mysqli_fetch_assoc($result)) {
            if (password_verify($password, $row['password'])) {
                $_SESSION['manager_logged_in'] = true;
                $_SESSION['staff_username'] = $username;
                header("Location: manage.php");
                exit();
            }
        }
        $login_error = "❌ Incorrect username or password.";
        mysqli_close($conn);
    } else {
        $login_error = "❌ Database connection failed.";
    }
}
?>

<main class="form-container">
  <h1 class="hero-headline">HR Login</h1>

  <?php if (!empty($login_error)): ?>
    <p class="login-error"><?= htmlspecialchars($login_error) ?></p>
  <?php endif; ?>

  <form method="POST" action="manager_login.php" novalidate>
    <div class="form-group full-width">
      <label for="username">Username</label>
      <input type="text" name="username" required placeholder="Enter your username" class="styled-input">
    </div>

    <div class="form-group full-width">
      <label for="password">Password</label>
      <input type="password" name="password" required placeholder="Enter your password" class="styled-input">
    </div>

    <div class="form-group full-width">
      <button type="submit" class="primary-button">Login</button>
    </div>
  </form>
</main>

<?php require_once 'footer.inc'; ?>