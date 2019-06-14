<?php session_start(); ob_start();
include_once "../includes/conn.php"; 
echo $s = $_POST["delId"];
$sql = mysqli_query($con,"DELETE FROM documents WHERE docID = '$s'");
if(mysqli_affected_rows($con)==1){
	$_SESSION['delete']="Document successfully removed";
	header("location: my_documents.php");
}
else{
	$_SESSION['request']="Unable to delete document";
	header("location: my_documents.php");
}
?>