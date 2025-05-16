<?php
$pageTitle = "Job Listings | SRN Careers";
require_once 'header.inc';
require_once 'nav.inc';
require_once 'settings.php';
?>

<main>
  <section class="job-listings">
    <h1 class="hero-headline">Job Descriptions</h1>
    <div class="job-container">

      <?php
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

        echo '<p>🧭 Availability:</p>';
        echo '<ul class="job-availability">';
        echo '<li>' . (strpos($row['location'], 'Melbourne') !== false ? 'In Person' : 'Virtually') . '</li>';
        echo '</ul>';

        echo '<div class="job-footer">';
        echo '<details class="job-description">';
        echo '<summary>View Description</summary>';
        echo '<div>';

        // Description
        echo '<p>' . nl2br(htmlspecialchars($row['job_description'])) . '</p>';

        // Main Tasks
        if (!empty($row['main_tasks'])) {
          echo '<strong>Main Tasks:</strong>';
          echo '<ol>';
          foreach (explode("\n", $row['main_tasks']) as $task) {
            echo '<li>' . htmlspecialchars(trim($task)) . '</li>';
          }
          echo '</ol>';
        }

        // Key Responsibilities
        if (!empty($row['key_responsibilities'])) {
          echo '<strong>Key Responsibilities:</strong>';
          echo '<ul>';
          foreach (explode("\n", $row['key_responsibilities']) as $res) {
            echo '<li>' . htmlspecialchars(trim($res)) . '</li>';
          }
          echo '</ul>';
        }

        // Qualifications
        if (!empty($row['qualifications'])) {
          echo '<strong>Qualifications:</strong>';
          echo '<ul>';
          foreach (explode("\n", $row['qualifications']) as $qual) {
            echo '<li>' . htmlspecialchars(trim($qual)) . '</li>';
          }
          echo '</ul>';
        }

        // Essential Requirements (keep if you're still using it separately)
        if (!empty($row['essential_requirements'])) {
          echo '<strong>Essential Requirements:</strong>';
          echo '<ul>';
          foreach (explode("\n", $row['essential_requirements']) as $item) {
            echo '<li>' . htmlspecialchars(trim($item)) . '</li>';
          }
          echo '</ul>';
        }

        // Skills Table (rendered raw HTML)
        if (!empty($row['skills_table'])) {
          echo '<strong>Required Skills:</strong>';
          echo $row['skills_table'];
        }

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