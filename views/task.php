<?php 
 include_once __DIR__ . "/../config/config.php";
 include_once __DIR__ . "/partials/header.php";
 include_once __DIR__ . "/../core/Task.php";

 $tasks = new Task();
 if($_SESSION['role'] == 'admin'){
   $alltasks = $tasks->getAll();
 } else {
  $alltasks = $tasks->getByUser($_SESSION['user_id']);
 }

?>


<div class="dashboard">
  <?php include_once __DIR__ ."/partials/sidebar.php";  ?>
  <div class="dashboard__content ">
    <h1 class="text-center"> Task</h1>
    <table class="table container">
      <thead>
        <tr>
          <th scope="col">No</th>
          <th scope="col">Title</th>
          <th scope="col">Description</th>
          <?php if($_SESSION['role'] === 'user'): ?>
          <th scope="col">Priority</th>
          <?php endif; ?>
          <th scope="col">Status</th>
          <th scope="col">Action</th>
        </tr>
      </thead>
      <tbody>
        <?php $no = 1; ?>
        <?php foreach($alltasks as $task): ?>
        <tr>
          <th scope="row"><?= $no ?></th>
          <td><?= e($task['title'])  ?></td>
          <td><?= e($task['description']) ?></td>
          <td>
            <?php if($_SESSION['role'] === 'user'): ?>
            <span
              class="badge <?= $task['priority'] === 'low' ? "text-bg-success" : "text-bg-warning" ?>"><?= e($task['priority']) ?></span>
            <?php endif; ?>
          </td>
          <td><span
              class="badge <?= $task['status'] === 'completed' ? "text-bg-success" : "text-bg-warning" ?>"><?= e($task['status']) ?></span>
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
  </div>
</div>