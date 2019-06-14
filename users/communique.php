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

echo '<span class="lead" style="text-decoration: CaptionText">KASU Staff Communique</span>';
if(isset($_SESSION['doc'])){
echo '<div  class="text-success pull-right">';
    print $_SESSION['doc']; unset($_SESSION['doc']);
    echo '</div>';
}?>
    <div class="col-md-12 row" style="padding:5px 20px 15px 0">
        <form class="form-inline" role="form" action="communique.php" method="post">
            <div class="col-lg-4">
                <select class="form-control" name="cadre">
                    <option value="">Cadre</option>
                    <option value="academic">Academic Staff</option>
                    <option value="non-academic">Non-Academic Staff</option>
                </select>
            </div>
            <div class="col-lg-4">
                <select class="form-control" name="rank">
                    <option value="">Rank</option>
                    <?php $ranks= mysqli_query($con,"SELECT * FROM ranks");
                    while($row=mysqli_fetch_assoc($ranks)){
                        $rankname=$row['rankname'];
                        $rankID=$row['rankID'];
                        echo "<option value=$rankID >$rankname</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="col-lg-4">
                <div class="input-group">
                    <select class="form-control" name="unit">
                        <option value="">Unit</option>
                        <?php $units= mysqli_query($con,"SELECT * FROM tblunit");
                        while($row=mysqli_fetch_assoc($units)){
                            $unitname=$row['unitname'];
                            $unitID=$row['unitid'];
                            echo "<option value=$unitID >$unitname</option>";
                        }
                        ?>
                    </select>
                    <span class="input-group-btn">
                                <button class="btn btn-default" type="submit" name="submit"><span class="glyphicon glyphicon-search"></span></button>
                            </span>
                </div>
            </div>
        </form>
    </div>


<div class="text"align="center">
    <?php
    if (isset($_POST["submit"]))
    {
       $srank = $_POST['rank'];
        $scadre = $_POST['cadre'];
        $sunit = $_POST['unit'];

        if($srank==''){
            $srank=" LIKE '%%'";
        }else{
            $srank="='$srank'";
        }
        if($scadre==''){
            $scadre=" LIKE '%%'";
        }else{
            $scadre="='$scadre'";
        }
        if($sunit==''){
            $sunit=" LIKE '%%'";
        }else{
            $sunit="='$sunit'";
        }
        $sqlstr="SELECT * FROM (select * from(select * from (select * from personalinfo
                    inner join tblcountries on tblcountries.countryid=personalinfo.nationality
                    inner join tbllga on tbllga.lgaid=personalinfo.lga
                    inner join ranks on ranks.rankID=personalinfo.rank
                    inner join tblunit on tblunit.unitid=personalinfo.unit
                    WHERE ranks.ranktype".$scadre.")as cadre WHERE cadre.rankID".$srank.")as rank
                    WHERE rank.unit".$sunit.")as unit";
    }else
        $sqlstr="select * from personalinfo
                    inner join tblcountries on tblcountries.countryid=personalinfo.nationality
                    inner join tblstate on tblstate.stateid=personalinfo.state
                    inner join tbllga on tbllga.lgaid=personalinfo.lga
                    inner join ranks on ranks.rankID=personalinfo.rank
                    inner join tblunit on tblunit.unitid=personalinfo.unit";

    $per_page=15;
    $pages_query=mysqli_num_rows(mysqli_query($con,$sqlstr));
    ECHO mysqli_error($con);
    $pages=ceil($pages_query/$per_page);
    $page=(isset($_GET['page']))? (int)$_GET['page']:1;
    if($page==0){
        header('location:404.php');
    }
    $start=($page-1)*$per_page;
    $squery=mysqli_query($con,"$sqlstr LIMIT $start,$per_page");
    $squery1=mysqli_query($con,"$sqlstr LIMIT $start,$per_page");
    $count=mysqli_num_rows($squery);
    if($pages_query>0){
        $allID="";
    while($row = mysqli_fetch_array($squery)) {
        $pnumber = $row['staffID'];
        $allID = $allID.$pnumber.",";
    }
   echo '<div class="col-md-12 panel panel-default">
            <div class="panel-body">
            Select from above Staff group to send communique. No need to search if it is to be sent to all Staff. Afterwards
            <a href="#communique" class="btn btn-success pull-right" data-toggle="modal" data-ids="'.$allID.'" >
            <i class="glyphicon glyphicon-send"></i> Send Communique</a></div>
    </div>';
        echo "<div class='table-responsive text-center'>
					<table  class='table table-striped table-condensed table-bordered ' >
					<thead><tr>
					<td><b>S/No.</b></td><td><b>User ID</b></td><td><b>Full Name</b></td><td><b>Gender</b></td><td><b>Rank</b></td><td>Cadre</td>
					</tr></thead> ";
        $i=($per_page*($page-1))+1;
        while($row = mysqli_fetch_array($squery1)) {
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
            echo "<tr><td>".$i."</td><td>".$pnumber."</td><td>".$fullname."</td><td>".$gender."</td><td>".$rank."</td><td>".$cadre."</td>
						</tr>";
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
<script>
    $(document).ready(function(){
        $('#communique').on('show.bs.modal',function(e){
            var uid = $(e.relatedTarget).data('ids');
            $(e.currentTarget).find('input[name="ida"]').val(uid);
            var updateTitle = $(e.relatedTarget).data('title');
            $(e.currentTarget).find('input[name="title"]').val(updateTitle);
            var msg = $(e.relatedTarget).data('content');
            $(e.currentTarget).find('#content').val(msg);
            var poster = $(e.relatedTarget).data('author');
            $(e.currentTarget).find('input[name="author"]').val(poster);
        });
    });

</script>
<!-- Add Communique Modal -->
<div class="modal fade" id="communique" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h3 class="modal-title">Create Communique</h3>
            </div>
            <div class="modal-body">
                <form method="POST" action="send_communique.php" enctype="multipart/form-data" class="form-horizontal" role="form" >
                    <div class="form-group">
                        <label for="inputEmail1" class="col-lg-2 control-label">Subject</label>
                        <div class="col-lg-10">
                            <input type="text" class="form-control"  name="ida" style="display: none">
                            <input type="text" class="form-control"  name="subject" class="span12" placeholder="Subject is required" required/>    </div>
                    </div>
                    <div class="form-group" id="content">
                        <label for="inputTitle" class="col-lg-2 control-label"  > Info</label>
                        <div class="col-lg-10">
                            <textarea class="form-control" name="addcontent" placeholder="Enter info to pass"></textarea>
                        </div>
                    </div>
                    <div class="form-group" id="author">
                        <label for="inputEmail1" class="col-lg-2 control-label">Attach File (Optional)</label>
                        <div class="col-lg-10">
                            <input type="file"  name="file" class="span12" placeholder="(Optional)"/>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="button" class="btn btn-default" data-dismiss="modal" value="Close"/>
                        <button type="submit" class="btn btn-primary" name="addLeave">Add</button>
                    </div>
                </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
</div>

<div id="push"></div>
<!-- JavaScript libs are placed at the end of the document so the pages load faster -->
<script src="../assets/js/smoothscroll.js"></script>
<script src="../dist/js/bootstrap.min.js"></script>
<script src="../includes/footer.js"></script>
</body>
</html>