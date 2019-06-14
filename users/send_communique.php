<?php
/**
 * Created by PhpStorm.
 * User: HP USER
 * Date: 12/14/2016
 * Time: 1:38 PM
 */
session_start();ob_start();
include '../includes/conn.php';
    $subject = $_POST['subject'];
     $content = $_POST['addcontent'];
    if( !empty($_FILES['file']['name'])){
        $file_name=time().str_replace(" ", "_",$_FILES['file']['name']);
        $size=$_FILES['file']['size'];
        $type=strtolower($_FILES['file']['type']);
        $temp=$_FILES['file']['tmp_name'];
        //$valid_formats=array("pdf","doc","docx","ppt","txt","Applications.pdf");
        if(strtolower(($_FILES['file']['type']))=="pdf" or strtolower(($_FILES['file']['type']))=="application/pdf"
            or strtolower(($_FILES['file']['type']))=="image/png"
            or strtolower(($_FILES['file']['type']))=="image/jpeg"){
            if(($_FILES['file']['size'])/1000<=20480){
                $newName = $file_name;
                $save_file=move_uploaded_file($temp,"../images/documents/communique/".$newName);
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
$extras=trim($_POST['ida']);
$exts =explode(",",$extras);
for($i=0;$i<count($exts)-1;$i++){
    $recID = $exts[$i];
    $insert = mysqli_query($con,"INSERT INTO communique (recID,subject,content,filename,timecreated)
                VALUES('$recID','$subject','$content','$newName',NOW())");
    mysqli_error($con);
}
    $_SESSION['doc']="<h3 style='color:green;'>Communique successfully added</h3>".mysqli_error($con);
    header('location:communique.php');


?>

?>
