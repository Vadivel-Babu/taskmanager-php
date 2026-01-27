<?php
require_once __DIR__ . "/../config/Database.php";

class Auth
{
    private $db;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->conn;
    }

    public function login($email, $password)
    {
        $stmt = $this->db->prepare(
            "SELECT * FROM users WHERE email = ?"
        );

        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            session_start();
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['user_email'] = $user['email'];
            $_SESSION['role'] = $user['role'];
            $stmt2 = $this->db->prepare(
            "UPDATE users SET status = :status WHERE id = :id"
            );
             $stmt2->execute([":status" => 'active', ":id" => $_SESSION['user_id']]);
            return true;
        }
        return false;
    }

    public function logout()
    {
      if (session_status() === PHP_SESSION_NONE) {
         session_start();
       }

       if (isset($_SESSION['user_id'])) {
          $stmt = $this->db->prepare(
                "UPDATE users SET status = :status WHERE id = :id"
            );
          $stmt->execute([
                ":status" => 'inactive',
                ":id" => $_SESSION['user_id']
            ]);
        }

   
      $_SESSION = [];
      session_destroy();
      header("Location: /public/login.php");
      exit;
    }
}