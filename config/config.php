<?php 
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
   

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
define('BASE_URL',"http://taskmanager.test/");

function e($value) {
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}

?>