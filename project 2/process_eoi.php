<?php
$pageTitle = "Processing Application";
require_once 'header.inc';
require_once 'nav.inc';
require_once 'settings.php';

// Redirect if accessed directly
if ($_SERVER["REQUEST_METHOD"] != "POST") {
    header("Location: apply.php");
    exit();
}

// Function to clean input
function sanitise($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

// Get and sanitise form inputs
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

// Basic Validation (you can add more)
$errors = [];

if (!preg_match("/^[a-zA-Z]{1,20}$/", $first_name)) $errors[] = "Invalid first name.";
if (!preg_match("/^[a-zA-Z]{1,20}$/", $last_name)) $errors[] = "Invalid last name.";
if (!preg_match("/^\d{4}$/", $postcode)) $errors[] = "Postcode must be 4 digits.";
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Invalid email format.";
if (!preg_match("/^[0-9 ]{8,12}$/", $phone)) $errors[] = "Invalid phone number.";

if (!empty($errors)) {
    echo "<main><h2>Error</h2><ul>";
    foreach ($errors as $error) {
        echo "<li>$error</li>";
    }
    echo "</ul><a href='apply.php'>Go back</a></main>";
    require_once 'footer.inc';
    exit();
}

// Connect to database
$conn = @mysqli_connect($host, $user, $pwd, $sql_db);
if (!$conn) {
    echo "<main><p>Database connection failed. Please try again later.</p></main>";
    require_once 'footer.inc';
    exit();
}

// Insert into eoi table
$query = "INSERT INTO eoi (
    job_ref_number, first_name, last_name, street_address, suburb, state, postcode, email, phone, skill1, skill2, other_skills
) VALUES (
    '$job_ref_number', '$first_name', '$last_name', '$street_address', '$suburb', '$state', '$postcode', '$email', '$phone', '$skill1', '$skill2', '$other_skills'
)";

$result = mysqli_query($conn, $query);

if ($result) {
    $newEoiNumber = mysqli_insert_id($conn);
} else {
    echo "<main><p>Something went wrong, 😔 couldn't submit application.</p></main>";
    require_once 'footer.inc';
    exit();
}

mysqli_close($conn);
?>

<main class="confirmation-section">
    <h1>Application Received</h1>
    <p>Thank you for your application. Your EOI number is: <?php echo $newEoiNumber; ?></p>
    <a href="jobs.php" class="primary-button">Back to Jobs</a>
</main>

<?php require_once 'footer.inc'; ?>