<?php
$pageTitle = "Public Reviews";
require_once 'header.inc';
require_once 'nav.inc';
require_once 'settings.php';

$conn = mysqli_connect($host, $user, $pwd, $sql_db);
?>

<section class="review-section">
    <h1 class="review-title">⭐️ What People Are Saying ⭐️</h1>
    <div class="review-grid">
        <?php
        if ($conn) {
            $query = "SELECT name, comment, stars FROM reviews ORDER BY id DESC";
            $result = mysqli_query($conn, $query);
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo '<div class="review-card">';
                    echo htmlspecialchars($row['comment']) . "<br>— <strong>" . htmlspecialchars($row['name']) . "</strong><br>";
                    echo str_repeat("⭐️", intval($row['stars']));
                    echo "</div>";
                }
            } else {
                echo "<p>No reviews yet. Be the first to leave one!</p>";
            }
            mysqli_close($conn);
        } else {
            echo "<p>Could not load reviews.</p>";
        }
        ?>
    </div>
</section>

<?php require_once 'footer.inc'; ?>