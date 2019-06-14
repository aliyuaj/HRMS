<?php
/**
 * Created by PhpStorm.
 * User: HP USER
 * Date: 12/20/2016
 * Time: 4:32 PM
 */
include '../includes/conn.php'	;
$title = 'KASU HRMS Notifications';
include  'header.php';
?>
<div>
    <?php
    //check for contract expiry,leave due,retirement and alert.
    $sqlstr=mysqli_query($con,"select * from hrsettings order by id desc");
    $row=mysqli_fetch_assoc($sqlstr);

    $contract=$row['contract'];
    $leave=$row['leave'];
    $retirement=$row['retirement'];
    $retage=$row['retage'];

    //retirement
    if (!empty($retirement)) {
        //get retirement age - retirement notification difference
        if (!empty($retage))
            $agediff = $retage - $retirement;
        else
            $agediff = 60 - $retirement;

        //sql count
        $sqlstr = mysqli_query($con, "select birthdate,firstappt,gender,personalinfo.staffID,surname,othernames,tblunit.unitname,(datediff(now(),birthdate) div 365) as age,
		  (datediff(now(),firstappt) div 365) as yearserved
		   from personalinfo JOIN users on users.staffID = personalinfo.staffID
    join tblunit on tblunit.unitid=personalinfo.unit
    where (DATEDIFF(now(),birthdate) / 365) >= $agediff
        and suspended='0' and empstat='1'");
        $row = mysqli_fetch_assoc($sqlstr);
    }
    $staffID=$_SESSION['pnum'];
    $per_page=15;
    $pages_query=mysqli_num_rows($sqlstr);
    $pages=ceil($pages_query/$per_page);
    $page=(isset($_GET['page']))? (int)$_GET['page']:1;
    if($page==0){
        header ('location:404.php');
    }
    $start=($page-1)*$per_page;
    $query5=mysqli_query($con,"select birthdate,firstappt,gender,personalinfo.staffID,surname,othernames,tblunit.unitname,(datediff(now(),birthdate) div 365) as age,
		  (datediff(now(),firstappt) div 365) as yearserved
		   from personalinfo JOIN users on users.staffID = personalinfo.staffID
    join tblunit on tblunit.unitid=personalinfo.unit
    where (DATEDIFF(now(),birthdate) / 365) >= $agediff
        and suspended='0' and empstat='1'");
    $count=mysqli_num_rows($query5);
    echo mysqli_error($con);
    if($pages_query>0){
        echo	"<div style='font-family:Palatino Linotype;font-size:30px;color:green;'algn='left' class='lead'>Soon to Retire : $pages_query</div>";
        echo "<div class='table-responsive text-center'>";
        echo "<table  class='table table-condensed table-bordered' style='min-width:50%'>
			<tr><thead>
			<td><b>S/No.</b></td><td ><b>Staff ID</b></td><td ><b>Name</b></td><td><b> Sex</b></td><td><b> Unit</b></td>
			<td><b> Date of Birth</b></td><td><b>First Appointment</b></td><td><b> Age</b></td><td><b>Years Served</b></td><td><b></b></td>";
        echo "</tr></thead> ";
        $i=($per_page*($page-1))+1;
        while($result=mysqli_fetch_assoc($query5)){
            $surname = $result['surname'];
            $othernames = $result['othernames'];
            $name = $surname." ".$othernames;
            $createbd = date_create($result['birthdate']);
            $birthdate = date_format($createbd, 'jS F, Y ');
            $createdfa = date_create($result['firstappt']);
            $fappt = date_format($createdfa, 'jS F, Y');
            echo "<tr><td align='center'>".$i."</td><td align='justify'>".$result['staffID']."</td>
            <td align='justify'>".$name."</td><td align='justify'>".$result['gender']."</td>
            <td aign='justify'>".$result['unitname']."</td><td aign='justify'>".$birthdate."</td><td aign='justify'>".$fappt."</td>
                <td aign='justify'>".$result['age']."</td><td aign='justify'>".$result['yearserved']."</td><td>".'
                <a href="edit_staff_profile.php?id='.$result['staffID'].'"><i class="glyphicon glyphicon-edit"></i>Profile</a></td>';
            echo '</tr>';
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
    }else echo "<h2 class='text-danger text-center'>You have no message from the HRMS Unit</h2>";?>
</div>
</div>
<script>
    $(document).ready(function(){
        $('#delete').on('show.bs.modal',function(e){
            var did=$(e.relatedTarget).data('del');
            $(e.currentTarget).find('input[name="delId"]').val(did);
        });
        $("#doctype").change(function(){
                var type=document.getElementById('doctype').value
                if(type=='Others'){
                    $('#desc').show();
                }else{
                    $('#desc').hide();
                }
            }
        );
    });


</script>
<!-- Add Document Modal -->
<div class="modal fade" id="addDoc" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h3 class="modal-title">New Document</h3>
            </div>
            <div class="modal-body">
                <form method="POST" action="add_doc.php" enctype="multipart/form-data" class="form-horizontal" role="form" >
                    <div class="form-group">
                        <label for="inputEmail1" class="col-lg-2 control-label">File Type</label>
                        <div class="col-lg-10">
                            <select name="doctype" id="doctype" class="form-control">
                                <option value="Birth Certificate">Birth Certificate</option>
                                <option value="O levels">O Levels</option>
                                <option value="Degree">Degree</option>
                                <option value="NYSC">NYSC</option>
                                <option value="Others">Others</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group" id="desc" style="display: none">
                        <label for="inputEmail1" class="col-lg-2 control-label">Description</label>
                        <div class="col-lg-10">
                            <input type="text" class="form-control " id="inputEmail1"  name="description"placeholder="Enter document desc" >
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputTitle" class="col-lg-2 control-label">	File</label>
                        <div class="col-lg-10">
                            <input type="file" clas="form-control " id="inputEmail1"  name="file" placeholder="Insert document" >
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" name="addDocument">Add</button>
                    </div>
                </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
</div>
<!-- / Delete Confirmation modal -->

</div>
<div id="push"></div>
<!-- JavaScript libs are placed at the end of the document so the pages load faster -->
<script src="../assets/js/smoothscroll.js"></script>
<script src="../dist/js/bootstrap.min.js"></script>
<script src="../includes/footer.js"></script>
</body>
</html>