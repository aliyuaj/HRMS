<?php
/**
 * Created by PhpStorm.
 * User: HP USER
 * Date: 12/12/2016
 * Time: 2:08 PM
 *
 */session_start();ob_start();
include '../includes/conn.php';
if(isset($_POST['addLeave'])){
    echo $type = $_POST['leavetype'];
    echo $commence = $_POST['commence'];
   $commence = date('Y-m-d',strtotime("$commence"));
    $address = $_POST['leaveaddress'];
    $staffID = $_SESSION['pnum'];
    if( !empty($_FILES['file']['name'])){
        $file_name=time().'KASUleave';
        $size=$_FILES['file']['size'];
        $type=strtolower($_FILES['file']['type']);
        $temp=$_FILES['file']['tmp_name'];
        //$valid_formats=array("pdf","doc","docx","ppt","txt","Applications.pdf");
        if(strtolower(($_FILES['file']['type']))=="pdf" or strtolower(($_FILES['file']['type']))=="application/pdf"
            or strtolower(($_FILES['file']['type']))=="image/png"
            or strtolower(($_FILES['file']['type']))=="image/jpeg"){
            if(($_FILES['file']['size'])/1000<=20480){
                $newName = $file_name;
                $save_file=move_uploaded_file($temp,"../images/documents/leavedocs/".$newName);
                if($save_file){


                }else{
                    echo $_SESSION['doc']="There was a problem while uploading this doc.";
                    header('location:leave.php');
                }
            }
            else{
                echo $_SESSION['doc']="Size too big. File should be less than 1MB";
                header('location:leave.php');
            }
        }
        else{
            $_SESSION['doc']="<h3 style='color:red;'>Invalid doc format. Attach JPG, PNG or PDF files only</h3>";
            header('location:leave.php');
        }
    }else $newName="";
     $daysquery = mysqli_fetch_assoc(mysqli_query($con,"SELECT * FROM leavetypes WHERE id='$type'"));
    echo $maxdays = $daysquery['totaldays'];
   // echo $maxdays = $getDays['totaldays'];
    echo"Ending".$ending = date('Y-m-d',strtotime("+$maxdays day $commence"));
     $insert = mysqli_query($con,"INSERT INTO leaveapplic (applicantID, datefrom,dateto,numdays,leaveaddress,dateapplied,leavetype, file)
                VALUES('$staffID','$commence','$ending','$maxdays','$address',CURDATE(),'$type','$newName')");
 mysqli_error($con);
    $_SESSION['doc']="<h3 style='color:green;'>Leave successfully applied</h3>";
    header('location:leave.php');

}
?>