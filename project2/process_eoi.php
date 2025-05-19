<?php
session_start();
$pageTitle = "Processing Application";
require_once 'header.inc';
require_once 'nav.inc';
require_once 'settings.php';

// Redirect if accessed directly
if ($_SERVER["REQUEST_METHOD"] != "POST") {
    header("Location: apply.php");
    exit();
}

function sanitise($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

// Form inputs
$job_ref_number = sanitise($_POST["job_ref_number"]);
$first_name = sanitise($_POST["first_name"]);
$last_name = sanitise($_POST["last_name"]);
$street_address = sanitise($_POST["street_address"]);
$suburb = sanitise($_POST["suburb"]);
$state = sanitise($_POST["state"]);
$postcode = sanitise($_POST["postcode"]);
$email = sanitise($_POST["email"]);
$phone = sanitise($_POST["phone"]);
$skill1 = isset($_POST["skill1"]) ? sanitise($_POST["skill1"]) : '';
$skill2 = isset($_POST["skill2"]) ? sanitise($_POST["skill2"]) : '';
$other_skills = sanitise($_POST["other_skills"]);

$errors = [];
if (!preg_match("/^[a-zA-Z]{1,20}$/", $first_name)) $errors[] = "Invalid first name.";
if (!preg_match("/^[a-zA-Z]{1,20}$/", $last_name)) $errors[] = "Invalid last name.";
if (!preg_match("/^\d{4}$/", $postcode)) $errors[] = "Postcode must be 4 digits.";
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Invalid email format.";
if (!preg_match("/^[0-9 ]{8,12}$/", $phone)) $errors[] = "Invalid phone number.";

if (!empty($errors)) {
    echo "<main><h2>Error</h2><ul>";
    foreach ($errors as $error) echo "<li>$error</li>";
    echo "</ul><a href='apply.php'>Go back</a></main>";
    require_once 'footer.inc';
    exit();
}

$conn = @mysqli_connect($host, $user, $pwd, $sql_db);
if (!$conn) {
    echo "<main><p>Database connection failed. Please try again later.</p></main>";
    require_once 'footer.inc';
    exit();
}

// Generate unique username
function generateUsername($firstName, $lastName, $conn) {
    $base = strtolower(substr($firstName, 0, 3) . substr($lastName, 0, 3));
    do {
        $username = $base . rand(100, 999);
        $check = mysqli_query($conn, "SELECT * FROM eoi WHERE username = '$username'");
    } while (mysqli_num_rows($check) > 0);
    return $username;
}

// Generate password
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

// Insert into eoi table
$query = "INSERT INTO eoi (
    job_ref_number, first_name, last_name, street_address, suburb, state, postcode,
    email, phone, skill1, skill2, other_skills, username, password
) VALUES (
    '$job_ref_number', '$first_name', '$last_name', '$street_address', '$suburb', '$state', '$postcode',
    '$email', '$phone', '$skill1', '$skill2', '$other_skills', '$username', '$hashed_password'
)";

$result = mysqli_query($conn, $query);

if ($result) {
    $newEoiNumber = mysqli_insert_id($conn);
    $_SESSION['last_eoi_number'] = $newEoiNumber;
    $_SESSION['generated_username'] = $username;
    $_SESSION['generated_password'] = $password;
    header("Location: thankyou.php");
    exit();
} else {
    echo "<main><p>Something went wrong, 😔 couldn't submit application.</p></main>";
    require_once 'footer.inc';
    exit();
}

mysqli_close($conn);
?>