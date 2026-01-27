 <?php 
 include_once __DIR__ . "/../config/config.php";
 include_once __DIR__ . "/partials/header.php";
 include_once __DIR__ . "/../core/Task.php";
 include_once __DIR__ . "/../core/User.php";
 $error = '';
 $id = 0;
 $currenttask= '';

$task = new Task();
if(isset($_GET['id'])){
   $id = $_GET['id'];
   $currenttask = $task->getTask($id);
}
 $users = new User();
 $allUsers = $users->getUserForDropdown('user');
 $currentuser = $users->getUser($currenttask["assigned_to"]);
 
 if($_SERVER["REQUEST_METHOD"] === 'POST'){
    
    if (!isset($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
        die('Invalid CSRF token');
    }

    $title  = trim($_POST['title'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $assigned  = trim($_POST['assigned'] ?? '');
    $status  = trim($_POST['status'] ?? '');
    $priority  = trim($_POST['priority'] ?? '');

    // Validation
    if ($title === '' || $description === '') {
        $error = 'Please enter all fields';
    } else {
        if ($task->updateTask($title,$description,$assigned,$status,$id, $priority)) {
            header("Location: task.php");
            exit;
        }
    }
 }

?>


 <div class="dashboard">
   <?php include_once __DIR__ ."/partials/sidebar.php";  ?>
   <div class="dashboard__content ">
     <h1 class="text-center">Edit Task</h1>
     <div class="container form__max-width">
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
           <input type="text" name="title" value="<?= $currenttask["title"] ?>" class="form-control"
             id="exampleFormControlInput1" placeholder="title">
         </div>
         <div class="mb-3">
           <label for="exampleFormControlInput1" class="form-label">Description</label>
           <input type="text" name="description" value="<?= $currenttask["description"] ?>" class="form-control"
             id="exampleFormControlInput1" placeholder="description ...">
         </div>
         <div class="mb-3">
           <label for="exampleFormControlInput1" class="form-label">Status</label>
           <select name="status" class="form-select" aria-label="Default select example">
             <option value="<?= $currenttask['status'] ?>" selected><?= $currenttask['status'] ?></option>
             <?php if($currenttask['status'] === "pending"): ?>
             <option value="completed">completed</option>
             <?php endif; ?>
             <?php if($currenttask['status'] === "completed"): ?>
             <option value="pending">pending</option>
             <?php endif; ?>
           </select>
         </div>
         <div class="mb-3">
           <label for="exampleFormControlInput1" class="form-label">Priority</label>
           <select name="priority" class="form-select" aria-label="Default select example">
             <option value="<?= $currenttask['priority'] ?>" selected><?= $currenttask['priority'] ?></option>
             <option value="low">low</option>
             <option value="medium">medium</option>
             <option value="high">high</option>
           </select>
         </div>
         <div class="mb-3">
           <label for="exampleFormControlInput1" class="form-label">Assigned</label>
           <select name="assigned" class="form-select" aria-label="Default select example">
             <option value="<?= $currentuser['id'] ?>" selected><?= $currentuser['name'] ?></option>
             <?php foreach($allUsers as $user): ?>
             <?php if($user["id"] !== $currentuser['id']): ?>
             <option value="<?= $user['id'] ?>"><?= $user['name'] ?></option>
             <?php endif; ?>
             <?php endforeach; ?>
           </select>
         </div>
         <button type="submit" class="btn btn-warning">Update Task</button>
       </form>
     </div>
   </div>
 </div>

 <?php include_once __DIR__ . "/partials/footer.php"; ?>