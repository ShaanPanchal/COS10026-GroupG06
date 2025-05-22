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

// 💡 Sorting Logic
$allowed_fields = ['EOInumber', 'job_ref_number', 'first_name', 'status'];
$sort_by = isset($_GET['sort']) && in_array($_GET['sort'], $allowed_fields) ? $_GET['sort'] : 'EOInumber';

$order = ($_GET['order'] ?? 'desc') === 'asc' ? 'asc' : 'desc';
$next_order = $order === 'asc' ? 'desc' : 'asc';

$query = "SELECT * FROM eoi ORDER BY $sort_by $order";
$result = mysqli_query($conn, $query);
?>

<main class="mgmt-container">
  <h1 class="mgmt-title">EOI Management Dashboard</h1>

  <!-- Sorting Dropdown -->
  <label for="sort">Sort by:</label>
<select name="sort" id="sort" onchange="this.form.submit()">
  <option value="EOInumber" <?= $sort_by === 'EOInumber' ? 'selected' : '' ?>>
    EOI Number <?= $sort_by === 'EOInumber' ? ($order === 'asc' ? '▲' : '▼') : '' ?>
  </option>
  <option value="job_ref_number" <?= $sort_by === 'job_ref_number' ? 'selected' : '' ?>>
    Job Ref <?= $sort_by === 'job_ref_number' ? ($order === 'asc' ? '▲' : '▼') : '' ?>
  </option>
  <option value="first_name" <?= $sort_by === 'first_name' ? 'selected' : '' ?>>
    First Name <?= $sort_by === 'first_name' ? ($order === 'asc' ? '▲' : '▼') : '' ?>
  </option>
  <option value="status" <?= $sort_by === 'status' ? 'selected' : '' ?>>
    Status <?= $sort_by === 'status' ? ($order === 'asc' ? '▲' : '▼') : '' ?>
  </option>
</select>
    <input type="hidden" name="order" value="<?= $next_order ?>">
  </form>

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
            <td><?= htmlspecialchars($row['EOInumber']) ?></td>
            <td><?= htmlspecialchars($row['job_ref_number']) ?></td>
            <td><?= htmlspecialchars($row['first_name'] . ' ' . $row['last_name']) ?></td>
            <td><?= htmlspecialchars($row['email']) ?></td>
            <td>
              <span class="status-badge <?= strtolower(str_replace(' ', '-', $row['status'])) ?>">
               <?= htmlspecialchars($row['status']) ?>
              </span>
            </td>
            <td>
              <form method="POST" action="update_status.php" class="mgmt-status-form">
                <input type="hidden" name="eoi_id" value="<?= $row['EOInumber'] ?>">
                <select name="status" class="mgmt-select">
                  <option value="Accepted" <?= $row['status'] === 'Accepted' ? 'selected' : '' ?>>Accepted</option>
                  <option value="Rejected" <?= $row['status'] === 'Rejected' ? 'selected' : '' ?>>Rejected</option>
                  <option value="On Hold" <?= $row['status'] === 'On Hold' ? 'selected' : '' ?>>On Hold</option>
                </select>
                <button type="submit" class="mgmt-update">Update</button>
                <a href="view_eoi.php?eoi_id=<?= $row['EOInumber'] ?>" class="primary-button button-left-space">View</a>
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