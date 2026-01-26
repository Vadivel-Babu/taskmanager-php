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

    public function getAll()
    {
        $stmt = $this->db->query("SELECT * FROM tasks");
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

    public function getTask($taskId)
    {
        $stmt = $this->db->prepare(
            "SELECT * FROM tasks WHERE id = ?"
        );
        $stmt->execute([$taskId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateTask($title,$description,$assigned,$status,$id)
    {
        $stmt = $this->db->prepare(
            "UPDATE tasks SET title = :title,description = :description, assigned_to = :assigned, status = :status WHERE id = :id"
        );
        $stmt->execute([":title" => $title,":description" => $description,":assigned"=>$assigned,":status"=>$status,":id" => $id]);
        
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