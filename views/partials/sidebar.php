<?php
 $uri = $_SERVER["PHP_SELF"];
 $uri = explode('/',$uri);
 $uri = explode('.',$uri[count($uri) - 1])[0];
?>
<aside class="dashboard__sidebar">
  <div class="dashboard__sidebar--top">
    <h2>TM</h2>
    <a href="dashboard.php" class="p-2 <?= $uri === 'dashboard' ? "text-bg-primary" : "" ?>">Dashboard</a>
    <a href="task.php" class="p-2 <?= $uri === 'task' ? "text-bg-primary" : "" ?>">Task</a>
    <?php if ($_SESSION['role'] === 'admin'): ?>
    <a href="user.php" class="p-2 <?= $uri === 'user' ? "text-bg-primary" : "" ?>">Users</a>
    <a href="createtask.php" class="p-2 <?= $uri === 'createtask' ? "text-bg-primary" : "" ?>">Create Task</a>
    <a href="createuser.php" class="p-2 <?= $uri === 'createuser' ? "text-bg-primary" : "" ?>">Create User</a>
    <?php endif; ?>
    <a href="setting.php" class="p-2 <?= $uri === 'setting' ? "text-bg-primary" : "" ?>">Setting</a>
  </div>

  <div class="dashboard__sidebar--bottom">
    <a class="btn btn-light" href="<?= BASE_URL ?>public/logout.php" role="button">Logout</a>
  </div>
</aside>