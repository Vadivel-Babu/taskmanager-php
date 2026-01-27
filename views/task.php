<?php 
 include_once __DIR__ . "/../config/config.php";
 include_once __DIR__ . "/partials/header.php";
 include_once __DIR__ . "/../core/Task.php";

 $tasks = new Task();
 $status = $_GET['status'] ?? '';
$status = $status === '' ? '%' : $status;
$alltasks  = [];
$limit = 5;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$page = max($page, 1);
$offset = ($page - 1) * $limit;
$totalTasks = $tasks->getTaskCount($status);
$totalPages = ceil($totalTasks / $limit);
 if($_SESSION['role'] == 'admin'){
   $alltasks = $tasks->getAll($limit,$offset,$status);
 } else {
  $alltasks = $tasks->getByUser($_SESSION['user_id']);
  $alltasks = $tasks->getAll($limit, $offset,$status);
 }



?>


<div class="dashboard">
  <?php include_once __DIR__ ."/partials/sidebar.php";  ?>
  <div class="dashboard__content ">
    <h1 class="text-center"> Task</h1>
    <form method="GET" class="row g-2 mb-3 container mx-auto my-0">
      <div class="col-md-4">
        <select name="status" class="form-select">
          <option value="">All Status</option>
          <option value="pending">pending</option>
          <option value="completed">completed</option>
        </select>
      </div>
      <div class="col-md-4">
        <button class="btn btn-primary">Filter</button>
      </div>
    </form>
    <?php if($alltasks): ?>
    <table class="table container">
      <thead>
        <tr>
          <th scope="col">No</th>
          <th scope="col">Title</th>
          <th scope="col">Description</th>
          <th scope="col">Status</th>
          <th scope="col">
            <?=  $_SESSION['role'] === 'user' ? 'Priority' : '' ?>
          </th>
          <th scope="col">Action</th>
        </tr>
      </thead>
      <tbody>
        <?php $no = 1; ?>
        <?php foreach($alltasks as $task): ?>
        <tr>
          <td scope="row"><?= $no ?></td>
          <td><?= e($task['title'])  ?></td>
          <td><?= e($task['description']) ?></td>
          <td><span
              class="badge <?= $task['status'] === 'completed' ? "text-bg-success" : "text-bg-warning" ?>"><?= e($task['status']) ?></span>
          </td>
          <td>
            <?php if($_SESSION['role'] === 'user'): ?>
            <span
              class="badge <?= $task['priority'] === 'low' ? "text-bg-success" : "text-bg-warning" ?>"><?= e($task['priority']) ?></span>
            <?php endif; ?>
          </td>
          <td>
            <a href="edittask.php?id=<?= $task['id'] ?>" class="btn btn-dark" role="button">Edit</a>
            <?php if($_SESSION['role'] === 'admin'): ?>
            <button type="button" class="btn btn-danger delete-task-btn" data-id="<?= $task['id'] ?>">Delete</button>
            <?php endif; ?>
          </td>
        </tr>
        <?php $no++; ?>
        <?php endforeach; ?>
      </tbody>
    </table>
    <?php else: ?>
    <h2 class="text-center my-5">No Task Found</h2>
    <?php endif; ?>

    <nav aria-label="Page navigation example ">
      <ul class="pagination container mx-auto my-0">
        <li class="page-item <?= $page <= 1 ? 'disabled' : '' ?>">
          <a class="page-link" href="?page=<?= $page - 1 ?>">Previous</a>
        </li>
        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
        <li class="page-item <?= $page == $i ? 'active' : '' ?>">
          <a class="page-link" href="?page=<?= $i ?>&status=<?= urlencode($status) ?>"><?= $i ?></a>
        </li>
        <?php endfor; ?>
        <li class="page-item <?= $page >= $totalPages ? 'disabled' : '' ?>">
          <a class="page-link" href="?page=<?= $page + 1 ?>">Next</a>
        </li>
      </ul>
    </nav>
  </div>
</div>