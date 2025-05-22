<?php
session_start();
require_once 'settings.php';
require_once 'header.inc';
require_once 'nav.inc';

$login_error = '';
$loginTitle = "HR Login";
$formAction = "manager_login.php";

// Track login attempts and lockout
if (!isset($_SESSION['login_attempts'])) {
    $_SESSION['login_attempts'] = 0;
    $_SESSION['lockout_time'] = 0;
}

// Lockout check
if ($_SESSION['login_attempts'] >= 3 && time() < $_SESSION['lockout_time']) {
    $minutes = ceil(($_SESSION['lockout_time'] - time()) / 60);
    $login_error = " Too many failed attempts. Try again in {$minutes} minute(s).";
} elseif ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    $conn = @mysqli_connect($host, $user, $pwd, $sql_db);
    if ($conn) {
        $query = "SELECT * FROM managers WHERE username = '$username'";
        $result = mysqli_query($conn, $query);

        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            if (password_verify($password, $row['password'])) {
                $_SESSION['manager_logged_in'] = true;
                $_SESSION['staff_username'] = $username;
                $_SESSION['login_attempts'] = 0;
                header("Location: manage.php");
                exit();
            }
        }

        // Fail case
        $_SESSION['login_attempts']++;
        if ($_SESSION['login_attempts'] >= 3) {
            $_SESSION['lockout_time'] = time() + 300;
            $login_error = " Too many failed attempts. try again after 5 minutes.";
        } else {
            $login_error = " uh oh ! Incorrect username or password. you only have 3 attemptesS";
        }

        mysqli_close($conn);
    } else {
        $login_error = "Database connection failed.";
    }
}
?>

<main class="form-container">
  <h1 class="hero-headline"><?= $loginTitle ?></h1>

  <?php if (!empty($login_error)): ?>
    <p class="login-error"><?= htmlspecialchars($login_error) ?></p>
  <?php endif; ?>

  <form method="POST" action="<?= $formAction ?>" novalidate>
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