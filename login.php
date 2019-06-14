<?php
//Starts Session
session_start();ob_start();
//include connection parameters
include("includes/conn.php");
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
$staffID = clean($_POST['username']);
$password = clean($_POST['password']);

//Validation of control
if($staffID == '') {
    $err_flag = true;
    $err_msg_arr[] = 'staffID required';
}

if($password == '') {
    $err_flag = true;
    $err_msg_arr[] = 'Password required';
}

if($err_flag == true) {
    $_SESSION['ERR_MSG_ARR'] = $err_msg_arr;
    header("location: index.php#login");
    exit();
}

$sql = "SELECT * FROM users JOIN personalinfo ON users.staffID = personalinfo.staffID WHERE users.staffID = '$staffID' AND password = '$password'";
$result = mysqli_query($con,$sql);

if(mysqli_num_rows($result) ==1) {
		$row = mysqli_fetch_array($result);
            if($row['suspended']=='0') {
                echo $usertype = $row['usertype'];
                echo $_SESSION['usertype'] = $row['usertype'];
                $_SESSION['sname'] = $row['surname'];
                $_SESSION['onames'] = $row['othernames'];
                $_SESSION['pnum'] = $row['staffID'];
                $_SESSION['role'] = $row['unitRole'];
                header("location: users/my_profile.php");
                exit;
            }else {
                $err_msg_arr[] = "Your account has been suspended contact the admin";
                $_SESSION['ERR_MSG_ARR'] = $err_msg_arr;
                header("location: index.php#login");
                exit();
            }
    }
    else {
		$err_msg_arr[]= "Invalid staffID or password";
        $_SESSION['ERR_MSG_ARR'] =$err_msg_arr;
        header("location: index.php#login");
        exit();
    }
	
?>