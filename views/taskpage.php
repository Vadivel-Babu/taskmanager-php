<?php
 include_once __DIR__ . "/../config/config.php";
 include_once __DIR__ . "/partials/header.php";
 include_once __DIR__ . "/../core/Task.php";
 include_once __DIR__ . "/../core/User.php";
 include_once __DIR__ . "/../core/Auth.php";

 Auth::check();

 $id = 0;
 $task= '';

$task = new Task();
if(isset($_GET['id'])){
   $id = $_GET['id'];
   $task = $task->getTask($id);
}
 $users = new User();
 $user = $users->getUser($task["assigned_to"]);
?>


<div class="dashboard">
  <?php include_once __DIR__ ."/partials/sidebar.php";  ?>
  <div class="dashboard__content ">

    <h1 class="text-center">Task</h1>

    <div class="card card__width">
      <div class="card-body">
        <h5 class="card-title">Title: <?= e($task['title']) ?></h5>
        <h6 class="card-subtitle mb-2 text-body-secondary">Assigned To: <?= e($user['name']) ?></h6>
        <h6 class="card-subtitle mb-2 text-body-secondary">Status: <span
            class="badge
          <?= $task['status'] === 'completed' ? "text-bg-success" : "text-bg-warning" ?>"><?= e($task['status']) ?></span>
        </h6>
        <p class="card-text">Description: <?= e($task['description']) ?></p>
        <div class="d-flex justify-content-between mt-5">
          <a role="button" href="task.php" class="card-link btn btn-dark ">Back</a>
          <a role="button" href="edittask.php?id=<?= $task['id'] ?>" class="card-link btn btn-dark ">Edit</a>
        </div>
      </div>
    </div>
  </div>
</div>

<?php include_once __DIR__ . "/partials/footer.php"; ?>