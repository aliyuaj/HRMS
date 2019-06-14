<?php
$title = 'KASU Change Password';
include  'header.php';?>
		<div>
			<form class="form-mid" style="max-width: 350px;padding-top: 60px;padding-bottom: 180px;margin: 0 auto"method="POST" action="change_password.php">
				<fieldset>
					<legend style="text-align:center;font-size:25px;">Change Password</legend>
					<div class="form-group"><input type="text" class="form-control"  name="opass"placeholder="Old Password" ></div>
					<div class="form-group"><input type="password" class="form-control"  name="npass"placeholder="New Password" ></div>
					<div class="form-group"> <input type="password" class="form-control" name="rnpass" placeholder="Re-type New Password"> </div>
					<button class="btn btn-lg btn-primary btn-block" type="submit" name="change">Change</button>
				</fieldset>
				 <?php 
					// Checking for password change
					if(isset($_SESSION['change'])) {
						echo "<div style='color: red; font-size:18px;font-weight:bold;padding-top:10px;text-align:center;'>".$_SESSION['change']."</div>";
						unset($_SESSION['change']);
					}
				?>
			</form>
		</div>
	</div>
</div>
<!-- JavaScript libs are placed at the end of the document so the pages load faster -->
<script src="../assets/js/smoothscroll.js"></script>
<script src="../dist/js/bootstrap.min.js"></script>
<script src="../includes/footer.js"></script>
</body>
</html>
<?php
    include '../includes/conn.php';
	$id=$_SESSION['pnum'];
	if(isset($_POST['change'])){
		$opass=trim($_POST['opass']);
		if(isset($_POST['opass'])){
			if(strlen($opass)!=0){
				$query7=mysqli_query($con,"SELECT * FROM users WHERE staffID='$id' && password='$opass'");
				if(mysqli_num_rows($query7)==1){
				$npass=trim($_POST['npass']);
				$rnpass=trim($_POST['rnpass']);
					if(strlen($npass)!=0 && strlen($rnpass)!=0){
						if($npass==$rnpass){
							if(strlen($npass)>=7){
								$query1=mysqli_query($con,"UPDATE users SET password='$npass' WHERE staffID='$id'");
								if(mysqli_affected_rows($con)==1){
								$_SESSION['change']="Password changed successfully";
									header('location:change_password.php');
								}else {
								$_SESSION['change']="Unable to update Password".mysqli_error($con);
									header('location:change_password.php');
								}
							}else {
								$_SESSION['change']="Password should  be at least 7 characters";
									header('location:change_password.php');
							}
						}else {
							$_SESSION['change']="New password and its re-type do not match";
							header('location:change_password.php');
						}
					}else {
					$_SESSION['change']="Enter New Password and Re-type";
					header('location:change_password.php');
					}
			}else {
				echo $_SESSION['change']="ID does not match password".mysqli_error($con);
			}
			}else {
				$_SESSION['change']="Enter Old Password";
				header('location:change_password.php');
			}
		}
	}
?>