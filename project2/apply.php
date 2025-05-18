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
      <form action="process_eoi.php" method="POST" novalidate>
        <div class="form-grid">

          <!-- Job Reference -->
          <div class="form-group full-width">
            <label for="job_ref_number">Job Reference</label>
            <select id="job_ref_number" name="job_ref_number" required>
              <option value="">Select Job Reference</option>
              <?php
              $conn = mysqli_connect($host, $user, $pwd, $sql_db);
              if ($conn) {
                $query = "SELECT job_reference FROM jobs";
                $result = mysqli_query($conn, $query);
                while ($row = mysqli_fetch_assoc($result)) {
                  $selected = ($row['job_reference'] == $selectedJobRef) ? 'selected' : '';
                  echo '<option value="' . htmlspecialchars($row['job_reference']) . '" ' . $selected . '>' . htmlspecialchars($row['job_reference']) . '</option>';
                }
                mysqli_close($conn);
              }
              ?>
            </select>
          </div>

          <!-- First Name -->
          <div class="form-group">
            <label for="first_name">First Name</label>
            <input type="text" id="first_name" name="first_name" maxlength="20" required placeholder="Enter your first name" />
          </div>

          <!-- Last Name -->
          <div class="form-group">
            <label for="last_name">Last Name</label>
            <input type="text" id="last_name" name="last_name" maxlength="20" required placeholder="Enter your last name" />
          </div>

          <!-- Address -->
          <div class="form-group full-width">
            <label for="street_address">Street Address</label>
            <input type="text" id="street_address" name="street_address" maxlength="40" required placeholder="123 Example Street" />
          </div>

          <div class="form-group">
            <label for="suburb">Suburb</label>
            <input type="text" id="suburb" name="suburb" maxlength="40" required placeholder="Enter your suburb" />
          </div>

          <div class="form-group">
            <label for="state">State</label>
            <select id="state" name="state" required>
              <option value="" disabled selected>Select State</option>
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
            <input type="text" id="postcode" name="postcode" maxlength="4" required placeholder="e.g. 3000" />
          </div>

          <!-- Contact Info -->
          <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" required placeholder="example@email.com" />
          </div>

          <div class="form-group">
            <label for="phone">Phone</label>
            <input type="tel" id="phone" name="phone" pattern="[0-9 ]{8,12}" required placeholder="e.g. 0412 345 678" />
          </div>

          <!-- Skills -->
          <div class="form-group full-width">
            <label for="skill1">Required Skills</label>
            <select id="skill1" name="skill1" required>
              <option value="" disabled selected>Select a skill</option>
              <option value="HTML">HTML</option>
              <option value="CSS">CSS</option>
              <option value="JavaScript">JavaScript</option>
              <option value="PHP">PHP</option>
              <option value="MySQL">MySQL</option>
              <option value="Python">Python</option>
              <option value="Java">Java</option>
              <option value="Git">Git</option>
              <option value="React">React</option>
              <option value="Node.js">Node.js</option>
              <option value="None">Not looking good fo you! (none??)</option>
            </select>
          </div>

          <div class="form-group full-width">
            <label for="skill2">Other Skill (optional)</label>
            <input type="text" id="skill2" name="skill2" placeholder="e.g. Bootstrap or Figma" />
          </div>

          <div class="form-group full-width">
            <label for="other_skills">Other Skills</label>
            <textarea id="other_skills" name="other_skills" rows="4" placeholder="Mention any additional skills or certifications..."></textarea>
          </div>

          <!-- Submit -->
          <div class="form-group full-width">
            <button type="submit" class="primary-button">Submit Application</button>
          </div>

        </div> <!-- close form-grid -->
      </form>
    </div>
  </section>
</main>

<?php require_once 'footer.inc'; ?>