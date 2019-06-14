<?php
/**
 * Created by PhpStorm.
 * User: HP USER
 * Date: 12/14/2016
 * Time: 12:01 AM
 */
session_start();ob_start();
include '../includes/conn.php';
 	$id=$_POST['id'];
 $title=ucwords(trim($_POST['addtitle']));
 $content=ucwords(trim($_POST['addcontent']));
 $author=ucwords(trim($_POST['addauthor']));
$update=mysqli_query($con,"INSERT INTO updates(title,content,author,date) VALUES ('$title','$content','$author',NOW())");
if(($update)){
    $_SESSION['update']="<h3 style='color:green'>Update added successfully</h3>";
    header('location:updates.php');
}
else{
    $_SESSION['update']="<h3 style='color:red'>unable to add update.</h3>".mysqli_error($con);
    header('location:updates.php');
}