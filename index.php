<?php 
session_start();ob_start();
include 'includes/conn.php'	;
	?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport"    content="width=device-width, initial-scale=1.0">
	<meta name="description" content="KASU HRM Human Resource Management">
	<meta name="author"      content="KASU">
	<title>KASU HRMS : Home</title>
    <!-- Bootstrap core CSS -->
    <link href="dist/css/bootstrap.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link rel="shortcut icon" href="images/kasulogo.png"  type="image/x-icon">
	<link href="dist/css/main.css" rel="stylesheet">
	<script src="assets/jquery-1.7.2.min.js"></script>
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="assets/js/html5shiv.js"></script>
      <script src="assets/js/respond.min.js"></script>
    <![endif]-->
	<script>
		$(document).ready(function(){$('#update').on('show.bs.modal',function(e){
		var author=$(e.relatedTarget).data('author');
		$(e.currentTarget).find('span[name="author"]').text(author);
		var title=$(e.relatedTarget).data('title');
		$(e.currentTarget).find('h2[name="title"]').text(title);
		var cont=$(e.relatedTarget).data('news');
		$(e.currentTarget).find('p[name="news"]').text(cont);
		var date=$(e.relatedTarget).data('date');
		$(e.currentTarget).find('span[name="date"]').text(date);
		});
		});	
		
	</script>
</head>

<body>
	<!-- Fixed navbar -->
	<div class="navbar navbar-inverse navbar-fixed-top" >
		<div class="container">
			<div class="navbar-header">
				<!-- Button for smallest screens -->
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
				<a class="navbar-brand hidden-xs hidden-sm" href="#home"><img src="images/kasulogo.png" style="max-height:80px" alt="KASU Logo"><span style="color:#00CC00">KASU </span>Human Resource Management System</a>
			</div>
			<div class="navbar-collapse collapse">
				<ul class="nav navbar-nav pull-right">
					<li><a href="#home" class="smoothScroll">Home</a></li>
					<li><a href="#about" class="smoothScroll">About</a></li>
					<li><a href="#updates" class="smoothScroll">Updates</a></li>
					<li><a href="#contact" class="smoothScroll">Contact</a></li>
					<li><a href="#login" class="smoothScroll">Login</a></li>
				</ul>
			</div><!--/.nav-collapse -->
		</div>
	</div> 
	<!-- /.navbar -->
	<div class="home" id="home">
	  <div id="carousel-example-generic" class="carousel slide" >
      <!-- Indicators -->
      <ol class="carousel-indicators">
    <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
    <li data-target="#carousel-example-generic" data-slide-to="1" ></li>
    <li data-target="#carousel-example-generic" data-slide-to="2" ></li>
	<li data-target="#carousel-example-generic" data-slide-to="3" ></li>      </ol>
      <div class="carousel-inner">
        <div class="item active">
          <img src="images/kasu1.png" alt="First slide"  width="100%" class="img-responsive">
          <div class="container">
            <div class="carousel-caption">
			<h2>KASU Senate Building</h2>              
             <p>Kaduna State University Administrative Building at the Main Campus, Kaduna ...</p>
			</div>
          </div>
        </div>
        
        <div class="item">
          <img src="images/kasu2.jpg" alt="Fourth slide"  width="100%" class="img-responsive">
          <div class="container">
            <div class="carousel-caption"> 
			<h2>KASU Senate Building</h2>              
             <p>Kaduna State University Administrative Building at the Main Campus, Kaduna ...</p>
              </div>
          </div>
        </div>
        <div class="item">
          <img src="images/kasu3.jpg" alt="Third slide"  width="100%" class="img-responsive">
          <div class="container">
            <div class="carousel-caption">
				<h2>KASU Senate Building</h2>              
             <p>Kaduna State University Administrative Building at the Main Campus, Kaduna ...</p>
              </div>
          </div>
        </div>
		<div class="item">
          <img src="images/kasu4.jpg" alt="Second slide"  width="100%" class="img-responsive">
          <div class="container">
            <div class="carousel-caption">
			<h2>KASU Senate Building</h2>              
             <p>Kaduna State University Administrative Building at the Main Campus, Kaduna ...</p>
			 </div>
          </div>
        </div>
      </div>
      <a class="left carousel-control" href="#carousel-example-generic" data-slide="prev"><span class="glyphicon glyphicon-chevron-left"></span></a>
      <a class="right carousel-control" href="#carousel-example-generic" data-slide="next"><span class="glyphicon glyphicon-chevron-right"></span></a>
      </div><!-- /.carousel -->
	
	<!-- Intro -->
	<div class="container" id="about">
		<div   class="row white">
			<br><br>
			<h1 class="centered">ABOUT THIS APPLICATION</h1>
			<hr>
			<p style="text-align:center;font-size:20px;line-height:40px;">
				The Human Resource Unit has been one of the leading role model in the univerity in terms of the use of Information technology
				over the years. One of the goals (policy) of KASU is moving towards a completely paperless organization (e-document).			
				One of the most unique culture of the institute is the involvement of ICT in all it does to try a simplify the way things are been done.
				After much hard work brought about the design and development of this application
				to address these problems as well as taking into consideration future needs of a comprehensive staff database.
			</p>
		</div>
	</div>
	<!-- ==== DIVIDER1 -->
		<div class="divider1">	
		<p class="div-text">To achieve real change, we have to expand boundaries. Because the Wild West of what-could-be is unexplored but rife with opportunity.</p>
		</div><!-- section -->
		
	<!-- ==== UPDATES ==== -->
		<div class="container" id="updates" name="blog">
		<br>
			<div class="row white">
				<br>
				<h1 class="centered">HUMAN RESOURCE UPDATES</h1>
				<hr>
				<br>
				<br>
			</div><!-- /row -->
				
			</div><!-- /row -->
			<!-- Manual Updates Modal -->
  <div class="modal fade" id="update" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header" style="background-color:#00cc00;color:white;">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h3 class="modal-title">Human Resource Update</h3>
        </div>
        <div class="modal-body">
			<u><h2  name="title"></h2></u>
			 <span name="author"> </span><span class="pull-right" name="date"></span>
			<p name="news"></p>
		</div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>		
		</form>
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->
  </div>
