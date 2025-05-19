<?php
$pageTitle = "About Us | SRN Careers";
require_once 'header.inc';
require_once 'nav.inc';
require_once 'settings.php';

$conn = mysqli_connect($host, $user, $pwd, $sql_db);
?>

<main class="application-section">
    <h1 class="hero-headline">About Us</h1>

    <section class="paragraph">
        <h2 class="section-headline">Redefining Talent Excellence</h2>
        <p>At SRN Careers, we bridge exceptional talent with visionary organizations through strategic recruitment solutions. Founded in 2025, we combine cutting-edge tech with human insight.</p>
    </section>

    <?php
    if ($conn) {
        $query = "SELECT section_title, content FROM about_content";
        $result = mysqli_query($conn, $query);
        while ($row = mysqli_fetch_assoc($result)) {
            echo '<section class="paragraph">';
            echo '<h2 class="section-headline">' . htmlspecialchars($row['section_title']) . '</h2>';
            echo '<p>' . nl2br(htmlspecialchars($row['content'])) . '</p>';
            echo '</section>';
        }
        mysqli_close($conn);
    } else {
        echo "<p>Couldn't load content 😢</p>";
    }
    ?>

    <a class="contact-us-in-headings" href="mailto:careers@srn.com">Contact Our Team</a>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <a class="explore-open-roles" href="jobs.php">Explore Open Roles</a>

    <ul class="social-icons">
        <li><img src="images/twitter.png" alt="twitter" width="85"></li>
        <li><img src="images/telegram.png" alt="telegram" width="85"></li>
        <li><img src="images/youtube.png" alt="youtube" width="85"></li>
        <li><img src="images/inst.png" alt="inst" width="80"></li>
    </ul>

    <figure id="group-img">
        <img src="images/group-img.png" alt="Group Photo">
        <figcaption>Captured during brainstorming session in late-lab</figcaption>
    </figure>

    <h2 class="section-headline">Meet Our Group</h2>
    <ul class="gets">
        <li><strong>Group Name:</strong> SRN Careers</li>
        <li><strong>Class Time:</strong> Every Monday</li>
        <li><strong>Student IDs:</strong>
            <ul class="getys">
                <li>105229389 : Neeven</li>
                <li>105912281 : Shaan</li>
            </ul>
        </li>
        <li><strong>Tutor:</strong> Nick</li>
    </ul>

    <h2 class="section-headline">Team Contributions</h2>
    <dl>
        <dt>Shaan</dt><dd class="rolies">Job application, homepage</dd>
        <dt>Neeven</dt><dd class="rolies">Job description, about page</dd>
    </dl>

    <table class="table-of-members">
        <caption>What Drives Us</caption>
        <tr><th>Name</th><th>Interest</th><th>Details</th></tr>
        <tr><td rowspan="2">Neeven</td><td>Formula 1</td><td><a id="lewis-hamilton" href="https://www.ferrari.com/en-EN/formula1" target="_blank">Ferrari</a></td></tr>
        <tr><td>Music</td><td>Loves listening to music</td></tr>
        <tr><td>Shaan</td><td>Gaming</td><td>Competitive shooter games</td></tr>
    </table>
</main>

<?php require_once 'footer.inc'; ?>