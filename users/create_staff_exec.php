<?php
//Starts Session
session_start();ob_start();
//include connection parameters
include("../includes/conn.php");

//Function to sanitize values received from the form. Prevents SQL injection
function clean($str) {
    $str = @trim($str);
    if(get_magic_quotes_gpc()) {
        $str = stripslashes($str);
    }
    return mysql_real_escape_string($str);
}

$err_flag = false;
$err_msg_arr = array();

//Sanitize the POST values
$username = clean($_POST['username']);
$password = clean($_POST['password']);
$usergroup = clean($_POST['usergroup']);

//Input Validations
if($username == '') {
    $err_msg_arr[] = 'Username is missing';
    $err_flag = true;
}
if($password == '') {
    $err_msg_arr[] = 'Password is missing';
    $err_flag = true;
}
if($usergroup == 'sel') {
    $err_msg_arr[] = 'Please select a usergroup';
    $err_flag = true;
}

//Check for duplicate login ID
if($username != '') {
    $qry = "SELECT * FROM users WHERE username = '$username'";
    $result = mysql_query($qry);
	if(mysql_num_rows($result) > 0) {
		$err_msg_arr[] = 'ID already exists';
		$err_flag = true;
	}
}

//If there are input validations, redirect back to the registration form
if($err_flag) {
    $_SESSION['ERR_MSG_ARR'] = $err_msg_arr;
    header("location: register_staff.php");
    exit();
}

//Create INSERT query
$qry = "INSERT INTO tblusers VALUES('','$username','$password','$usergroup')";
$result = @mysql_query($qry);

//Check whether the query was successful or not
if($result) {
    $_SESSION['NEW_PNUM'] = $username;
    header("location: new_staff_profile.php");
    exit();
}else {
    die("Query failed");
}
?>