<!-- //projects -->
<?php 				
	 $news= mysqli_query($con,"select * from updates");
	 if(mysqli_num_rows($news)>0){
		echo '<div class="flex-slider" style="background-color:#56ac93;;border-top:1px solid #00dd00;border-bottom:1px solid #00dd00;">
		<ul id="flexiselDemo1">		';
				 }
				while($row=mysqli_fetch_assoc($news))
					{   
					$id=$row['newsID'];
					$title=$row['title'];
					$update=$row['content'];
					$author=$row['author'];
					$date=$row['date'];
					echo '<li >
						<div class="media text-center" style="min-height:250px;max-height:250px;padding:30px 10px;color:white;border-left:1px solid #00dd00;border-right:1px solid #00dd00;">
							<div style="padding:5px;" >';
								echo "
								<div><h2>$title</h2>";
								if(strlen($update)>	100){
								echo "<p>".substr($update,0,100)."... <a data-toggle='modal' data-author='".$author."' data-news='".$update."' data-title='".$title."' data-date='".$date."' href='#update' class='icon icon-link'>
								Read More</a></p></div>";
								}else{
								echo "<p>$update</p>";							
								}
							echo'
							</div>
						</div>
					</li>';
						
						
					}
		 ?> 
		</ul>
		<script>
				$(window).load(function() {
					$("#flexiselDemo1").flexisel({
						visibleItems: 4,
						animationSpeed: 1000,
						autoPlay: true,
						autoPlaySpeed: 3000,    		
						pauseOnHover: true,
						enableResponsiveBreakpoints: true,
						responsiveBreakpoints: { 
							portrait: { 
								changePoint:480,
								visibleItems: 2
							}, 
							landscape: { 
								changePoint:640,
								visibleItems: 3
							},
							tablet: { 
								changePoint:768,
								visibleItems: 3
							}
						}
					});
					
				});
		</script>
		<script  src="assets/js/jquery.flexisel.js"></script>
