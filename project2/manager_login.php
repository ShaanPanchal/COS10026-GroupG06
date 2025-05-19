<?php
// Show errors during development
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
require_once 'settings.php';

$login_error = '';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = isset($_POST['username']) ? trim($_POST['username']) : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';

    if (empty($username) || empty($password)) {
        $login_error = "Please enter both username and password.";
    } else {
        $conn = mysqli_connect($host, $user, $pwd, $sql_db);
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        // ✅ Still using the managers table
        $query = "SELECT * FROM managers WHERE username = ?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($row = mysqli_fetch_assoc($result)) {
            if ($password === $row['password']) {
                $_SESSION['manager_logged_in'] = true;
                $_SESSION['staff_username'] = $username;
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

<?php require_once 'header.inc'; ?>
<?php require_once 'nav.inc'; ?>

<main class="application-section">
    <div class="form-container">
        <h1 class="section-headline">Staff Login</h1>
        <?php if ($login_error): ?>
            <p class="error-msg"><?php echo $login_error; ?></p>
        <?php endif; ?>

        <form method="POST" action="manager_register.php">
            <div class="form-group full-width">
                <label for="username">Username</label>
                <input type="text" name="username" required placeholder="Enter your username">
            </div>

            <div class="form-group full-width">
                <label for="password">Password</label>
                <input type="password" name="password" required placeholder="Enter your password">
            </div>

            <div class="form-group full-width">
                <button type="submit" class="primary-button">Login</button>
            </div>
        </form>
    </div>
</main>

<?php require_once 'footer.inc'; ?>