<?php
session_start();
$pageTitle = "Manage EOIs";
require_once 'header.inc';
require_once 'nav.inc';
require_once 'settings.php';

// Only allow access if manager is logged in
if (!isset($_SESSION['manager_logged_in']) || $_SESSION['manager_logged_in'] !== true) {
    header("Location: manager_login.php");
    exit();
}

$conn = mysqli_connect($host, $user, $pwd, $sql_db);
if (!$conn) {
    echo "<main><p class='mgmt-empty'>❌ Failed to connect to database.</p></main>";
    require_once 'footer.inc';
    exit();
}

$query = "SELECT * FROM eoi ORDER BY EOInumber DESC";
$result = mysqli_query($conn, $query);
?>

<main class="mgmt-container">
  <h1 class="mgmt-title">EOI Management Dashboard</h1>

  <?php if (mysqli_num_rows($result) > 0): ?>
    <table class="mgmt-table">
      <thead>
        <tr>
          <th>EOI#</th>
          <th>Job Ref</th>
          <th>Name</th>
          <th>Email</th>
          <th>Status</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
          <tr>
            <td><?php echo htmlspecialchars($row['EOInumber']); ?></td>
            <td><?php echo htmlspecialchars($row['job_ref_number']); ?></td>
            <td><?php echo htmlspecialchars($row['first_name'] . ' ' . $row['last_name']); ?></td>
            <td><?php echo htmlspecialchars($row['email']); ?></td>
            <td><?php echo htmlspecialchars($row['status']); ?></td>
            <td>
              <form method="POST" action="update_status.php" class="mgmt-status-form">
                <input type="hidden" name="eoi_id" value="<?php echo $row['EOInumber']; ?>">
                <select name="status" class="mgmt-select">
                  <option value="New" <?php if ($row['status'] === 'New') echo 'selected'; ?>>New</option>
                  <option value="Current" <?php if ($row['status'] === 'Current') echo 'selected'; ?>>Current</option>
                  <option value="Final" <?php if ($row['status'] === 'Final') echo 'selected'; ?>>Final</option>
                </select>
                <button type="submit" class="mgmt-update">Update</button>
              </form>
            </td>
          </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  <?php else: ?>
    <p class="mgmt-empty">No EOIs found.</p>
  <?php endif; ?>
</main>

<?php
mysqli_close($conn);
require_once 'footer.inc';
?>