</div><!-- /container -->
	<!-- ==== DIVIDER1 -->
		<div class="divider1">	
		<p class="div-text">There is no limit to what you can achieve. It all depends on you.</p>
		</div><!-- section -->
	
		
	<div class="container" id="contact">
		<div  class="row white">
			<br><br>
			<h1 class="text-center" >LET'S HEAR FROM YOU</h1>
			<hr>
			<div class="col-md-3"></div>
			<div class="col-md-7" >
			<p>
				<div align="left">
				<?php 
                    // Checking for message failure
					 if(isset($_SESSION['ERR_CON_ARR'])) {
						echo "<div style='color: red; font-size: 20px;'>";
						foreach($_SESSION['ERR_CON_ARR'] as $errc){
							echo $errc.'<br>';
						}
                        unset($_SESSION['ERR_CON_ARR']);
						echo "</div>";
					}
				?> 
				</div>
				<form class="form-horizontal" role="form" method="POST" action="contact.php">
				  <div class="form-group">
					<label for="inputEmail1" class="col-lg-4 control-label"></label>
					<div class="col-lg-10">
					  <input type="email" class="form-control" id="inputEmail1" name="email" placeholder="Email">
					</div>
				  </div>
				  <div class="form-group">
					<label for="text1" class="col-lg-4 control-label"></label>
					<div class="col-lg-10">
					  <input type="text" class="form-control" id="text1" name="yname" placeholder="Your Name">
					</div>
				  </div>
				  <div class="form-group">
					<div class="col-lg-10">
					<textarea rows="5"  placeholder="Type your message here..." name="message" class="form-control"></textarea>
					</div>
				  </div>
				  <div class="form-group">
					<div class="col-lg-10">
					  <button type="submit" class="btn btn-success pull-right">SEND MESSAGE</button>
					</div>
				  </div>
			   </form><!-- form -->
			</p>
			</div>
			<div class="col-md-3 "></div>
		</div>
	</div>
	<!-- ==== DIVIDER1 -->
		<div class="divider2">
					<p class="div-text">To achieve real change, we have to expand boundaries. Because the Wild West of what-could-be is unexplored but rife with opportunity.</p>
		</div><!-- section -->
	
	<div class="container" id="login">
		<div class="row white">
			<br><br>
			<h1 class="centered">SIGN IN TO YOUR ACCOUNT</h1>
			<hr>
			<div class="col-md-4 "></div>
			<div class="col-md-4" >
			<p>
				<div align="left"><?php 
                    // Checking for login failure
					 if(isset($_SESSION['ERR_MSG_ARR'])) {
						echo "<div style='color: red; font-size: 20px;'>";
							foreach($_SESSION['ERR_MSG_ARR'] as $err){
								echo $err.'<br>';
							}
                        unset($_SESSION['ERR_MSG_ARR']);
						echo "</div>";
                    }?></div>
				<form class="form-horizontal" role="form" method="POST" action="login.php">
				  <div class="form-group">
					<label for="inputEmail1" class="col-lg-4 control-label"  style="text-align:left">USER ID</label>
					<div class="col-lg-10">
					<input type="text" class="form-control" name="username">					
					</div>
				  </div>
				  <div class ="form-group">
					<label for="text1" class="col-lg-4 control-label" style="text-align:left">PASSWORD</label>
					<div class="col-lg-10">
					<input type="password" class="form-control" name="password">					
					</div>
				  </div>
				 <div class="form-group">
					<div class="col-lg-10">
					  <button type="submit" class="btn btn-lg btn-success btn-block btn-success">LOGIN</button>
					</div>
                     <a href="#forgot_password" data-toggle="modal"> Forgot password ?</a>
				  </div>
			   </form><!-- form -->

				  <?php if(isset($_SESSION['recover'])) {
						echo "<div style='color: red; font-size: 20px;'>";
							echo $_SESSION['recover'];
							unset($_SESSION['recover']);
						echo "</div>";
						}
					?>
			</p>
			</div>
			<div class="col-md-4 "></div>
		</div>
	</div>
	</div><!-- col -->
	
	<!-- /.forgot_password modal -->
	 <div class="modal fade" id="forgot_password" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title">Password Recovery</h4>
        </div>
        <div class="modal-body">
		<form method="POST" action="forgot_password.php">
			<div class="form-group">
				<input type="email" name="email" class="form-control" placeholder="Enter your registration Email" >
			</div>
				
		</div>
			<div class="modal-footer">
			  <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
			  <button type="submit" class="btn btn-success">Request</button>
			</div>
		</form>
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->
	<!-- /Intro-->
	<!-- ==== DIVIDER1 -->
		<div class="divider4">
		</div><!-- section -->
	
	<script>
	    	$(window).load(function() {
    		$('.carousel').carousel({
    			animSpeed: 500,
                      pauseTime: 5000,
                      directionNav: true,
                      controlNav: false,
                      controlNavThumbs: false,
                      pauseOnHover: true,
                      manualAdvance: false,
                      prevText: 'Next',
                      nextText: 'Prev',
                      randomStart: false
              });
        });
    </script>
    
	<!-- JavaScript libs are placed at the end of the document so the pages load faster -->
	<script src="assets/js/smoothscroll.js"></script>
    <script src="dist/js/bootstrap.min.js"></script>
	<script src="includes/footer.js"></script>
</body>
</html>