<?php
$pageTitle = "Job Listings | SRN Careers";
require_once 'header.inc';
require_once 'nav.inc';
require_once 'settings.php'; // Database connection
?>

<main>
    <section class="job-listings">
        <h1 class="hero-headline">Job Descriptions</h1>
        <h2 class="hero-subhead">CLOUD ENGINEERS</h2>
        <div class="job-container">

            <?php
            // Connect to database and fetch jobs
            $conn = mysqli_connect($host, $user, $pwd, $sql_db);
            if (!$conn) {
                die("Connection failed: " . mysqli_connect_error());
            }

            $query = "SELECT * FROM jobs";
            $result = mysqli_query($conn, $query);

            while ($row = mysqli_fetch_assoc($result)) {
                echo '<article class="job-card">';
                echo '<h3>' . htmlspecialchars($row['job_title']) . '<br>' . htmlspecialchars($row['job_reference']) . '</h3>';
                echo '<p>📍 ' . htmlspecialchars($row['location']) . '</p>';
                echo '<p>⏰ ' . htmlspecialchars($row['position_type']) . '</p>';
                echo '<p>💰 ' . htmlspecialchars($row['salary_range']) . '</p>';
                
                // Availability (you might need to adjust this based on your DB structure)
                echo '<p>🧭 Availability:</p>';
                echo '<ul class="job-availability">';
                echo '<li>' . (strpos($row['location'], 'Melbourne') !== false ? 'In Person' : 'Virtually') . '</li>';
                echo '</ul>';
                
                echo '<div class="job-footer">';
                echo '<details class="job-description">';
                echo '<summary>View Description</summary>';
                echo '<div>';
                echo '<p>' . htmlspecialchars($row['job_description']) . '</p>';
                
                echo '<strong>Key Responsibilities:</strong>';
                echo '<ul>';
                $responsibilities = explode("\n", $row['key_responsibilities']);
                foreach ($responsibilities as $item) {
                    echo '<li>' . htmlspecialchars(trim($item)) . '</li>';
                }
                echo '</ul>';
                
                echo '<strong>Essential Requirements:</strong>';
                echo '<ul>';
                $requirements = explode("\n", $row['essential_requirements']);
                foreach ($requirements as $item) {
                    echo '<li>' . htmlspecialchars(trim($item)) . '</li>';
                }
                echo '</ul>';
                
                echo '</div>';
                echo '</details>';
                echo '<a href="apply.php?job_ref=' . urlencode($row['job_reference']) . '" class="apply-btn">Apply</a>';
                echo '</div>';
                echo '</article>';
            }
            
            mysqli_close($conn);
            ?>
        </div>
    </section>
</main>

<aside>
    <section>
        <a href="about.php">
            <h3 class="hero-headline">Why Join Us?</h3>
            <p>We offer competitive salaries, flexible work arrangements, and opportunities for career growth in the IT industry.</p>
        </a>
    </section>
</aside>

<?php require_once 'footer.inc'; ?>