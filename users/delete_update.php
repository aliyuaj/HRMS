<?php
/**
 * Created by PhpStorm.
 * User: HP USER
 * Date: 12/13/2016
 * Time: 10:56 PM
 */session_start(); ob_start();
include_once "../includes/conn.php";
echo $s = $_POST["delId"];
$sql = mysqli_query($con,"DELETE FROM updates WHERE newsID = '$s'");
if(mysqli_affected_rows($con)==1){
    $_SESSION['del']="Update successfully removed";
    header("location: updates.php");
}
else{
    $_SESSION['del']="Unable to delete update";
    header("location: updates.php");
}
?>