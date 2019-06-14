<?php	require 'session.php';?>
<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/html">
<head>
    <meta charset="utf-8">
    <meta name="viewport"    content="width=device-width, initial-scale=1.0">
    <meta name="description" content="KASU HRM ">
    <meta name="author"      content="KASU">
    <title><?php echo $title?></title>
    <!-- Bootstrap core CSS -->
    <link href="../dist/css/bootstrap.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link rel="shortcut icon" href="../images/kasulogo.png"  type="image/x-icon">
    <link href="../dist/css/main.css" rel="stylesheet">

    <script  src='../assets/jquery.js'></script>
    <script src="../assets/jquery-1.7.2.min.js"></script>
    <link type="text/css" href="../dist/css/datetime.css" rel="stylesheet" />
    <script type="text/javascript" src="../dist/js/jquery.datetimepicker.full.js"></script>
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script type="text/javascript" src="../assets/jquery.min.js"></script>
    <script type="text/javascript" src="../assets/jquery-ui-1.8.21.custom.min.js"></script>
    <script src="../assets/js/html5shiv.js"></script>
    <script src="../assets/js/respond.min.js"></script>
    <![endif]-->
    <script type="text/javascript" src="../assets/jquery.form.js"></script>
    <script type="text/javascript" >

        $(document).ready(function() {
            $('#photoimg').live('change', function(){
                $("#preview").html('');
                $("#preview").html('<img src="../images/passport/loader.gif" alt="Uploading...." width="160px" height="160px"/>');
                $("#imageform").ajaxForm({
                    target: '#preview'
                }).submit();

            });
            <!--state $ lgvmnt-->
            $(function(){
                $("#state").change(function(){
                    $.get("local_govt.php", {state_id:$("#state").val()}, function(data){$("#lga").html(data);});
                    return false;
                });
            });

        });
    </script>
</head>
<body>	<!-- Fixed navbar -->
	<div class="navbar navbar-inverse navbar-fixed-top" >
		<div class="container">
			<div class="navbar-header">
				<!-- Button for smallest screens -->
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
				<a class="navbar-brand hidden-xs hidden-sm" href="#"><img src="../images/kasulogo.png" style="max-height:80px" alt="KASU Logo">Human Resource Management</a>
			</div>
			<div class="navbar-collapse collapse">
				<ul class="nav navbar-nav pull-right">
                    <?php
                    $usertype = $_SESSION['usertype'];
                    $role = $_SESSION['role'];
                    echo '<li><a href="my_profile.php" class="smoothScroll">Home</a></li>';
                    if($role=='head'){
                        echo '<li class="dropdown">
									<a href="#" class="dropdown-toggle" data-toggle="dropdown">Unit Staff <b class="caret"></b></a>
									<ul class="dropdown-menu">
                        <li><a href="unit_applications.php" class="smoothScroll">Leave Applications</a></li>
                        <li><a href="unit_promotion.php" class="smoothScroll">Due Promotions</a></li>
                        <li><a href="recommend_promotion.php" class="smoothScroll">Recommend Promotions</a></li>

								</ul></li>';
                    }
					$fullname = ucfirst($_SESSION['sname'])." ".ucfirst($_SESSION['onames'] );
					if($usertype!='staff'){
						echo '<li class="dropdown">
									<a href="#" class="dropdown-toggle" data-toggle="dropdown">Manage Staff <b class="caret"></b></a>
									<ul class="dropdown-menu">
										<li><a href="register_staff.php"><span class=""></span> Register Staff</a></li>
										<li><a href="staff_list.php"> <span class=""></span> Staff List</a></li>
										<li><a href="leave_applications.php"> <span class=""></span> Leave Applications</a></li>
										<li><a href="promotion_list.php"> <span class=""></span> Promotions</a></li>
										<li class="divider"></li>
                                        <li><a href="communique.php"><span class=""></span>Communiques</a></li>
                                        <li><a href="updates.php"><span class=""></span>General Updates</a></li>
                                        <li><a href="feedback.php"><span class=""></span>Feedback</a></li>

									</ul>
								</li>';
					}

					?>
					<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">My Page<b class="caret"></b></a>
						<ul class="dropdown-menu">
                            <li class="dropdown-header">Profile</li>
							<li><a href="my_profile.php"><span class=""></span> View Profile</a></li>
							<li><a href="edit_profile.php"> <span class=""></span> Edit Profile</a></li>
                            <li class="divider"></li>
                            <li><a href="my_documents.php"><span class=""></span> Document Uploads</a></li>
                            <li class="divider"></li>
                            <li><a href="leave.php"><span class=""></span>Leave Application</a></li>
                            <li class="divider"></li>
                            <li><a href="my_communique.php"><span class=""></span>My Communiques</a></li>
                            <li class="divider"></li>
                            <li><a href="message_box.php"><span class=""></span>Message Box</a></li>
                            <li class="divider"></li>
                            <li><a href="change_password.php"><span class=""></span> Change Password</a></li>
						</ul>
					</li>
					<li><a href="logout.php" class="smoothScroll">Log Out</a></li>
				</ul>
			</div><!--/.nav-collapse -->
		</div>
	</div> 
	<!-- /.navbar -->
	<div class="home" id="cc">
		<div class="container">
			<div class="alert alert-success">
				<span style="font-size:30px;color:#005500;" >Welcome, <strong> <?php echo $fullname; ?></strong></span>
				<span class="pull-right" style="font-size:30px;text-decoration:underline;color:#555;">
				<?php
                echo $_SESSION['pnum'];
				?>
				</span> 
			</div>