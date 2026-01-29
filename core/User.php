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
            "INSERT users(name,email,password,role,status) values (:name,:email,:password,:role,:status)"
        );
      $stmt2->execute([':name' => $name,':email'=>$email,':password'=>$password,':role' => $role,':status' => 'inactive']);
      return true;
  }

  public function getAllUsers($limit, $offset,$role,$status)
  {
    $stmt = $this->db->prepare(
      "SELECT * FROM users
       WHERE role LIKE :role AND status LIKE :status
      LIMIT :limit OFFSET :offset"
    );

    $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
    $stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
     $stmt->bindValue(':role', $role);
    $stmt->bindValue(':status',$status);

    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  public function getUserForDropdown()
  {
     $stmt = $this->db->prepare("SELECT * FROM users");
    $stmt->execute();
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $users;
  }

  public function getUserCount($role,$status)
  {
    $stmt = $this->db->prepare("SELECT COUNT(*) FROM users WHERE role LIKE :role AND status LIKE :status");
    $stmt->execute([":role" => $role,":status"=>$status]);
    return $stmt->fetchColumn();
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
    $stmt = $this->db->prepare("SELECT * FROM tasks WHERE assigned_to = :id");
    $stmt->execute([":id"=>$id]);
    $task = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if($task){
      $stmt = $this->db->prepare("SELECT * FROM users WHERE role = 'admin'");
      $stmt->execute();
      $admin = $stmt->fetch(PDO::FETCH_ASSOC);
      $stmt2 = $this->db->prepare("UPDATE tasks SET assigned_to = :assigned_id WHERE assigned_to = :id");
      $stmt2->execute([":assigned_id"=> $admin['id'] , ":id"=> $id]);

    }
    $stmt = $this->db->prepare(
        "DELETE FROM users WHERE id = ?"
    );

    return $stmt->execute([$id]);
  }
  
}