 <?php 
 include_once __DIR__ . "/../config/config.php";
 include_once __DIR__ . "/partials/header.php";
 include_once __DIR__ . "/../core/User.php";
 include_once __DIR__ . "/../core/Auth.php";

 Auth::check();
 $error = '';
 $user = new User();
 $id = $_SESSION['user_id'];

 if($_SERVER["REQUEST_METHOD"] === 'POST'){
    
    if (!isset($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
        die('Invalid CSRF token');
    }

    $name  = trim($_POST['name'] ?? '');
   
    // Validation
    if ($name === '') {
        $error = 'Please enter name';
    } else {
        if ($user->updateUser($id,$name)) {
          $updateduser = $user->getUser($id);
            $_SESSION['user_name'] = $updateduser['name'];
          
        } else {
            $error = "Could not change the name";
        }
    }
    

    if (trim($_POST['current_password']) !== '' ||
        trim($_POST['new_password']) !== '' ||
        trim($_POST['confirm_password']) !== '') {        

        // All password fields required
        if (
            trim($_POST['current_password']) === '' ||
            trim($_POST['new_password']) === '' ||
            trim($_POST['confirm_password']) === ''
        ) {
            $error = 'Please fill all password fields';        
        } elseif ($_POST['new_password'] !== $_POST['confirm_password']) {
            $error = 'New Password and Confirm Password  do not match';
                      
        } else{
          $result = $user->updatePassword(
              $id,
              $_POST['current_password'],
              $_POST['new_password']
          );
          if ($result !== true) {
              $error = 'Current password is incorrect';           
          } elseif($result) {
             session_unset();
            session_destroy();
            header("Location: " . BASE_URL . "public/login.php");
            exit;
          }
        }

    }
 }
?>


 <div class="dashboard">
   <?php include_once __DIR__ ."/partials/sidebar.php";  ?>
   <div class="dashboard__content ">

     <h1 class="text-center">Setting</h1>

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
           <input type="text" name="name" value="<?=  $_SESSION['user_name'] ?>" class="form-control"
             id="exampleFormControlInput1" placeholder="name">
         </div>
         <div class="mb-3">
           <label for="exampleFormControlInput1" class="form-label">Email</label>
           <input type="email" name="email" readonly value="<?= $_SESSION['user_email'] ?>" class="form-control"
             id="exampleFormControlInput1" placeholder="user@mail.com">
         </div>
         <div class="mb-3">
           <label for="exampleFormControlInput1" class="form-label">Current Password</label>
           <input type="password" name="current_password" class="form-control" id="exampleFormControlInput1"
             placeholder="Password">
         </div>
         <div class="mb-3">
           <label for="exampleFormControlInput1" class="form-label">New Password</label>
           <input type="password" name="new_password" class="form-control" id="exampleFormControlInput1"
             placeholder="New Password">
         </div>
         <div class="mb-3">
           <label for="exampleFormControlInput1" class="form-label">Confirm Password</label>
           <input type="password" name="confirm_password" class="form-control" id="exampleFormControlInput1"
             placeholder="Confirm Password">
         </div>

         <button type="submit" class="btn btn-dark ">Submit</button>
       </form>
     </div>
   </div>
 </div>

 <?php include_once __DIR__ . "/partials/footer.php"; ?>