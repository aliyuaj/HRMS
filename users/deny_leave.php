<?php
/**
 * Created by PhpStorm.
 * User: HP USER
 * Date: 12/20/2016
 * Time: 12:32 AM
 */

session_start();ob_start();
include '../includes/conn.php';
$id=$_GET['appID'];
$update=mysqli_query($con,"UPDATE leaveapplic SET status='denied',dateapproved=CURDATE(), approvedbyID='".$_SESSION['pnum']."'   WHERE applicationID='$id'");
if(($update)){
    echo $_SESSION['action']="<h3 style='color:green'>Leave denied</h3>";
    header('location:unit_applications.php');
}
else{
    echo $_SESSION['action']="<h3 style='color:red'>Unable to deny leave.</h3>".mysqli_error($con);
    header('location:unit_applications.php');
}
?>