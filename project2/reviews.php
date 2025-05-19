<?php
$pageTitle = "Reviews | SRN Careers";
require_once 'header.inc';
require_once 'nav.inc';
require_once 'settings.php';

$conn = mysqli_connect($host, $user, $pwd, $sql_db);
?>

<section class="review-section">
  <h1 class="review-title">⭐️ REVIEWS ⭐️</h1>
  <div class="review-grid">
    <?php
    if ($conn) {
      $query = "SELECT * FROM reviews";
      $result = mysqli_query($conn, $query);

      if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
          echo '<div class="review-card">';
          echo htmlspecialchars($row['review_text']) . '<br>';
          echo str_repeat('⭐️', (int)$row['rating']);
          echo "<br>— " . htmlspecialchars($row['reviewer_name']);
          echo '</div>';
        }
      } else {
        echo "<p>No reviews yet, be the first to leave one!</p>";
      }

      mysqli_close($conn);
    } else {
      echo "<p>Could not load reviews. Please try again later.</p>";
    }
    ?>
  </div>
</section>

<?php require_once 'footer.inc'; ?>