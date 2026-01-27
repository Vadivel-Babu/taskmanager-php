 <?php 
 include_once __DIR__ . "/../config/config.php";
 include_once __DIR__ . "/partials/header.php";
?>


 <div class="dashboard">
   <?php include_once __DIR__ ."/partials/sidebar.php";  ?>
   <div class="dashboard__content ">
     <h1 class="text-center"> Welcome <?= $_SESSION['user_name']; ?></h1>
     <div class="container">
       <div class="stats">
         <div class="stat_card">
           <p>Total No of Task:</p>
           <span>0</span>
         </div>
         <div class="stat_card">
           <p>Total No of User:</p>
           <span>0</span>
         </div>
         <div class="stat_card">
           <p>No of Active User:</p>
           <span>0</span>
         </div>
       </div>
     </div>
   </div>
 </div>