<?php
/**
 * Created by PhpStorm.
 * User: HP USER
 * Date: 12/13/2016
 * Time: 11:47 PM
 */
session_start();ob_start();
include '../includes/conn.php';
 	$id=$_POST['id'];
 $title=ucwords(trim($_POST['title']));
 $content=ucwords(trim($_POST['content']));
 $author=ucwords(trim($_POST['author']));
$update=mysqli_query($con,"UPDATE updates SET title='$title', content='$content', author='$author' WHERE newsID='$id'");
if(($update)){
    $_SESSION['update']="<h3 style='color:green'>Edited successfully</h3>";
    header('location:updates.php');
}
else{
    $_SESSION['update']="<h3 style='color:red'>unable to edit update.</h3>";
    header('location:updates.php');
}
