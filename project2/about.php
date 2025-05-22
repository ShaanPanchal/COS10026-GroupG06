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
    <h2 class="hero-headline">listen to the authors!</h2>
    <section class="team-contributions">
  <div class="team-grid">
    <!-- Shaan Card -->
    <article class="team-card">
      <h3>Shaan</h3>
      <details class="team-description">
        <summary>View Description</summary>
        <p>
          In this project, I modularised the website structure by converting common HTML elements—such as the header, footer, and navigation menu—into separate PHP include files (<code>header.inc</code>, <code>footer.inc</code>, <code>nav.inc</code>) for improved maintainability and consistency.
        </p>
        <p>
          I developed <code>process_eoi.php</code> to securely handle form submissions with server-side validation. Successful submissions return a confirmation message with the auto-generated EOInumber.
        </p>
        <p>
          I also created a project presentation to communicate the structure, features, and accessibility of the site.
        </p>
      </details>
    </article>

    <!-- Neeven Card -->
    <article class="team-card">
      <h3>Neeven</h3>
      <details class="team-description">
        <summary>View Description</summary>
        <p>
          I implemented the backend database and built the management interface. I created the <code>EOI</code> and <code>jobs</code> tables, including fields like auto-generated <strong>EOInumber</strong> and <strong>stage</strong> to track progress.
        </p>
        <p>
          I also built <code>manage.php</code> for HR to view, search, filter, and update EOIs efficiently.
        </p>
        <p>
          I ensured <strong>accessibility</strong> throughout the site—semantic HTML, alt text, keyboard navigation, and readable fonts to support inclusive design.
        </p>
      </details>
    </article>
  </div>
</section>

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
      <a href="enhancements.php" class="primary-button large">Check Our Enhancements 🚀</a>
    </section>
    <a href="reviews.php"><h2 class="hero-headline">Reviews</h2></a>
  </section>
</main>

<?php require_once 'footer.inc'; ?>