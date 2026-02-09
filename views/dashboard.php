 <?php 
 include_once __DIR__ . "/../config/config.php";
 include_once __DIR__ . "/partials/header.php";
 include_once __DIR__ . "/../core/User.php";
 include_once __DIR__ . "/../core/Task.php";
 include_once __DIR__ . "/../core/Auth.php";

 Auth::check();
 $user = new User();
 $task = new Task();

$role =  '%' ;
$status = '%';
$priority = "%";
$taskStatus = '%';
$userStatus = 'active';
$allusers = '';
$totalUsers = 0;
$totalActiveUsers = 0;
$totalTasks  = 0;
$totalCompletedTask = 0;
$totalPendingTask = 0;
$limit = 5;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$page = max($page, 1);
$offset = ($page - 1) * $limit;

if($_SESSION['role'] === 'admin'){
 $allusers = $user->getAllUsers($limit, $offset,$role,$userStatus);
 $totalUsers = $user->getUserCount($role,$status);
 $totalActiveUsers = $user->getUserCount($role,$userStatus);
 $totalTasks = $task->getTaskCount($taskStatus,$priority,$_SESSION['user_id']);
} else{
  $totalTasks = count($task->getByUser($_SESSION['user_id']));
  $totalPendingTask = $task->getTaskCountByuser('pending',$_SESSION['user_id']);
}


$totalPages = ceil($totalActiveUsers / $limit);
?>


 <div class="dashboard">
   <?php include_once __DIR__ ."/partials/sidebar.php";  ?>
   <div class="dashboard__content ">
     <h1 class="text-center"> Welcome <?= $_SESSION['user_name']; ?></h1>
     <div class="container-lg">
       <div class="stats">
         <div class="stat_card">
           <p>Total No of Task:</p>
           <span><?= $totalTasks ?></span>
         </div>
         <?php if($_SESSION['role'] === 'admin'): ?>
         <div class="stat_card">
           <p>Total No of User:</p>
           <span><?= $totalUsers ?></span>
         </div>
         <div class="stat_card">
           <p>No of Active User:</p>
           <span><?= $totalActiveUsers ?></span>
         </div>
         <div class="stat_card">
           <p>No of InActive User:</p>
           <span><?= $totalUsers - $totalActiveUsers ?></span>
         </div>
         <?php else: ?>
         <div class="stat_card">
           <p>No of Pending Task:</p>
           <span><?= $totalPendingTask ?></span>
         </div>
         <div class="stat_card">
           <p>No of Completed Task:</p>
           <span><?= $totalTasks - $totalPendingTask ?></span>
         </div>
         <?php endif; ?>
       </div>
       <?php if($_SESSION['role'] === 'admin') : ?>
       <?php if($allusers): ?>
       <h1 class="text-center my-3">Active User</h1>
       <div class="table-responsive">
         <table class="table container">
           <thead>
             <tr>
               <th scope="col">No</th>
               <th scope="col">Name</th>
               <th scope="col">Email</th>
               <th scope="col">Status</th>
             </tr>
           </thead>
           <tbody>
             <?php $no = 1; ?>
             <?php foreach($allusers as $user): ?>
             <tr>
               <th scope="row"><?= $no ?></th>
               <td><?= e($user['name']) ?></td>
               <td><?= e($user['email']) ?></td>
               <td><span
                   class="badge <?=  $user['status'] === 'active' ? "text-bg-success": "text-bg-danger" ?>"><?= e($user['status']) ?></span>
               </td>
             </tr>
             <?php $no++; ?>
             <?php endforeach; ?>

           </tbody>
         </table>
       </div>
       <?php else: ?>
       <h2 class="text-center my-5">User Not Found</h2>
       <?php endif; ?>
       <nav aria-label="Page navigation example ">
         <ul class="pagination container mx-auto my-0">
           <li class="page-item <?= $page <= 1 ? 'disabled' : '' ?>">
             <a class="page-link" href="?page=<?= $page - 1 ?>">Previous</a>
           </li>
           <?php for ($i = 1; $i <= $totalPages; $i++): ?>
           <li class="page-item <?= $page == $i ? 'active' : '' ?>">
             <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
           </li>
           <?php endfor; ?>
           <li class="page-item <?= $page >= $totalPages ? 'disabled' : '' ?>">
             <a class="page-link" href="?page=<?= $page + 1 ?>">Next</a>
           </li>
         </ul>
       </nav>
       <?php else: ?>
       <div class="container d-flex justify-content-center mt-5">
         <a role="button" href="task.php" class="btn btn-primary">
           View Task &#8594
         </a>
       </div>
       <?php endif; ?>
     </div>
   </div>
 </div>

 <?php include_once __DIR__ . "/partials/footer.php"; ?>