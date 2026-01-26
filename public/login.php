<?php
require_once __DIR__ . "/../config/config.php";
require_once "../core/Auth.php";

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $auth = new Auth();
    if ($auth->login($_POST['email'], $_POST['password'])) {
        header("Location: ../views/dashboard.php");
        exit;
    } else {
        $error = "Invalid login";
    }
}
?>

<?php require_once __DIR__ . "/../views/partials/header.php"  ?>

<div class="form__max-width">
  <?php if($error): ?>
  <div class='alert alert-danger alert-dismissible fade show' role='alert'>
    <?= $error ?>
    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
  </div>
  <?php endif; ?>
  <h1 class="text-center mb-3">Login</h1>
  <form method="POST" class="container">
    <input type="email" name="email" class="form-control" id="staticEmail2" placeholder="email@example.com">
    <input type="password" name="password" class="form-control my-3" id="inputPassword2" placeholder="Password">
    <button type="submit" class="btn btn-primary">Login</button>
  </form>
</div>