<?php
require_once "config/Database.php";
require_once __DIR__ . '/config/config.php';



$db = new Database();

if ($db->conn) {
    header("Location: public/login.php");
    exit;
}