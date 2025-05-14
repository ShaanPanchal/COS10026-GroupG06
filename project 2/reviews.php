<?php
$pageTitle = "Reviews | SRN Careers";
require_once 'header.inc';
require_once 'nav.inc';
?>

<section class="review-section">
    <h1 class="review-title">⭐️ REVIEWS ⭐️</h1>
    <div class="review-grid">
        <?php
        // Database connection if you want to load reviews from DB
        require_once 'settings.php';
        $conn = mysqli_connect($host, $user, $pwd, $sql_db);
        
        if ($conn) {
            $query = "SELECT * FROM reviews ORDER BY date_added DESC";
            $result = mysqli_query($conn, $query);
            
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo '<div class="review-card">';
                    echo '“' . htmlspecialchars($row['review_text']) . '” — ' . htmlspecialchars($row['reviewer_name']);
                    echo '<br>' . str_repeat('⭐️', $row['rating']);
                    echo '</div>';
                }
            } else {
                // Fallback to static reviews if DB is empty
                include 'static_reviews.inc';
            }
            mysqli_close($conn);
        } else {
            // Fallback to static reviews if DB connection fails
            include 'static_reviews.inc';
        }
        ?>
    </div>
</section>

<?php require_once 'footer.inc'; ?>