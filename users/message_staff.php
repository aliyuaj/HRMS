<?php
/**
 * Created by PhpStorm.
 * User: HP USER
 * Date: 12/15/2016
 * Time: 7:16 AM
 */session_start();ob_start();
include '../includes/conn.php';
$message= $_POST['msg'];
$subject= $_POST['subject'];
$rid= $_POST['ida'];
$qact=mysqli_query($con,"INSERT INTO messages (subject,recipientID,msg,time)
						VALUES
						('$subject','$rid','$message',NOW())");
if($qact){
    echo $_SESSION['action']="<h3 style='color:green'>Message sent</h3>";
    header('location:staff_list.php');
}else{
    echo $_SESSION['action']="<h3 style='color:green'>Unable to send message".mysqli_error($con)."</h3>";
    header('location:staff_list.php');
}