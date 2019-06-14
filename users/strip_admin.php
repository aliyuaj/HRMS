<?php
/**
 * Created by PhpStorm.
 * User: HP USER
 * Date: 12/15/2016
 * Time: 8:00 AM
 */
session_start();ob_start();
include '../includes/conn.php';
$id=$_GET['id'];
$update=mysqli_query($con,"UPDATE users SET usertype='staff' WHERE staffID='$id'");
if(($update)){
    $_SESSION['action']="<h3 style='color:green'>Staff stripped admin</h3>";
    header('location:staff_list.php');
}
else{
    $_SESSION['action']="<h3 style='color:red'>Unable to strip staff.</h3>";
    header('location:staff_list.php');
}