<?php
/**
 * Created by PhpStorm.
 * User: HP USER
 * Date: 12/12/2016
 * Time: 11:21 PM
 */
include '../includes/conn.php'	;
$title = 'KASU HRMS Staff Communique';
include  'header.php';
$usertype = $_SESSION['usertype'];
if($usertype=='admin' || $usertype=='management') {
}else{
    session_destroy();
    header('location: ../404.html');
}
?>

<div class="container text-center" style="color:red;font-size:40px;padding:50px;">
			Invalid page Request. Go back and try again.
		</div>
	</div>
</div>
<div id="push">

</div>
<!-- JavaScript libs are placed at the end of the document so the pages load faster -->
<script src="../assets/js/smoothscroll.js"></script>
<script src="../dist/js/bootstrap.min.js"></script>
<script src="../includes/footer.js"></script>
</body>
</html>