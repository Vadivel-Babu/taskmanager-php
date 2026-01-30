 <?php 
 include_once __DIR__ . "/../config/config.php";
 include_once __DIR__ . "/partials/header.php";
 include_once __DIR__ . "/../core/User.php";
 if($_SESSION['role'] !== 'admin'){
 header("Location: dashboard.php");
 exit;
}
 $user = new User();
 $role = $_GET['role'] ?? '';
$status = $_GET['status'] ?? '';
$role = $role === '' ? '%' : $role;
$status = $status === '' ? '%' : $status;
$limit = 5;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

$page = max($page, 1);

$offset = ($page - 1) * $limit;

$totalUsers = $user->getUserCount($role,$status);
$totalPages = ceil($totalUsers / $limit);

$allusers = $user->getAllUsers($limit, $offset,$role,$status);

?>


 <div class="dashboard">
   <?php include_once __DIR__ ."/partials/sidebar.php";  ?>
   <div class="dashboard__content">
     <h1 class="text-center">All User</h1>
     <form method="GET" class="row g-2 mb-3 container mx-auto my-0">
       <div class="col-md-4">
         <select name="role" class="form-select">
           <option value="">All Roles</option>
           <option value="admin">Admin</option>
           <option value="user">User</option>
         </select>
       </div>

       <div class="col-md-4">
         <select name="status" class="form-select">
           <option value="">All Status</option>
           <option value="active">Active</option>
           <option value="inactive">Inactive</option>
         </select>
       </div>

       <div class="col-md-4">
         <button class="btn btn-primary">Filter</button>
       </div>
     </form>
     <?php if($allusers): ?>
     <div class="table-responsive">
       <table class="table container">
         <thead>
           <tr>
             <th scope="col">No</th>
             <th scope="col">Name</th>
             <th scope="col">Email</th>
             <th scope="col">Status</th>
             <th scope="col">Action</th>
           </tr>
         </thead>
         <tbody>
           <?php $no = 1; ?>
           <?php foreach($allusers as $user): ?>
           <tr>
             <th scope="row"><?= $no ?></th>
             <td><a href="userpage.php?id=<?= $user['id'] ?>" class=""><?= e($user['name']) ?></a></td>
             <td><?= e($user['email']) ?></td>
             <td><span
                 class="badge <?=  $user['status'] === 'active' ? "text-bg-success": "text-bg-danger" ?>"><?= e($user['status']) ?></span>
             </td>
             <td>
               <?php if($user["role"] === 'user'): ?>
               <button type="button" class="btn btn-danger delete-btn" data-id="<?= $user['id'] ?>">Delete</button>
               <?php endif; ?>
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
           <a class="page-link"
             href="?page=<?= $i ?>&role=<?= urlencode($role) ?>&status=<?= urlencode($status) ?>"><?= $i ?></a>
         </li>
         <?php endfor; ?>
         <li class="page-item <?= $page >= $totalPages ? 'disabled' : '' ?>">
           <a class="page-link" href="?page=<?= $page + 1 ?>">Next</a>
         </li>
       </ul>
     </nav>
   </div>
 </div>

 <?php include_once __DIR__ . "/partials/footer.php"; ?>