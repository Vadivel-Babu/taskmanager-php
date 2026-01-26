<?php

require_once __DIR__ . "/../config/Database.php";

class User
{
  private $db;
  
  public function __construct(){
     $database = new Database();
     $this->db = $database->conn;
  }

  public function createUser($name,$email,$role){
    $password = password_hash($email,PASSWORD_DEFAULT);
      $stmt = $this->db->prepare(
            "SELECT * FROM users WHERE email = :email"
        );
      $stmt->execute([':email' => $email]);
      $user = $stmt->fetch(PDO::FETCH_ASSOC);
      if($user){
        return false;
      }
      $stmt2 = $this->db->prepare(
            "INSERT users(name,email,password,role) values (:name,:email,:password,:role)"
        );
      $stmt2->execute([':name' => $name,':email'=>$email,':password'=>$password,':role' => $role]);
      return true;
  }

  public function getAllUsers()
  {
    $stmt = $this->db->prepare( "SELECT * FROM users WHERE role = :role");
    $stmt->execute([':role' => 'user']);
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $users;

  }

  public function updateUser($id,$name)
  {
    $stmt = $this->db->prepare("SELECT * FROM users WHERE id = :id");
    $stmt->execute([":id" => $id]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    if($user){
      $stmt2 = $this->db->prepare("UPDATE users SET name = :name WHERE id = :id");
      $stmt2->execute([":id" => $id,":name" => $name]);
      return true;
    }
    return false;
  }
  
  public function updatePassword($id,$password,$newpassword)
  {
    $stmt = $this->db->prepare("SELECT * FROM users WHERE id = :id");
    $stmt->execute([":id" => $id]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    if($user && password_verify($password,$user['password'])){
      $hasdedpassord = password_hash($newpassword,PASSWORD_DEFAULT);
      $stmt2 = $this->db->prepare("UPDATE users SET password = :password WHERE id = :id");
      $stmt2->execute([":id" => $id, ":password" => $hasdedpassord]);
      return true;
    }
    return false;
  }
  public function getUser($id)
  {
    $stmt = $this->db->prepare("SELECT * FROM users WHERE id = :id");
    $stmt->execute([":id" => $id]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    return $user;
  }

  public function deleteUser($id)
  {
    $stmt = $this->db->prepare(
        "DELETE FROM users WHERE id = ?"
    );

    return $stmt->execute([$id]);
  }
  
}