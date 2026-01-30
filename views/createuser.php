 <?php 
 include_once __DIR__ . "/../config/config.php";
 include_once __DIR__ . "/partials/header.php";
 include_once __DIR__ . "/../core/User.php";
 $error = '';
 if($_SESSION['role'] !== 'admin'){
 header("Location: dashboard.php");
 exit;
}
 if($_SERVER["REQUEST_METHOD"] === 'POST'){
    
    if (!isset($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
        die('Invalid CSRF token');
    }
 
    $user = new User();

    $name  = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $role  = trim($_POST['role'] ?? '');

    // Validation
    if ($name === '' || $email === '') {
        $error = 'Please enter all fields';
    } else {
        if ($user->createUser($name, $email, $role)) {
            header("Location: user.php");
            exit;
        } else {
            $error = "User email already exists";
        }

    }
 }
?>


 <div class="dashboard">
   <?php include_once __DIR__ ."/partials/sidebar.php";  ?>
   <div class="dashboard__content ">

     <h1 class="text-center">Create User</h1>

     <div class="container form__max-width bg-white">
       <?php if($error): ?>
       <div class='alert alert-danger alert-dismissible fade show' role='alert'>
         <?= $error ?>
         <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
       </div>
       <?php endif; ?>

       <form method="post">
         <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
         <div class="mb-3">
           <label for="exampleFormControlInput1" class="form-label">Name</label>
           <input type="text" name="name" class="form-control" id="exampleFormControlInput1" placeholder="name">
         </div>
         <div class="mb-3">
           <label for="exampleFormControlInput1" class="form-label">Email</label>
           <input type="email" name="email" class="form-control" id="exampleFormControlInput1"
             placeholder="user@mail.com">
         </div>
         <div class="mb-3">
           <label for="exampleFormControlInput1" class="form-label">Role</label>
           <select name="role" class="form-select" aria-label="Default select example">
             <option value="user">user</option>
           </select>
         </div>
         <div class="d-flex justify-content-between">
           <a role="button" href="user.php" class="card-link btn btn-dark ">Back</a>
           <button type="submit" class="btn btn-dark">Create User</button>
         </div>
       </form>
     </div>
   </div>
 </div>

 <?php include_once __DIR__ . "/partials/footer.php"; ?>