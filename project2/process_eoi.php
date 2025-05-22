<?php
session_start();
$pageTitle = "Processing Application";
require_once 'header.inc';
require_once 'nav.inc';
require_once 'settings.php';

if ($_SERVER["REQUEST_METHOD"] != "POST") {
    header("Location: apply.php");
    exit();
}

function sanitise($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

// Sanitize all form inputs
$job_ref_number = sanitise($_POST["job_ref_number"] ?? '');
$first_name     = sanitise($_POST["first_name"] ?? '');
$last_name      = sanitise($_POST["last_name"] ?? '');
$street_address = sanitise($_POST["street_address"] ?? '');
$suburb         = sanitise($_POST["suburb"] ?? '');
$state          = sanitise($_POST["state"] ?? '');
$postcode       = sanitise($_POST["postcode"] ?? '');
$email          = sanitise($_POST["email"] ?? '');
$phone          = sanitise($_POST["phone"] ?? '');
$skill1         = isset($_POST["skill1"]) ? sanitise($_POST["skill1"]) : '';
$skill2         = isset($_POST["skill2"]) ? sanitise($_POST["skill2"]) : '';
$other_skills   = sanitise($_POST["other_skills"] ?? '');

// Validation
$errors = [];

if (!preg_match("/^[A-Za-z]{1,20}$/", $first_name)) $errors[] = "First name must be alphabetic and up to 20 characters.";
if (!preg_match("/^[A-Za-z]{1,20}$/", $last_name)) $errors[] = "Last name must be alphabetic and up to 20 characters.";
if (!preg_match("/^[a-zA-Z0-9\s]{1,40}$/", $street_address)) $errors[] = "Street address must be alphanumeric (max 40 chars).";
if (!preg_match("/^[A-Za-z\s]{1,30}$/", $suburb)) $errors[] = "Suburb must be alphabetic and max 30 characters.";
if (!in_array($state, ["VIC", "NSW", "QLD", "WA", "SA", "TAS", "ACT", "NT"])) $errors[] = "Invalid state selected.";
if (!preg_match("/^\d{4}$/", $postcode)) $errors[] = "Postcode must be 4 digits.";
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Invalid email format.";
if (!preg_match("/^\d{8,12}$/", str_replace(" ", "", $phone))) $errors[] = "Phone number must be 8-12 digits.";

if (empty($job_ref_number)) $errors[] = "Job reference number is required.";

if (!empty($errors)) {
    echo "<main><h2>Oops! Please fix the following errors:</h2><ul>";
    foreach ($errors as $error) echo "<li>$error</li>";
    echo "</ul><a href='apply.php'>⏪ Go back to the form</a></main>";
    require_once 'footer.inc';
    exit();
}

// Connect to DB
$conn = @mysqli_connect($host, $user, $pwd, $sql_db);
if (!$conn) {
    echo "<main><p>Database connection failed. Try again later.</p></main>";
    require_once 'footer.inc';
    exit();
}

// Username Generator
function generateUsername($firstName, $lastName, $conn) {
    $base = strtolower(substr($firstName, 0, 3) . substr($lastName, 0, 3));
    do {
        $username = $base . rand(100, 999);
        $check = mysqli_query($conn, "SELECT * FROM eoi WHERE username = '$username'");
    } while (mysqli_num_rows($check) > 0);
    return $username;
}

// Password Generator
function generatePassword($length = 8) {
    $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $pass = '';
    for ($i = 0; $i < $length; $i++) {
        $pass .= $chars[random_int(0, strlen($chars) - 1)];
    }
    return $pass;
}

$username = generateUsername($first_name, $last_name, $conn);
$password = generatePassword();
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Insert application
$query = "INSERT INTO eoi (
    job_ref_number, first_name, last_name, street_address, suburb, state, postcode,
    email, phone, skill1, skill2, other_skills, username, password
) VALUES (
    '$job_ref_number', '$first_name', '$last_name', '$street_address', '$suburb', '$state', '$postcode',
    '$email', '$phone', '$skill1', '$skill2', '$other_skills', '$username', '$hashed_password'
)";

$result = mysqli_query($conn, $query);

if ($result) {
    $_SESSION['last_eoi_number'] = mysqli_insert_id($conn);
    $_SESSION['generated_username'] = $username;
    $_SESSION['generated_password'] = $password;
    header("Location: thank-you.php");
    exit();
} else {
    echo "<main><p>😔 Something went wrong, couldn't submit your application. Please try again.</p></main>";
    require_once 'footer.inc';
    exit();
}

mysqli_close($conn);
?>