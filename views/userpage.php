<?php
 include_once __DIR__ . "/../config/config.php";
 include_once __DIR__ . "/partials/header.php";
 include_once __DIR__ . "/../core/Task.php";
 include_once __DIR__ . "/../core/User.php";
include_once __DIR__ . "/../core/Auth.php";

 Auth::check();

 $id = 0;
 $user= '';
 $assignedTask = 0;

$users = new User();
$task = new Task();
if(isset($_GET['id'])){
   $id = $_GET['id'];
  $user = $users->getUser($id);
  $assignedTask = count($task->getByUser($id));
}


?>


<div class="dashboard">
  <?php include_once __DIR__ ."/partials/sidebar.php";  ?>
  <div class="dashboard__content ">

    <h1 class="text-center">User</h1>

    <div class="card card__width">
      <div class="card-body">
        <h5 class="card-title">Title: <?= e($user['name']) ?></h5>
        <h6 class="card-subtitle mb-2 text-body-secondary">Email: <?= e($user['email']) ?></h6>
        <h6 class="card-subtitle mb-2 text-body-secondary">Status: <span class="badge
          <?= $user['status'] === 'active' ? "text-bg-success" : "text-bg-danger" ?>"><?= e($user['status']) ?></span>
        </h6>
        <p class="card-text">No of Task Assigned: <span class="badge
           text-bg-info"><?= e($assignedTask) ?></span>
        </p>
        <div class="d-flex justify-content-between mt-5">
          <a role="button" href="user.php" class="card-link btn btn-dark ">Back</a>
        </div>
      </div>
    </div>
  </div>
</div>

<?php include_once __DIR__ . "/partials/footer.php"; ?>