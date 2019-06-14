<?php session_start();
include("includes/conn.php");
function spamcheck($field){
		//filter_var() sanitizes the e-mail address using FILTER_SANITIZE_EMAIL
		$field=filter_var($field, FILTER_SANITIZE_EMAIL);

		//filter_var() validates the e-mail address using FILTER_VALIDATE_EMAIL
		if(filter_var($field, FILTER_VALIDATE_EMAIL)){
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
//Function to sanitize values received from the form. Prevents SQL injection
function clean($str) {
    global $con;
    $str = @trim($str);
    if(get_magic_quotes_gpc()) {
        $str = stripslashes($str);
    }
    return mysqli_real_escape_string($con,$str);
}

$err_flag = false;
$err_msg_arr = array();

$name = clean($_POST['yname']);
$email = clean($_POST['email']);
$message = clean($_POST['message']);

//Validation of control
if($name == '') {
    $err_flag = true;
    $err_msg_arr[] = 'Name is required';
}
  $mailcheck = spamcheck($email);
//if "email" is filled out, proceed check if the email address is invalid
if($email == '') {
    $err_flag = true;
    $err_msg_arr[] = 'Email is required';
}else if($mailcheck==FALSE){
	$err_flag = true;
    $err_msg_arr[] = 'Invalid Email address';
	   }

if(empty($message)) {
    $err_flag = true;
    $err_msg_arr[] = 'Enter message to send';
}
if($err_flag == true) {
    $_SESSION['ERR_CON_ARR'] = $err_msg_arr;
    header('location:index.php#contact');
	exit();
}
$query=mysqli_query($con,"INSERT INTO feedbacks(sender,email,msg,senddate,replied) VALUES('$name','$email','$message',NOW(),'no')");
	if(mysqli_affected_rows($con)>0){
	$err_msg_arr[] = 'Your message has been sent. Thank you';
	$_SESSION['ERR_CON_ARR'] =$err_msg_arr;
		header("location:index.php#contact");
		exit();
	}else{
		$err_msg_arr[] = 'Could not send message. please try again'.mysqli_error($con);
		$_SESSION['ERR_CON_ARR']=$err_msg_arr;
		header("location:index.php#contact");		
		exit();
	}
?>