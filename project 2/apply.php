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

// Sanitisation function
function sanitise($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

// Get and sanitise inputs
$job_ref_number = sanitise($_POST["job_ref_number"]);
$first_name = sanitise($_POST["first_name"]);
$last_name = sanitise($_POST["last_name"]);
$dob = sanitise($_POST["dob"]);
$gender = sanitise($_POST["gender"]);
$street_address = sanitise($_POST["street_address"]);
$suburb = sanitise($_POST["suburb"]);
$state = sanitise($_POST["state"]);
$postcode = sanitise($_POST["postcode"]);
$email = sanitise($_POST["email"]);
$phone = sanitise($_POST["phone"]);
$other_skills = sanitise($_POST["other_skills"]);

// Skills handling
$skillsArray = isset($_POST["skills"]) ? $_POST["skills"] : [];
$skill1 = isset($skillsArray[0]) ? sanitise($skillsArray[0]) : '';
$skill2 = isset($skillsArray[1]) ? sanitise($skillsArray[1]) : '';

// Connect to database
$conn = @mysqli_connect($host, $user, $pwd, $sql_db);
if (!$conn) {
    die("<main><p>Database connection failure.</p></main>");
}

// Auto-create `eoi` table if not exists
$table_check_query = "SHOW TABLES LIKE 'eoi'";
$result = mysqli_query($conn, $table_check_query);
if (mysqli_num_rows($result) == 0) {
    $create_table_query = "
    CREATE TABLE eoi (
        EOInumber INT AUTO_INCREMENT PRIMARY KEY,
        job_ref_number VARCHAR(10),
        first_name VARCHAR(20),
        last_name VARCHAR(20),
        dob VARCHAR(10),
        gender VARCHAR(10),
        street_address VARCHAR(40),
        suburb VARCHAR(40),
        state ENUM('VIC','NSW','QLD','NT','WA','SA','TAS','ACT'),
        postcode CHAR(4),
        email VARCHAR(100),
        phone VARCHAR(12),
        skill1 VARCHAR(50),
        skill2 VARCHAR(50),
        other_skills TEXT,
        status ENUM('New','Current','Final') DEFAULT 'New'
    )";
    mysqli_query($conn, $create_table_query);
}

// Validation
$errors = [];
if (!preg_match("/^[a-zA-Z]{1,20}$/", $first_name)) $errors[] = "Invalid first name.";
if (!preg_match("/^[a-zA-Z]{1,20}$/", $last_name)) $errors[] = "Invalid last name.";
if (!preg_match("/^\d{2}\/\d{2}\/\d{4}$/", $dob)) $errors[] = "Invalid date of birth format.";
if (!in_array($gender, ['male', 'female', 'other'])) $errors[] = "Invalid gender selected.";
if (!preg_match("/^\d{4}$/", $postcode)) $errors[] = "Postcode must be 4 digits.";
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Invalid email format.";
if (!preg_match("/^[0-9 ]{8,12}$/", $phone)) $errors[] = "Phone number must be 8-12 digits or spaces.";
if (!in_array($state, ['VIC','NSW','QLD','NT','WA','SA','TAS','ACT'])) $errors[] = "Invalid state selected.";
if (empty($skill1)) $errors[] = "At least one technical skill must be selected.";

// If there are errors, show them and exit
if (!empty($errors)) {
    echo "<main><h2>Validation Errors</h2><ul>";
    foreach ($errors as $error) {
        echo "<li>$error</li>";
    }
    echo "</ul><a href='apply.php'>Go back and fix them</a></main>";
    require_once 'footer.inc';
    exit();
}

// Insert into database
$insert_query = "INSERT INTO eoi (
    job_ref_number, first_name, last_name, dob, gender,
    street_address, suburb, state, postcode,
    email, phone, skill1, skill2, other_skills
) VALUES (
    '$job_ref_number', '$first_name', '$last_name', '$dob', '$gender',
    '$street_address', '$suburb', '$state', '$postcode',
    '$email', '$phone', '$skill1', '$skill2', '$other_skills'
)";
$insert_result = mysqli_query($conn, $insert_query);

if ($insert_result) {
    $newEoiNumber = mysqli_insert_id($conn);
} else {
    die("<main><p>Failed to submit your application. 🥶 Please try again later.</p></main>");
}

mysqli_close($conn);
?>

<main class="confirmation-section">
    <h1>Application Received</h1>
    <p>Thanks for applying! Your EOI number is: <strong><?php echo $newEoiNumber; ?></strong></p>
    <a href="jobs.php" class="primary-button">Back to Jobs</a>
</main>

<?php require_once 'footer.inc'; ?>