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

// Sanitize inputs
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

$errors = [];

// === Validations ===
if (!preg_match("/^[A-Za-z]{1,20}$/", $first_name)) $errors[] = "First name must be alphabetic and up to 20 characters.";
if (!preg_match("/^[A-Za-z]{1,20}$/", $last_name)) $errors[] = "Last name must be alphabetic and up to 20 characters.";
if (!preg_match("/^[a-zA-Z0-9\s]{1,40}$/", $street_address)) $errors[] = "Street address must be alphanumeric and up to 40 characters.";
if (!preg_match("/^[A-Za-z\s]{1,30}$/", $suburb)) $errors[] = "Suburb must be alphabetic and up to 30 characters.";
if (!in_array($state, ["VIC", "NSW", "QLD", "WA", "SA", "TAS", "ACT", "NT"])) $errors[] = "Invalid state selected.";
if (!preg_match("/^\d{4}$/", $postcode)) {
    $errors[] = "Postcode must be 4 digits.";
} elseif (!isValidPostcodeForState($postcode, $state)) {
    $errors[] = "Postcode does not match the selected state.";
}
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Invalid email format.";
if (!preg_match("/^\d{8,12}$/", str_replace(" ", "", $phone))) $errors[] = "Phone number must be 8–12 digits.";
if (empty($job_ref_number)) $errors[] = "Job reference number is required.";

// Show errors if any
if (!empty($errors)) {
    echo "<main><h2>Oops! Please fix the following errors:</h2><ul>";
    foreach ($errors as $error) echo "<li>$error</li>";
    echo "</ul><a href='apply.php'>⏪ Go back to the form</a></main>";
    require_once 'footer.inc';
    exit();
}

// === Postcode validation based on state ===
function isValidPostcodeForState($postcode, $state) {
    $postcode = (int)$postcode;
    $ranges = [
        "NSW" => [ [1000, 1999], [2000, 2599], [2619, 2899], [2921, 2999] ],
        "ACT" => [ [200, 299], [2600, 2618], [2900, 2920] ],
        "VIC" => [ [3000, 3996], [8000, 8999] ],
        "QLD" => [ [4000, 4999], [9000, 9999] ],
        "SA"  => [ [5000, 5799], [5800, 5999] ],
        "WA"  => [ [6000, 6797], [6800, 6999] ],
        "TAS" => [ [7000, 7799], [7800, 7999] ],
        "NT"  => [ [800, 899], [900, 999] ]
    ];
    if (!isset($ranges[$state])) return false;
    foreach ($ranges[$state] as $range) {
        if ($postcode >= $range[0] && $postcode <= $range[1]) return true;
    }
    return false;
}

// === Database Insert ===
$conn = @mysqli_connect($host, $user, $pwd, $sql_db);
if (!$conn) {
    echo "<main><p>Database connection failed. Try again later.</p></main>";
    require_once 'footer.inc';
    exit();
}

function generateUsername($firstName, $lastName, $conn) {
    $base = strtolower(substr($firstName, 0, 3) . substr($lastName, 0, 3));
    do {
        $username = $base . rand(100, 999);
        $check = mysqli_query($conn, "SELECT * FROM eoi WHERE username = '$username'");
    } while (mysqli_num_rows($check) > 0);
    return $username;
}

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

// Final insert query (note: stage is set to 'New')
$query = "INSERT INTO eoi (
    job_ref_number, first_name, last_name, street_address, suburb, state, postcode,
    email, phone, skill1, skill2, other_skills, username, password, stage
) VALUES (
    '$job_ref_number', '$first_name', '$last_name', '$street_address', '$suburb', '$state', '$postcode',
    '$email', '$phone', '$skill1', '$skill2', '$other_skills', '$username', '$hashed_password', 'New'
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
