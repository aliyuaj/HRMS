<?php
/**
 * Created by PhpStorm.
 * User: HP USER
 * Date: 12/9/2016
 * Time: 11:28 PM
 */
include '../includes/conn.php'	;
$title = 'KASU HRMS Leave';
include  'header.php';
?>
<div>
    <div>
        <a class='btn btn-success pull-right' data-toggle='modal' href='#applyLeave'><span class='glyphicon glyphicon-plus'></span> Apply Leave</a>
    </div>
    <?php
    if(isset($_SESSION['del'])){
        echo '<div  style="color:green;font-weight:bold;font-size:30px;">';
        print $_SESSION['del']; unset($_SESSION['del']);
        echo '</div>';
    }
    if(isset($_SESSION['doc'])){
        echo '<div style="color:green;font-weight:bold;font-size:30px;">';
        print $_SESSION['doc']; unset($_SESSION['doc']);
        echo '</div>';
    }

    $staffID=$_SESSION['pnum'];
    $per_page=15;
    $pages_query=mysqli_num_rows(mysqli_query($con,"SELECT * FROM leaveapplic JOIN leavetypes ON leaveapplic.leavetype=leavetypes.id  WHERE applicantID='$staffID'"));
    $pages=ceil($pages_query/$per_page);
    $page=(isset($_GET['page']))? (int)$_GET['page']:1;
    if($page==0){
        header ('location:404.php');
    }
    $start=($page-1)*$per_page;
    $query5=mysqli_query($con,"SELECT * from leaveapplic JOIN leavetypes ON leaveapplic.leavetype=leavetypes.id WHERE applicantID='$staffID' ORDER BY dateapplied DESC LIMIT $start,$per_page");
    $count=mysqli_num_rows($query5);
    if($pages_query>0){
        echo	"<div style='font-family:Palatino Linotype;font-size:30px;color:green;'algn='left' class='lead'>Leave History : $pages_query</div>";
        echo "<div class='table-responsive text-center'>";
        echo "<table  class='table table-condensed table-bordered' style='min-width:50%'>
			<tr><thead>
			<td><b>S/No.</b></td><td ><b>Date Applied</b></td><td ><b>Leave Type</b></td><td ><b>No. of Days</b></td><td><b>Starting Date</b></td>
			<td><b>Ending Date</b></td><td><b>Leave Address</b></td><td><b>Status</b></td>";
        echo "</tr></thead> ";
        $i=($per_page*($page-1))+1;
        while($result=mysqli_fetch_assoc($query5)){
            echo "<tr><td align='center'>".$i."</td><td >".$result['dateapplied']."</td><td >".$result['leavetype']."</td><td>".$result['numdays']."</td>
            <td>".$result['datefrom']."</td><td >".$result['dateto']."</td><td >".$result['leaveaddress']."</td><td>".$result['status']."</td></tr>";
            $i++;
        }
        echo "</table></div>";
        if($pages>1 && $page<=$pages){
            echo '<ul class="pagination">';
            if($page>1){
                echo'<li><a href="?id='.$s.'&page=1"> <span class="glyphicon glyphicon-backward"></a></li>';
            }
            if($page>1){
                $prev_page=$page-1;
                echo'<li><a href="?id='.$s.'&page='.$prev_page.'"> <span class="glyphicon glyphicon-step-backward"></a></li>';
            }
            echo "<li class='active'><a>$page of $pages</a></li>";
            if($page<$pages){
                $next_page=$page+1;
                echo'<li><a href="?id='.$s.'&page='.$next_page.'"> <span class="glyphicon glyphicon-step-forward"></a></li>';
            }if($page<$pages){
                $next_page=$page+1;
                echo'<li><a href="?id='.$s.'&page='.$pages.'"> <span class="glyphicon glyphicon-forward"></a></li>';
            }
            echo '</ul>';
        }  elseif($page>$pages) {
            header ('location:404.php');
        }
    }else echo "<h2 class='text-center text-danger'>You are yet to apply for leave</b></h2>";?>
</div>
</div>
<script>
    $(document).ready(function(){
        $('#delete').on('show.bs.modal',function(e){
            var did=$(e.relatedTarget).data('del');
            $(e.currentTarget).find('input[name="delId"]').val(did);
        });
        $("#leavetype").change(function(){
                var type=document.getElementById('leavetype').value
                if(type=='2'){
                    $('#lfile').show();
                }else{
                    $('#lfile').hide();
                }
            }
        );
        $('#datetimepicker2').datetimepicker({
            lang:'en',
            timepicker:false,
            format:'m/d/Y',
            formatDate:'Y/m/d',
            minDate:'-1970/01/01', // yesterday is minimum date
            maxDate:'+1970/03/02' // and tommorow is maximum date calendar
        });

    });

</script>
<!-- Add Document Modal -->
<div class="modal fade" id="applyLeave" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h3 class="modal-title">Apply Leave</h3>
            </div>
            <div class="modal-body">
                <form method="POST" action="apply_leave.php" enctype="multipart/form-data" class="form-horizontal" role="form" >
                    <div class="form-group">
                        <label for="inputEmail1" class="col-lg-2 control-label">Leave Type</label>
                        <div class="col-lg-10">
                            <select name="leavetype" id="leavetype" class="form-control">
                                <?php $leavequery= mysqli_query($con,"SELECT * FROM leavetypes ORDER BY id DESC");
                                    while($row=mysqli_fetch_assoc($leavequery)){
                                        $leavetype=$row['leavetype'];
                                        $leaveID=$row['id'];
                                        echo "<option value=$leaveID >$leavetype</option>";
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group" style="display: none" id="lfile">
                        <label for="inputTitle" class="col-lg-2 control-label"  >	Attach Medical Report</label>
                        <div class="col-lg-10">
                            <input type="file" class="form-control " id="inputEmail1"  name="file" placeholder="Insert document" >
                        </div>
                    </div>
                    <div class="form-group" id="date">
                        <label for="inputEmail1" class="col-lg-2 control-label">Starting From</label>
                        <div class="col-lg-10">
                            <input type="text" class="form-control" id="datetimepicker2" name="commence" class="span12" placeholder="Date to commence leave is Required" required/>
                        </div>
                    </div>
                    <div class="form-group" id="date">
                        <label for="inputEmail1" class="col-lg-2 control-label">Leave Address </label>
                        <div class="col-lg-10">
                            <input type="text" class="form-control"name="leaveaddress" placeholder="Where leave would be taken" required/>
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
<!-- / Delete Confirmation modal -->
<div class="modal fade" id="delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Confirmation</h4>
            </div>
            <div class="modal-body">
                <form method="POST" action="delete_request.php">
                    <input type="hidden" name="delId">
                    <h3>Are you sure you want to delete the message ?</h3>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                <button type="submit" class="btn btn-danger">Yes</button>
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