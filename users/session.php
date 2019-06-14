<?php
	 session_start();  ob_start();//Start session
		//Check whether the session variable log is present or not
	if(!isset($_SESSION['usertype']) || (trim($_SESSION['usertype']) == '')) {
		header("location: ../404.html");
		exit();
	}
	
?>