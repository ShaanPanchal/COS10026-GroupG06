<?php
$pageTitle = "Apply for Position | SRN Careers";
require_once 'header.inc';
require_once 'nav.inc';
require_once 'settings.php';

$selectedJobRef = isset($_GET['job_ref']) ? htmlspecialchars($_GET['job_ref']) : '';
?>

<main>
  <section class="application-section">
    <h1 class="hero-headline">Application Form</h1>
    <div class="form-container">
      <?php
        include 'form_top.inc';     
        include 'form_fields.inc';  
        include 'form_submit.inc';  
      ?>
    </div>
  </section>
</main>

<?php require_once 'footer.inc'; ?>