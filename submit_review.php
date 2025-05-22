<?php
require_once 'header.inc';
require_once 'nav.inc';
require_once 'settings.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = htmlspecialchars(trim($_POST['name']));
    $comment = htmlspecialchars(trim($_POST['comment']));
    $stars = intval($_POST['stars']);

    if ($name && $comment && $stars > 0 && $stars <= 5) {
        $conn = mysqli_connect($host, $user, $pwd, $sql_db);
        if ($conn) {
            $stmt = mysqli_prepare($conn, "INSERT INTO reviews (name, comment, stars) VALUES (?, ?, ?)");
            mysqli_stmt_bind_param($stmt, "ssi", $name, $comment, $stars);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
            mysqli_close($conn);
            header("Location: reviews.php");
            exit();
        } else {
            echo "<p style='color:red;'>Database connection error.</p>";
        }
    } else {
        echo "<p style='color:red;'>Please fill in all fields properly.</p>";
    }
}
?>

<main class="application-section">
    <h1 class="section-headline">Leave a Review</h1>
    <form action="submit_review.php" method="post" class="form-container">
        <div class="form-grid">
            <div class="form-group full-width">
                <label for="name">Your Name</label>
                <input type="text" name="name" id="name" required maxlength="50">
            </div>
            <div class="form-group full-width">
                <label for="comment">Your Feedback</label>
                <textarea name="comment" id="comment" rows="4" required></textarea>
            </div>
            <div class="form-group full-width">
                <label for="stars">Rating</label>
                <select name="stars" id="stars" required>
                    <option value="">Select rating</option>
                    <option value="5">⭐️⭐️⭐️⭐️⭐️</option>
                    <option value="4">⭐️⭐️⭐️⭐️</option>
                    <option value="3">⭐️⭐️⭐️</option>
                    <option value="2">⭐️⭐️</option>
                    <option value="1">⭐️</option>
                </select>
            </div>
            <div class="form-group full-width">
                <button type="submit" class="primary-button">Submit Review</button>
            </div>
        </div>
    </form>
</main>

<?php require_once 'footer.inc'; ?>