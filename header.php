<?php
session_start();

$db = new PDO("mysql:host=localhost;dbname=final_project_sem1", "root");

if(!isset($_SESSION['user'])){
    header("Location: index.php");
    exit;
}

?>