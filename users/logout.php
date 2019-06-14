<?php 
session_start();
include '../includes/conn.php';
 session_destroy();
header('location:../index.php');	
?>
