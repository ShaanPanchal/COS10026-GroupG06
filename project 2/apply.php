<?php
$pageTitle = "Apply for Position | SRN Careers";
require_once 'header.inc';
require_once 'nav.inc';
?>

<section class="application-section">
    <div class="form-container">
        <h1 class="section-headline">Application Form</h1>
        <p class="section-subhead">Complete the form below to apply for the position</p>

        <form id="application-form" action="process_eoi.php" method="POST" enctype="multipart/form-data" novalidate="novalidate">
            <div class="form-grid">
                <!-- All your form fields here -->
                <div class="form-group full-width">
                    <button type="submit" class="primary-button large">Submit Application</button>
                </div>
            </div>
        </form>
    </div>
</section>

<?php require_once 'footer.inc'; ?>