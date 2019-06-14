<?php
include '../includes/conn.php'	;
$title = 'KASU HRMS Staff List';
include  'header.php';
$usertype = $_SESSION['usertype'];
if($usertype=='admin' || $usertype=='management') {
}else{
    session_destroy();
    header('location: ../404.php');
}
?>
<script>
    $(document).ready(function(){
        $('#message').on('show.bs.modal',function(e){
            var uid = $(e.relatedTarget).data('ids');
            $(e.currentTarget).find('input[name="ida"]').val(uid);
        });
    });


</script>
<?php
//check for contract expiry,leave due,retirement and alert.
$sqlstr=mysqli_query($con,"select * from hrsettings order by id desc");
$row=mysqli_fetch_assoc($sqlstr);

$contract=$row['contract'];
$leave=$row['leave'];
$retirement=$row['retirement'];
$retage=$row['retage'];

//retirement
if (!empty($retirement))
{
    //get retirement age - retirement notification difference
    if (!empty($retage))
        $agediff=$retage-$retirement;
    else
         $agediff=60-$retirement;

    //sql count
    $sqlstr=mysqli_query($con,"select * from personalinfo JOIN users on users.staffID = personalinfo.staffID where (DATEDIFF(now(),birthdate) / 365) >= $agediff
        and suspended='0' and empstat='1'");
    $row=mysqli_fetch_assoc($sqlstr);
    $count=mysqli_num_rows($sqlstr);
    echo mysqli_error($con);
    if ($count> 1){
        echo $retmsg = "<span class='blink' style='color:red'>There are ".$count." employees who are due to retire in $retirement years time.</span>
        <a href=\"retire_report.php\"> View list.</a>";
    }
    else if ($count==1){
        echo $retmsg = "<span class='blink' style='color:red;'>There is ".$count." employee who is due to retire in $retirement years time.</span>
         <a href=\"retire_report.php\"> View list</a>";
    }
}

?>
<div class="row">
    <div class="col-md-6"> <span class="lead" style="text-decoration: CaptionText">KASU Staff List</span></div>
        <div class="col-md-6 " style="paddig:5px 20px 15px 0">
            <form class="form-inline" role="form" action="staff_list.php" method="post">
                <div class="col-lg-6">
                        <label class="sr-only" for="exampleInputPassword2">Search Criteria</label>
                        <select class="form-control" name="searchterm">
                            <option value="staffID">Staff ID</option>
                            <option value="surname">  Surname</option>
                            <option value="othernames"> Other Names</option>
                            <option value="unitname">Unit</option>
                            <option value="rank">Rank</option>
                        </select>
                </div>


                    <div class="col-lg-6">
                        <div class="input-group">
                            <label class="sr-only" for="exampleInputEmail2">Search Term</label>
                            <input type="text" class="form-control" id="exampleInputEmail2" name="searchval" placeholder="Enter search term">
                            <span class="input-group-btn">
                                <button class="btn btn-default" type="submit"><span class="glyphicon glyphicon-search"></span></button>
                            </span>
                        </div>
                    </div>
                </form>
			</div>
		</div>
		<div class="text"align="center">
			<?php
            if(isset($_SESSION['action'])){
            echo '<div  class="text-success pull-left">';
            print $_SESSION['action']; unset($_SESSION['action']);
            echo '</div>';}
            if (!empty($_POST["searchterm"]))
            {
                switch ($_POST["searchterm"]) {
                    case "staffID":
                        $sqlstr="select * from personalinfo
                        LEFT join tblcountries on tblcountries.countryid=personalinfo.nationality
                        LEFT join tblstate on tblstate.stateid=personalinfo.state
                        LEFT join tbllga on tbllga.lgaid=personalinfo.lga
                        LEFT JOIN users on users.staffID=personalinfo.staffID
                        LEFT join ranks on ranks.rankID=personalinfo.rank
                        LEFT join tblunit on tblunit.unitid=personalinfo.unit where personalinfo.staffID like '%".$_POST["searchval"]."%'";
                        break;
                    case "surname":
                        $sqlstr="select * from personalinfo
                        LEFT join tblcountries on tblcountries.countryid=personalinfo.nationality
                        LEFT join tblstate on tblstate.stateid=personalinfo.state
                        LEFT join tbllga on tbllga.lgaid=personalinfo.lga
                        LEFT JOIN users on users.staffID=personalinfo.staffID
                        LEFT join ranks on ranks.rankID=personalinfo.rank
                        LEFT join tblunit on tblunit.unitid=personalinfo.unit where surname like '%".$_POST["searchval"]."%'";
                        break;
                    case "othernames":
                        $sqlstr="select * from personalinfo
                        LEFT join tblcountries on tblcountries.countryid=personalinfo.nationality
                        LEFT join tblstate on tblstate.stateid=personalinfo.state
                        LEFT join tbllga on tbllga.lgaid=personalinfo.lga
                        LEFT JOIN users on users.staffID=personalinfo.staffID
                        LEFT join ranks on ranks.rankID=personalinfo.rank
                        LEFT join tblunit on tblunit.unitid=personalinfo.unit where othernames like '%".$_POST["searchval"]."%'";
                        break;
                    case "unitname":
                    $sqlstr="select * from personalinfo
                        LEFT join tblcountries on tblcountries.countryid=personalinfo.nationality
                        LEFT join tblstate on tblstate.stateid=personalinfo.state
                        LEFT join tbllga on tbllga.lgaid=personalinfo.lga
                        LEFT JOIN users on users.staffID=personalinfo.staffID
                        LEFT join ranks on ranks.rankID=personalinfo.rank
                        LEFT join tblunit on tblunit.unitid=personalinfo.unit where unitname like '%".$_POST["searchval"]."%'";
                    break;
                    case "rank":
                    $sqlstr="select * from personalinfo
                        LEFT join tblcountries on tblcountries.countryid=personalinfo.nationality
                        LEFT join tblstate on tblstate.stateid=personalinfo.state
                        LEFT join tbllga on tbllga.lgaid=personalinfo.lga
                        LEFT join ranks on ranks.rankID=personalinfo.rank
                        LEFT JOIN users on users.staffID=personalinfo.staffID
                        LEFT join tblunit on tblunit.unitid=personalinfo.unit where rankname like '%".$_POST["searchval"]."%'";
                    break;
                }
            }else
                $sqlstr="select * from personalinfo
                    LEFT join tblcountries on tblcountries.countryid=personalinfo.nationality
                    LEFT join tblstate on tblstate.stateid=personalinfo.state
                    LEFT join tbllga on tbllga.lgaid=personalinfo.lga
                    LEFT JOIN users on users.staffID=personalinfo.staffID
                    LEFT join ranks on ranks.rankID=personalinfo.rank
                    LEFT join tblunit on tblunit.unitid=personalinfo.unit ";

            $per_page=15;
                    $pages_query=mysqli_num_rows(mysqli_query($con,$sqlstr));
                    $pages=ceil($pages_query/$per_page);
                    $page=(isset($_GET['page']))? (int)$_GET['page']:1;
					if($page==0){
						header('location:404.php');
					}
                    $start=($page-1)*$per_page;
					$squery=mysqli_query($con,"$sqlstr LIMIT $start,$per_page");
					$count=mysqli_num_rows($squery);
                ECHO mysqli_error($con);
				if($pages_query>0){
					echo "<div class='table-responsive text-center'>
					<table  class='table table-striped table-condensed table-bordered ' >
					<thead><tr>
					<td><b>S/No.</b></td><td><b>Staff ID</b></td><td><b>Full Name</b></td><td><b>Gender</b></td><td><b>Rank</b></td><td>Cadre</td><td>Action</td>
					</tr></thead> ";
					$i=($per_page*($page-1))+1;
					while($row = mysqli_fetch_array($squery)) {
						$pnumber = $row['staffID'];
						$surname = $row['surname'];
						$othernames = $row['othernames'];
						$gender = $row['gender'];
						$mstatus = $row['mstatus'];
						$birthdate = $row['birthdate'];
						$nationality = $row['countryname'];
						$state = $row['state'];
						$lga = $row['lga'];
						$email = $row['email'];
						$hometown = $row['hometown'];
						$contactaddress = $row['contactaddress'];
						$gsm = $row['gsm'];
						$firstappt = $row['firstappt'];
						$grade = $row['grade'];
						$qualificatn = $row['qualification'];
						$cadre = $row['ranktype'];
						$rank = $row['rankname'];
						$fullname=$surname." ".$othernames;
						echo "<tr><td>".$i."</td><td>".$pnumber."</td><td>".$fullname."</td><td>".$gender."</td><td>".$rank."</td><td>".$cadre."</td>";
                        echo '<td>
                        <div class="btn-group">
                        <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown">Action <span class="caret"></span></button>
                             <ul class="dropdown-menu" role="menu">
                                <li><a href="edit_staff_profile.php?id='.$row["staffID"].'"><i class="glyphicon glyphicon-edit"></i> Edit Profile</a></li>';
                        echo '<li><a href="#message" data-toggle="modal" data-ids="'.$row["staffID"].'"><i class="glyphicon glyphicon-envelope"></i> Message Staff</a></li>';
                        if($row['usertype']=='staff') {
                            echo '<li ><a href = "make_admin.php?id='.$row["staffID"].'"><span class="glyphicon glyphicon-star" ></span> Make admin</a ></li >';
                        }else{
                            echo '<li ><a href = "strip_admin.php?id='.$row["staffID"].'"><span class="glyphicon glyphicon-star_empty" ></span> Strip admin</a ></li >';
                        }
                        if($row['suspended']=='0') {
                            echo '<li ><a href = "suspend.php?id='.$row["staffID"].'"><i class="glyphicon glyphicon-eye-close" ></i > Suspend HRMS account</a ></li >';
                        }else{
                            echo '<li ><a href = "reactivate.php?id='.$row["staffID"].'"><i class="glyphicon glyphicon-eye-open" ></i > Reactivate account</a ></li >';
                        }
                echo '</ul>
                </div>
				</td></tr>';
						$i++;
					}
					echo '</table>';
					if($pages>1 && $page<=$pages){
					echo '<ul class="pagination hidden-print">';
					if($page>1){
						  echo'<li><a href="?page=1"> <span class="glyphicon glyphicon-backward"></a></li>';
					}
					if($page>1){
						$prev_page=$page-1;
						  echo'<li><a href="?page='.$prev_page.'"> <span class="glyphicon glyphicon-step-backward"></a></li>';
					}
					echo "<li class='active'><a >$page of $pages</a></li>";
					if($page<$pages){
						$next_page=$page+1;
						  echo'<li><a href="?page='.$next_page.'"> <span class="glyphicon glyphicon-step-forward"></a></li>';
					}if($page<$pages){
						$next_page=$page+1;
						  echo'<li><a href="?page='.$pages.'"> <span class="glyphicon glyphicon-forward"></a></li>';
					}
					echo '</ul>';
					}elseif($page>$pages) { 
						header ('location:404.php');
						exit();
					}
					echo '</div>';
				}else echo "<h2 class='text-center text-danger'>No match found</b></h2>";
			?>
		</div>
	</div>
</div>

<!-- Add Document Modal -->
<div class="modal fade" id="message" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h3 class="modal-title">Message Staff</h3>
            </div>
            <div class="modal-body">
                <form method="POST" action="message_staff.php" class="form-horizontal" role="form" >
                    <div class="form-group"  id="lfile">
                        <label for="inputTitle" class="col-lg-2 control-label">Subject</label>
                        <div class="col-lg-10">
                            <input type="text" name="ida" style="display: none">
                            <input type="text" class="form-control " id="inputEmail1"  name="subject" placeholder="Enter Message Subject" >
                        </div>
                    </div>
                    <div class="form-group" id="date">
                        <label for="inputEmail1" class="col-lg-2 control-label">Message</label>
                        <div class="col-lg-10">
                            <textarea type="text" class="form-control"name="msg" placeholder="Where leave would be taken"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="button" class="btn btn-default" data-dismiss="modal" value="Close"/>
                        <button type="submit" class="btn btn-primary" name="send">Send</button>
                    </div>
                </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
</div>
<!-- / Delete Confirmation modal -->
<div id="push"></div>
<!-- JavaScript libs are placed at the end of the document so the pages load faster -->
<script src="../assets/js/smoothscroll.js"></script>
<script src="../dist/js/bootstrap.min.js"></script>
<script src="../includes/footer.js"></script>
</body>
</html>