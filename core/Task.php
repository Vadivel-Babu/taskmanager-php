<?php
require_once __DIR__ . "/../config/Database.php";

class Task
{
    private $db;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->conn;
    }

    public function getAll($limit, $offset,$status,$priority)
    {
        $stmt = $this->db->prepare("SELECT * FROM tasks WHERE status LIKE :status AND priority LIKE :priority LIMIT :limit OFFSET :offset");
        $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);    
        $stmt->bindValue(':status',$status);
        $stmt->bindValue(':priority',$priority);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function createTask($title,$description,$assigned)
    {
      $stmt = $this->db->prepare("INSERT tasks(title,description,assigned_to) values (:title,:description,:assigned)");
      $stmt->execute([":title" => $title,":description" => $description,":assigned" => $assigned]);
      return true;
    }

    public function getByUser($userId)
    {
        $stmt = $this->db->prepare(
            "SELECT * FROM tasks WHERE assigned_to = ?"
        );
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getByUserWithLimit($userId,$limit, $offset,$status,$priority)
    {
        $stmt = $this->db->prepare("SELECT * FROM tasks WHERE assigned_to = :userId AND  status LIKE :status AND priority LIKE :priority LIMIT :limit OFFSET :offset");
        $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);    
        $stmt->bindValue(':status',$status);
        $stmt->bindValue(':priority',$priority);
         $stmt->bindValue(':userId',$userId);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTask($taskId)
    {
        $stmt = $this->db->prepare(
            "SELECT * FROM tasks WHERE id = ?"
        );
        $stmt->execute([$taskId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getTaskCount($status,$priority,$userId)
    { 
        if($_SESSION['role'] === 'user')
        {
          $stmt = $this->db->prepare("SELECT COUNT(*) FROM tasks WHERE status LIKE :status AND priority LIKE :priority AND assigned_to = :id");
          $stmt->execute([':status' => $status,":priority"=>$priority,":id" => $userId]);
          return $stmt->fetchColumn();
        }
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM tasks WHERE status LIKE :status AND priority LIKE :priority");
        $stmt->execute([':status' => $status,":priority"=>$priority]);
        return $stmt->fetchColumn();
       
    }

    public function getTaskCountByuser($status,$id)
    {
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM tasks WHERE status LIKE :status AND assigned_to = :id");
        $stmt->execute([':status' => $status,":id" => $id]);
        return $stmt->fetchColumn();
    }

    public function updateTask($title,$description,$assigned,$status,$id, $priority)
    {
        $stmt = $this->db->prepare(
            "UPDATE tasks SET title = :title,description = :description, assigned_to = :assigned, status = :status,priority = :priority WHERE id = :id"
        );
        $stmt->execute([":title" => $title,":description" => $description,":assigned"=>$assigned,":status"=>$status,":priority" => $priority ,":id" => $id]);
        
        return true;
    }

    public function deleteTask($taskId)
    {
        $stmt = $this->db->prepare(
            "DELETE FROM tasks WHERE id = ?"
        );
        return $stmt->execute([$taskId]);
    }
}