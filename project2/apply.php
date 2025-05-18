<?php
$pageTitle = "Apply for Position | SRN Careers";
require_once 'header.inc';
require_once 'nav.inc';
require_once 'settings.php';

$selectedJobRef = isset($_GET['job_ref']) ? htmlspecialchars($_GET['job_ref']) : '';
?>

<main>
  <section class="application-section">
    <h1 class="section-headline">Application Form</h1>
    <div class="form-container">
      <?php
        include 'form_top.inc';     // Contains <form> start and Job Reference
        include 'form_fields.inc';  // Contains all personal + contact + skills inputs
        include 'form_submit.inc';  // Contains the submit button and closing tags
      ?>
    </div>
  </section>
</main>

<?php require_once 'footer.inc'; ?>