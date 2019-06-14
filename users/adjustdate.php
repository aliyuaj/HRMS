<?php
/**
 * Created by PhpStorm.
 * User: HP USER
 * Date: 2/18/2017
 * Time: 11:31 PM
 */
include '../includes/conn.php'	;
session_start();ob_start();
 echo $commence = date('Y-m-d',strtotime("+0 day $commence"));
  $duration = $_POST['duration'];
 $appid = $_POST['uid'];
// echo $maxdays = $getDays['totaldays'];
echo $ending = date('Y-m-d',strtotime("+$duration day $commence"));
$update = mysqli_query($con,"UPDATE leaveapplic SET datefrom='$commence',dateto='$ending',numdays=$duration,status='approved',dateapproved=CURDATE(), approvedbyID='".$_SESSION['pnum']."'   WHERE applicationID='$appid'");
if(($update)){
    echo $_SESSION['action']="<h3 style='color:green'>Leave application approved</h3>";
    header('location:unit_applications.php');
}
else{
    echo $_SESSION['action']="<h3 style='color:red'>Unable to approve.</h3>".mysqli_error($con);
    header('location:unit_applications.php');

}

