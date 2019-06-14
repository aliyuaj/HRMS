<?php
/**
 * Created by PhpStorm.
 * User: HP USER
 * Date: 2/19/2017
 * Time: 2:01 PM
 */
include '../includes/conn.php'	;
$title = 'KASU HRMS Staff List';
include  'header.php';
?>
<script>
    $(document).ready(function(){
        $('#approve').on('show.bs.modal',function(e){
            var did=$(e.relatedTarget).data('sid');
            $(e.currentTarget).find('input[name="ssid"]').val(did);
        });
    });


</script>
<div class="row">
    <div class="col-md-6"> <span class="lead" style="text-decoration: CaptionText">Unit Staff List</span></div>
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
    $staffID=$_SESSION['pnum'];
    $role=$_SESSION['role'];
    $headQuery = mysqli_query($con,"SELECT * FROM personalinfo WHERE staffID='$staffID'");
    $row=mysqli_fetch_assoc($headQuery);
    $unit = $row['unit'];
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
                        LEFT join tblunit on tblunit.unitid=personalinfo.unit where personalinfo.staffID like '%".$_POST["searchval"]."%'
                        and personalinfo.unit='$unit'  && unitRole!='head'";
                break;
            case "surname":
                $sqlstr="select * from personalinfo
                        LEFT join tblcountries on tblcountries.countryid=personalinfo.nationality
                        LEFT join tblstate on tblstate.stateid=personalinfo.state
                        LEFT join tbllga on tbllga.lgaid=personalinfo.lga
                        LEFT JOIN users on users.staffID=personalinfo.staffID
                        LEFT join ranks on ranks.rankID=personalinfo.rank
                        LEFT join tblunit on tblunit.unitid=personalinfo.unit where surname like '%".$_POST["searchval"]."%'
                        and personalinfo.unit='$unit'  && unitRole!='head'";
                break;
            case "othernames":
                $sqlstr="select * from personalinfo
                        LEFT join tblcountries on tblcountries.countryid=personalinfo.nationality
                        LEFT join tblstate on tblstate.stateid=personalinfo.state
                        LEFT join tbllga on tbllga.lgaid=personalinfo.lga
                        LEFT JOIN users on users.staffID=personalinfo.staffID
                        LEFT join ranks on ranks.rankID=personalinfo.rank
                        LEFT join tblunit on tblunit.unitid=personalinfo.unit where othernames like '%".$_POST["searchval"]."%'
                        and personalinfo.unit='$unit'  && unitRole!='head'";
                break;
            case "unitname":
                $sqlstr="select * from personalinfo
                        LEFT join tblcountries on tblcountries.countryid=personalinfo.nationality
                        LEFT join tblstate on tblstate.stateid=personalinfo.state
                        LEFT join tbllga on tbllga.lgaid=personalinfo.lga
                        LEFT JOIN users on users.staffID=personalinfo.staffID
                        LEFT join ranks on ranks.rankID=personalinfo.rank
                        LEFT join tblunit on tblunit.unitid=personalinfo.unit where unitname like '%".$_POST["searchval"]."%'
                        and personalinfo.unit='$unit'  && unitRole!='head'";
                break;
            case "rank":
                $sqlstr="select * from personalinfo
                        LEFT join tblcountries on tblcountries.countryid=personalinfo.nationality
                        LEFT join tblstate on tblstate.stateid=personalinfo.state
                        LEFT join tbllga on tbllga.lgaid=personalinfo.lga
                        LEFT join ranks on ranks.rankID=personalinfo.rank
                        LEFT JOIN users on users.staffID=personalinfo.staffID
                        LEFT join tblunit on tblunit.unitid=personalinfo.unit where rankname like '%".$_POST["searchval"]."%'
                        and personalinfo.unit='$unit'  && unitRole!='head'";
                break;
        }
    }else
        $sqlstr="select * from personalinfo
                    LEFT join tblcountries on tblcountries.countryid=personalinfo.nationality
                    LEFT join tblstate on tblstate.stateid=personalinfo.state
                    LEFT join tbllga on tbllga.lgaid=personalinfo.lga
                    LEFT JOIN users on users.staffID=personalinfo.staffID
                    LEFT join ranks on ranks.rankID=personalinfo.rank
                    LEFT join tblunit on tblunit.unitid=personalinfo.unit WHERE personalinfo.unit='$unit'  && unitRole!='head'";

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
            echo '<td>        <a class="btn btn-success" data-toggle="modal" data-sid="'.$row["staffID"].'"href="#approve"><i class="glyphicon glyphicon-hand-up"></i> Recommend</a>
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
</div><div class="modal fade" id="approve" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h3 class="modal-title">Recommend for Promotion</h3>
            </div>
            <div class="modal-body">
                <form method="POST" action="recommend_promotion.php" class="form-horizontal" role="form" >
                    <input type="text"name="ssid" id="ssid" style="display: none">
                    <div class="form-group">
                        <label for="inputEmail1" class="col-lg-2 control-label">Additional comment</label>
                        <div class="col-lg-10">
                            <textarea class="form-control "  name="comment"placeholder="" >


                            </textarea>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
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
<?php
if(isset($_POST['send'])){
    $type = 'recommended';
    $comment = $_POST['comment'];
    $sid = $_POST['ssid'];
    $staffID = $_SESSION['pnum'];
    $insert = mysqli_query($con,"INSERT INTO promotion (empid,promdate,approvedBy,status,comment)
                VALUES('$sid',CURDATE(),'$staffID','$type','$comment')");
    if($insert){
        $_SESSION['doc']="<h3 style='color:green;'>Promotion recommendation successful</h3>";

    }else{
        $_SESSION['doc']="<h3 style='color:green;'>Unable to recommend promotion</h3>";
    }
    header('location:recommend_promotion.php');
}
?>