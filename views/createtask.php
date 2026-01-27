 <?php 
 include_once __DIR__ . "/../config/config.php";
 include_once __DIR__ . "/partials/header.php";
 include_once __DIR__ . "/../core/Task.php";
 include_once __DIR__ . "/../core/User.php";
 $error = '';
 if($_SESSION['role'] !== 'admin'){
 header("Location: dashboard.php");
 exit;
}
 $users = new User();
 $allUsers = $users->getUserForDropdown('user');
 
 if($_SERVER["REQUEST_METHOD"] === 'POST'){
    
    if (!isset($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
        die('Invalid CSRF token');
    }
 
    $task = new Task();
   

    $title  = trim($_POST['title'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $assigned  = trim($_POST['assigned'] ?? '');

    // Validation
    if ($title === '' || $description === '') {
        $error = 'Please enter all fields';
    } else {
        if ($task->createTask($title,$description,$assigned)) {
            header("Location: task.php");
            exit;
        }
    }
 }
?>


 <div class="dashboard">
   <?php include_once __DIR__ ."/partials/sidebar.php";  ?>
   <div class="dashboard__content ">
     <h1 class="text-center">Create Task</h1>
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
           <label for="exampleFormControlInput1" class="form-label">Title</label>
           <input type="text" name="title" class="form-control" id="exampleFormControlInput1" placeholder="title">
         </div>
         <div class="mb-3">
           <label for="exampleFormControlInput1" class="form-label">Description</label>
           <input type="text" name="description" class="form-control" id="exampleFormControlInput1"
             placeholder="description ...">
         </div>
         <div class="mb-3">
           <label for="exampleFormControlInput1" class="form-label">Assigned</label>
           <select name="assigned" class="form-select" aria-label="Default select example">
             <?php foreach($allUsers as $user): ?>
             <option value="<?= $user['id'] ?>"><?= $user['name'] ?></option>
             <?php endforeach; ?>
           </select>
         </div>
         <button type="submit" class="btn btn-dark">Create Task</button>
       </form>
     </div>
   </div>
 </div>

 <?php include_once __DIR__ . "/partials/footer.php"; ?>