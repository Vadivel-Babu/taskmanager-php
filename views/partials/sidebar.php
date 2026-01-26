<aside class="dashboard__sidebar">
  <div class="dashboard__sidebar--top">
    <h2>TM</h2>
    <a href="dashboard.php">Dashboard</a>
    <a href="task.php">Task</a>
    <?php if ($_SESSION['role'] === 'admin'): ?>
    <a href="user.php">Users</a>
    <a href="createtask.php">Create Task</a>
    <a href="createuser.php">Create User</a>
    <?php endif; ?>
    <a href="setting.php">Setting</a>
  </div>

  <div class="dashboard__sidebar--bottom">
    <a class="btn btn-light" href="<?= BASE_URL ?>public/logout.php" role="button">Logout</a>
  </div>
</aside>