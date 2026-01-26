 <?php 
 include_once __DIR__ . "/../config/config.php";
 include_once __DIR__ . "/partials/header.php";
 include_once __DIR__ . "/../core/User.php";
 $user = new User();
 $allusers = $user->getAllUsers();
 if($_SESSION['role'] !== 'admin'){
 header("Location: dashboard.php");
 exit;
}

?>


 <div class="dashboard">
   <?php include_once __DIR__ ."/partials/sidebar.php";  ?>
   <div class="dashboard__content ">
     <h1 class="text-center"> User</h1>
     <table class="table container">
       <thead>
         <tr>
           <th scope="col">No</th>
           <th scope="col">Name</th>
           <th scope="col">Email</th>
           <th scope="col">Active</th>
           <th scope="col">Action</th>
         </tr>
       </thead>
       <tbody>
         <?php $no = 1; ?>
         <?php foreach($allusers as $user): ?>
         <tr>
           <th scope="row"><?= $no ?></th>
           <td><?= e($user['name']) ?></td>
           <td><?= e($user['email']) ?></td>
           <td><span class="badge text-bg-success">active</span></td>
           <td>
             <button type="button" class="btn btn-danger delete-btn" data-id="<?= $user['id'] ?>">Delete</button>
           </td>
         </tr>
         <?php $no++; ?>
         <?php endforeach; ?>

       </tbody>
     </table>
   </div>
 </div>