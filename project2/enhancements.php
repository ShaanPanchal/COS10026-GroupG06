<?php
session_start();
$pageTitle = "Enhancements | SRN Careers";
require_once 'header.inc';
require_once 'nav.inc';
?>

<main class="application-section">
  <div class="form-container">
    <h1 class="hero-headline">✨ Project Enhancements</h1>

    <section class="enhancement-block">
      <h2 class="section-headline">🔐 User Login System</h2>
      <p class="paragraph">Applicants receive a unique auto-generated <strong>username and password</strong> after submitting an application. This enables them to log in and view their application status at any time securely.</p>
    </section>

    <section class="enhancement-block">
      <h2 class="section-headline">🧠 HR Manager Dashboard</h2>
      <p class="paragraph">An exclusive login system for HR managers allows them to <strong>view all EOIs</strong>, <strong>update status</strong>, and see complete application details. This enhances admin control and tracking.</p>
    </section>

    <section class="enhancement-block">
      <h2 class="section-headline">📊 Stage Tracking</h2>
      <p class="paragraph">A new ENUM column <code>stage</code> is used in the EOI table to reflect the stage of each application: <strong>New, Current, Final</strong>. It updates based on manager actions for easy sorting.</p>
    </section>

    <section class="enhancement-block">
      <h2 class="section-headline">📝 Validation Based on State & Postcode</h2>
      <p class="paragraph">Postcodes are now validated based on selected states. If the state is Victoria, only VIC-valid postcode ranges are accepted, ensuring proper address data integrity.</p>
    </section>

    <section class="enhancement-block">
      <h2 class="section-headline">🌟 Reviews Module</h2>
      <p class="paragraph">A new review feature allows users to submit feedback that gets stored in the database and shown dynamically on the site. This adds a community vibe and social proof.</p>
    </section>

    <section class="enhancement-block">
      <h2 class="section-headline">📸 Team Photo Styling</h2>
      <p class="paragraph">Team image on the about page is now displayed with a <strong>rounded circle effect</strong> to create a more polished and modern design.</p>
    </section>

    <section class="enhancement-block">
      <h2 class="section-headline">🔐 Unique Applicant Login Credentials</h2>
      <p class="paragraph">
      A <strong>unique username and password</strong> is automatically generated for every applicant upon submission. These credentials allow users to securely log in and view the status of their application. This enhancement improves data privacy and gives applicants a seamless way to track their progress.
      </p>
      </section>
    <a href="index.php" class="primary-button">⬅️ Back to Home</a>
  </div>
</main>

<?php require_once 'footer.inc'; ?>
