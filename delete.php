<?php
session_start();
if(!isset($_SESSION['user_id'])) header("Location: ../auth/login.php");
require '../config/db.php';
if(!isset($_GET['id'])){ header("Location:index.php"); exit(); }
$id=$_GET['id'];
$stmt=$pdo->prepare("DELETE FROM students WHERE id=?"); $stmt->execute([$id]);
header("Location:index.php"); exit();
