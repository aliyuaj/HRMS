<?php
/**
 * Created by PhpStorm.
 * User: HP USER
 * Date: 2/19/2017
 * Time: 12:17 PM
 */
session_start();ob_start();
include '../includes/conn.php';
if(isset($_POST['send'])){
     $type = $_POST['select'];
    $comment = $_POST['comment'];
    $sid = $_POST['ssid'];
    $staffID = $_SESSION['pnum'];
    $insert = mysqli_query($con,"INSERT INTO promotion (empid,promdate,approvedBy,status,comment)
                VALUES('$sid',CURDATE(),'$staffID','$type','$comment')");
    if($update){
        $_SESSION['doc']="<h3 style='color:green;'>Promotion approved successful</h3>";
    }else{
        $_SESSION['doc']="<h3 style='color:green;'>Unable to approve promotion</h3>";
    }
    header('location:unit_promotion.php');
}
?>