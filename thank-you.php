<?php
session_start();
$pageTitle = "Thank You | SRN Careers";
require_once 'header.inc';
require_once 'nav.inc';
?>

<!-- Thank You Section -->
<section class="thank-you-section">
  <div class="thank-you-icon">✓</div>
  <h1 class="large-title">Thank You for Applying</h1>

  <?php if (isset($_SESSION['last_eoi_number'])): ?>
    <div class="confirmation-number">
      <p>🐣 Wooohooo !! your application has been succesfully sumitted 🥳. <br> 🤩 And now is in processing !!! <br> please keep checking your status for updates !!! ✌️ <br> your current applicant number is :</p>
      <div class="eoi-number"><?php echo $_SESSION['last_eoi_number']; ?></div>
    </div>
    <div class="confirmation-number">
      <p>Your login username is:</p>
      <div class="eoi-number"><?php echo $_SESSION['generated_username']; ?></div>
    </div>
    <div class="confirmation-number">
      <p>Your temporary password is:</p>
      <div class="eoi-number"><?php echo $_SESSION['generated_password']; ?></div>
      <p class="subtitle-note">Please keep it safe to view your application status.</p>
    </div>
    <?php unset($_SESSION['last_eoi_number']); unset($_SESSION['generated_username']); unset($_SESSION['generated_password']); ?>
  <?php else: ?>
    <p class="subtitle-note">You seem to have landed here by mistake. 😅</p>
  <?php endif; ?>

  <a href="jobs.php" class="primary-button large">View Other Positions</a>
</section>

<?php require_once 'footer.inc'; ?>
