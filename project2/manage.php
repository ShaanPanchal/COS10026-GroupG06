<?php
session_start();
$pageTitle = "Manage EOIs";
require_once 'header.inc';
require_once 'nav.inc';
require_once 'settings.php';

// Access protection
if (!isset($_SESSION['manager_logged_in']) || $_SESSION['manager_logged_in'] !== true) {
    header("Location:manager_login.php");
    exit();
}

$conn = mysqli_connect($host, $user, $pwd, $sql_db);
if (!$conn) {
    die("<main><p class='error-msg'>Failed to connect to the database.</p></main>");
}

$query = "SELECT * FROM eoi ORDER BY EOInumber DESC";
$result = mysqli_query($conn, $query);
?>

<main class="mgmt-container">
  <h1 class="mgmt-title">EOI Management</h1>

  <table class="mgmt-table">
    <thead>
      <tr>
        <th>EOI#</th>
        <th>Job Ref</th>
        <th>Name</th>
        <th>Email</th>
        <th>Status</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php while ($row = mysqli_fetch_assoc($result)): ?>
        <tr>
          <td><?php echo $row['EOInumber']; ?></td>
          <td><?php echo $row['job_ref_number']; ?></td>
          <td><?php echo $row['first_name'] . ' ' . $row['last_name']; ?></td>
          <td><?php echo $row['email']; ?></td>
          <td><?php echo $row['status']; ?></td>
          <td>
            <form method="POST" action="update_status.php" style="display:inline-block">
              <input type="hidden" name="eoi_id" value="<?php echo $row['EOInumber']; ?>">
              <select name="status">
                <option value="New" <?php if ($row['status'] == 'New') echo 'selected'; ?>>New</option>
                <option value="Current" <?php if ($row['status'] == 'Current') echo 'selected'; ?>>Current</option>
                <option value="Final" <?php if ($row['status'] == 'Final') echo 'selected'; ?>>Final</option>
              </select>
              <button type="submit" class="primary-button small">Update</button>
            </form>
          </td>
        </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
</main>

<?php
mysqli_close($conn);
require_once 'footer.inc';
?>