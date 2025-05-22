<?php
session_start();
session_destroy(); // End old session
session_start();   // Begin fresh one

$pageTitle = "Login | SRN Careers";
require_once 'header.inc';
require_once 'nav.inc';
require_once 'settings.php';

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    $conn = @mysqli_connect($host, $user, $pwd, $sql_db);
    if ($conn) {
        $query = "SELECT EOInumber, password FROM eoi WHERE username = '$username'";
        $result = mysqli_query($conn, $query);

        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            if (password_verify($password, $row['password'])) {
                $_SESSION['eoi_number'] = $row['EOInumber'];
                header("Location:status.php");
                exit();
            } else {
                $error = "Incorrect password.";
            }
        } else {
            $error = "Username not found.";
        }

        mysqli_close($conn);
    } else {
        $error = "Database connection failed.";
    }
}
?>

<main class="form-container">
  <h1 class="hero-headline">Applicant Login</h1>
  <form method="POST" action="login.php" novalidate>
    <div class="form-group">
      <label for="username">Username</label>
      <input type="text" name="username" required placeholder="Enter your username">
    </div>
    <div class="form-group">
      <label for="password">Password</label>
      <input type="password" name="password" class="styled-input" required placeholder="Enter your password">
    </div>
    <div class="form-group full-width">
      <button type="submit" class="primary-button">Log In</button>
    </div>
    <?php if ($error): ?>
      <p class="login-error"><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>
  </form>
</main>

<?php require_once 'footer.inc'; ?>