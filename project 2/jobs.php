<?php
$pageTitle = "Job Descriptions | SRN Careers";
require_once 'header.inc';
require_once 'nav.inc';
?>

<main>
    <section class="job-listings">
        <h1 class="hero-headline">Job description</h1>
        <h2 class="hero-subhead">CLOUD ENGINEERS</h2>
        <div class="job-container">

            <article class="job-card">
                <h3>Software Engineer<br>SOFT303</h3>
                <p>📍 Melbourne&comma; VIC</p>
                <p>⏰ Full time</p>
                <p>💰 180,000</p>
                <p>🧭 Availability:</p>
                <ul class="job-availability">
                    <li>In Person</li>
                    <br>
                    <li>Virtually</li>
                </ul>
                <div class="job-footer">
                    <details class="job-description">
                        <summary>View Description</summary>
                        <div>
                            <p>We are looking for a Software Engineer to design and build scalable cloud-native applications...</p>
                            <!-- Rest of job description content -->
                        </div>
                    </details>
                    <a href="apply.php" class="apply-btn">Apply</a>
                </div>
            </article>

            <!-- Other job cards here -->

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