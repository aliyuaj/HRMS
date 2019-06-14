<?php
session_start();ob_start();
include '../includes/conn.php';
//doc upload
if( !empty($_FILES['file']['name'])){
    $file_name=time().str_replace(" ", "_",$_FILES['file']['name']);
    $size=$_FILES['file']['size'];
    $type=strtolower($_FILES['file']['type']);
    $temp=$_FILES['file']['tmp_name'];
    //$valid_formats=array("pdf","doc","docx","ppt","txt","Applications.pdf");
    if(strtolower(($_FILES['file']['type']))=="pdf" or strtolower(($_FILES['file']['type']))=="application/pdf"
        or strtolower(($_FILES['file']['type']))=="image/png"
        or strtolower(($_FILES['file']['type']))=="image/jpeg"
        or strtolower(($_FILES['file']['type']))=="application/msword"
        or strtolower(($_FILES['file']['type']))=="application/msword"
        or strtolower(($_FILES['file']['type']))=="application/vnd.openxmlformats-officedocument.wordprocessingml.document"
        or strtolower(($_FILES['file']['type']))=="application/vnd.ms-word.template.macroenabled.12.dotm"
        or strtolower(($_FILES['file']['type']))=="binary/octet-stream"
        or strtolower(($_FILES['file']['type']))=="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"
        or strtolower(($_FILES['file']['type']))=="application/vnd.ms-powerpoint"){
        if(($_FILES['file']['size'])/1000<=20480){
            $newName = $file_name;
            $save_file=move_uploaded_file($temp,"../images/documents/".$newName);
            if($save_file){

                $docId= "doc".time();
                $desc = ucwords(strtolower($_POST['description']));
                $docType = $_POST['doctype'];
                $insert = mysqli_query($con,"INSERT INTO documents (docID,filedesc,filesize,filetype,filename,empid,date)
                VALUES('$docId','$desc','$size','$docType','$newName','{$_SESSION['pnum']}',CURDATE())");
                if($insert){
                    echo $_SESSION['doc']="Doc upload successful";
                    header('location:my_documents.php');
                }else echo mysqli_error($con);
            }else{
                echo $_SESSION['doc']="There was a problem while uploading this doc.";
                header('location:my_documents.php');
            }
        }
        else{
            echo $_SESSION['doc']="Size too big. File should be less than 1MB";
            header('location:my_documents.php');
        }
    }
    else{
        $_SESSION['doc']="<h3 style='color:red;'>Invalid doc format</h3>";
        header('location:my_documents.php');
    }
}
?>