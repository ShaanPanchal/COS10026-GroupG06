<?php
$pageTitle = "About Us | SRN Careers";
require_once 'header.inc';
require_once 'nav.inc';
require_once 'settings.php';
?>

<main class="main-content">
  <section class="about-section">
    <h1 class="hero-headline">About Us</h1>

    <?php
    $conn = mysqli_connect($host, $user, $pwd, $sql_db);
    if (!$conn) {
        echo "<p class='paragraph'>Database connection failed. 😔</p>";
    } else {
        $query = "SELECT * FROM about_info";
        $result = mysqli_query($conn, $query);
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<h2 class='section-headline'>" . htmlspecialchars($row['section_title']) . "</h2>";
            echo "<p class='paragraph'>" . nl2br(htmlspecialchars($row['section_content'])) . "</p>";
        }
        mysqli_close($conn);
    }
    ?>

    <!-- Static Team Info from Project 1 -->
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
    <p>Why Teamwork is a Must?</p>
    <p class="paragraph">Teamwork combines strengths and creativity, improves communication, and helps overcome challenges faster.</p>
    <dl>
      <dt>Shaan</dt><div class="rolies"><dd>Job application, homepage</dd></div>
      <dt>Neeven</dt><div class="rolies"><dd>Job description, about page</dd></div>
    </dl>

    <h2 class="section-headline">Our Team Photo</h2>
    <figure id="group-img">
      <img src="images/group-img.png" alt="Group Photo" id="group-img" class="rounded-img">
      <figcaption>Captured during brainstorming session in late-lab</figcaption>
    </figure>

    <h2 class="section-headline">Member Interests</h2>
    <table class="table-of-members">
      <caption>What Drives Us</caption>
      <tr><th>Name</th><th>Interest</th><th>Details</th></tr>
      <tr><td rowspan="2">Neeven</td><td>Formula 1</td><td><a id="lewis-hamilton" href="https://www.ferrari.com/en-EN/formula1" target="_blank">Ferrari</a></td></tr>
      <tr><td>Music</td><td>Loves listening to music</td></tr>
      <tr><td>Shaan</td><td>Gaming</td><td>Competitive shooter games</td></tr>
    </table>

    <h2 class="section-headline">More About Us</h2>
    <section class="more-about-us">
      <h2>Additional Information</h2>
      <ul class="gets">
        <li>All members are first-year IT students based in Melbourne</li>
        <li>We enjoy building cool and responsive websites</li>
        <li>Favourite books: <em>Clean Code, The Pragmatic Programmer</em></li>
        <li>Favourite music: Rap, Lo-Fi</li>
      </ul>
    </section>
    <a href="reviews.php"><h2 class="hero-headline">Reviews</h2></a>
  </section>
</main>

<?php require_once 'footer.inc'; ?>