<?php	
session_start();ob_start();
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
	if (isset($_POST['email'])){
	//if "email" is filled out, proceed check if the email address is invalid
	  $mailcheck = spamcheck($_POST['email']);
		 if ($mailcheck==FALSE){
				$_SESSION['recover'] = "Invalid email address";
		   }else
			{//send email
			include 'includes/conn.php';
			$email = $_POST['email'] ;
			$query=mysqli_query($con,"SELECT * FROM tblpersonalinfo WHERE email='$email' ");
			if(mysqli_num_rows($query)==1){
				$result = mysqli_fetch_assoc($query);			
				$pnum = $result['pnumber'];
				$query2=mysqli_query($con,"SELECT * FROM tblusers WHERE username='$pnum' ");
				$pword = mysqli_fetch_assoc($query2);			
				$pass = $pword['password'];
					$subject = "Pasword recovery" ;
					$message = "Your password request was received.Your password is $pass<>";
					if(@mail("$email", "Subject: $subject",$message, "From: NAERLS Human Resource" )){
						 $_SESSION['recover'] = "Message sent.Thank you for using our mail form";
					}else{
						 $_SESSION['recover'] = "Unable to send mail check your network settings";
					}
			}else{
				$_SESSION['recover'] = "The email supplied is not registered";
			}
		}
	}
header('location: index.php#login')	
?>
