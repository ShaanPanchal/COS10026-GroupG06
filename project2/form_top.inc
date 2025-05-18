


<form action="process_eoi.php" method="POST" novalidate>
  <div class="form-grid">

    <!-- Job Reference -->
    <div class="form-group full-width">
      <label for="job_ref_number">Job Reference</label>
      <select id="job_ref_number" name="job_ref_number" required>
        <option value="">Select Job Reference</option>
        <?php
        $selectedJobRef = $selectedJobRef ?? ''; 
        $conn = mysqli_connect($host, $user, $pwd, $sql_db);
        if ($conn) {
          $query = "SELECT job_reference FROM jobs";
          $result = mysqli_query($conn, $query);
          while ($row = mysqli_fetch_assoc($result)) {
            $selected = ($row['job_reference'] == $selectedJobRef) ? 'selected' : '';
            echo '<option value="' . htmlspecialchars($row['job_reference']) . '" ' . $selected . '>' . htmlspecialchars($row['job_reference']) . '</option>';
          }
          mysqli_close($conn);
        } else {
          echo '<option value="">Database connection error</option>';
        }
        ?>
      </select>
    </div>