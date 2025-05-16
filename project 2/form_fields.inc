<!-- First Name -->
<div class="form-group">
  <label for="first_name">First Name</label>
  <input type="text" id="first_name" name="first_name" maxlength="20" required />
</div>

<!-- Last Name -->
<div class="form-group">
  <label for="last_name">Last Name</label>
  <input type="text" id="last_name" name="last_name" maxlength="20" required />
</div>

<!-- Address -->
<div class="form-group full-width">
  <label for="street_address">Street Address</label>
  <input type="text" id="street_address" name="street_address" maxlength="40" required />
</div>

<div class="form-group">
  <label for="suburb">Suburb</label>
  <input type="text" id="suburb" name="suburb" maxlength="40" required />
</div>

<div class="form-group">
  <label for="state">State</label>
  <select id="state" name="state" required>
    <option value="">Select State</option>
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
  <input type="text" id="postcode" name="postcode" maxlength="4" required />
</div>

<!-- Contact Info -->
<div class="form-group">
  <label for="email">Email</label>
  <input type="email" id="email" name="email" required />
</div>

<div class="form-group">
  <label for="phone">Phone</label>
  <input type="tel" id="phone" name="phone" pattern="[0-9 ]{8,12}" required />
</div>

<!-- Skills -->
<div class="form-group full-width">
  <label for="skill1">Skill 1</label>
  <input type="text" id="skill1" name="skill1" required />
</div>

<div class="form-group full-width">
  <label for="skill2">Skill 2</label>
  <input type="text" id="skill2" name="skill2" />
</div>

<div class="form-group full-width">
  <label for="other_skills">Other Skills</label>
  <textarea id="other_skills" name="other_skills" rows="4"></textarea>
</div>