<?php
$pageTitle = "Apply for Position | SRN Careers";
require_once 'header.inc';
require_once 'nav.inc';
require_once 'settings.php'; // Database connection

// Get job reference from URL if present
$selectedJobRef = isset($_GET['job_ref']) ? htmlspecialchars($_GET['job_ref']) : '';
?>

<!-- Application Form Section -->
<section class="application-section">
    <div class="form-container">
        <h1 class="section-headline">Application Form</h1>
        <p class="section-subhead">Complete the form below to apply for the position</p>

        <form id="application-form" action="process_eoi.php" method="POST" enctype="multipart/form-data" novalidate="novalidate">
            <div class="form-grid">

                <!-- Job Reference -->
                <div class="form-group full-width">
                    <label for="job-ref">Job Reference Number</label>
                    <select id="job-ref" name="job_ref" required>
                        <option value="">Select job reference</option>
                        <?php
                        // Connect to database and fetch job references
                        $conn = mysqli_connect($host, $user, $pwd, $sql_db);
                        if ($conn) {
                            $query = "SELECT job_reference FROM jobs";
                            $result = mysqli_query($conn, $query);
                            
                            while ($row = mysqli_fetch_assoc($result)) {
                                $selected = ($row['job_reference'] == $selectedJobRef) ? 'selected' : '';
                                echo '<option value="' . htmlspecialchars($row['job_reference']) . '" ' . $selected . '>' 
                                     . htmlspecialchars($row['job_reference']) . '</option>';
                            }
                            mysqli_close($conn);
                        }
                        ?>
                    </select>
                </div>

                <!-- First and Last Name -->
                <div class="form-group">
                    <label for="first-name">First Name</label>
                    <input type="text" id="first-name" name="first_name" maxlength="20" pattern="[A-Za-z\s]+" required />
                </div>

                <div class="form-group">
                    <label for="last-name">Last Name</label>
                    <input type="text" id="last-name" name="last_name" maxlength="20" pattern="[A-Za-z\s]+" required />
                </div>

                <!-- DOB -->
                <div class="form-group">
                    <label for="dob">Date of Birth</label>
                    <input type="text" id="dob" name="dob" placeholder="dd/mm/yyyy" pattern="\d{2}/\d{2}/\d{4}" required />
                </div>

                <!-- Gender -->
                <div class="form-group full-width">
                    <fieldset>
                        <legend>Gender</legend>
                        <label><input type="radio" name="gender" value="male" required /> Male</label>
                        <label><input type="radio" name="gender" value="female" /> Female</label>
                        <label><input type="radio" name="gender" value="other" /> Other</label>
                    </fieldset>
                </div>

                <!-- Address -->
                <div class="form-group">
                    <label for="street">Street Address</label>
                    <input type="text" id="street" name="street_address" maxlength="40" required />
                </div>

                <div class="form-group">
                    <label for="suburb">Suburb/Town</label>
                    <input type="text" id="suburb" name="suburb_town" maxlength="40" required />
                </div>

                <!-- State and Postcode -->
                <div class="form-group">
                    <label for="state">State</label>
                    <select id="state" name="state" required>
                        <option value="">Select state</option>
                        <option value="VIC">VIC</option>
                        <option value="NSW">NSW</option>
                        <option value="QLD">QLD</option>
                        <option value="NT">NT</option>
                        <option value="WA">WA</option>
                        <option value="SA">SA</option>
                        <option value="TAS">TAS</option>
                        <option value="ACT">ACT</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="postcode">Postcode</label>
                    <input type="text" id="postcode" name="postcode" pattern="\d{4}" maxlength="4" required />
                </div>

                <!-- Contact -->
                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input type="email" id="email" name="email" required />
                </div>

                <div class="form-group">
                    <label for="phone">Phone Number</label>
                    <input type="tel" id="phone" name="phone" pattern="[0-9 ]{8,12}" required />
                </div>

                <!-- Skills -->
                <div class="form-group full-width">
                    <fieldset>
                        <legend>Technical Skills</legend>
                        <label><input type="checkbox" name="skills[]" value="HTML" /> HTML</label>
                        <label><input type="checkbox" name="skills[]" value="CSS" /> CSS</label>
                        <label><input type="checkbox" name="skills[]" value="JavaScript" /> JavaScript</label>
                        <label><input type="checkbox" name="skills[]" value="Python" /> Python</label>
                    </fieldset>
                </div>

                <!-- Other Skills -->
                <div class="form-group full-width">
                    <label for="other-skills">Other Skills</label>
                    <textarea id="other-skills" name="other_skills" rows="4"></textarea>
                </div>

                <!-- Resume Upload-->
                <div class="form-group full-width">
                    <label for="resume">Upload Resume</label>
                    <input type="file" id="resume" name="resume" accept=".pdf,.doc,.docx" required />
                </div>

                <!--Submit Button -->
                <div class="form-group full-width">
                    <button type="submit" class="primary-button large">Submit Application</button>
                </div>

            </div>
        </form>
    </div>
</section>

<?php require_once 'footer.inc'; ?>