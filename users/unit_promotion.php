<?php
/**
 * Created by PhpStorm.
 * User: HP USER
 * Date: 2/19/2017
 * Time: 10:20 AM
 */
include '../includes/conn.php'	;
$title = 'KASU HRMS Promotion';
include  'header.php';
?>
<div>
    <?php
    //check for contract expiry,leave due,retirement and alert.
    $sqlstr=mysqli_query($con,"select * from hrsettings order by id desc");
    $row=mysqli_fetch_assoc($sqlstr);
    $staffID=$_SESSION['pnum'];
    $role=$_SESSION['role'];
    $per_page=15;
    $headQuery = mysqli_query($con,"SELECT * FROM personalinfo WHERE staffID='$staffID'");
    $row=mysqli_fetch_assoc($headQuery);
    $unit = $row['unit'];
    $per_page=15;
    $pages_query=mysqli_num_rows($sqlstr);
    $pages=ceil($pages_query/$per_page);
    $page=(isset($_GET['page']))? (int)$_GET['page']:1;
    if($page==0){
        header ('location:404.php');
    }
    $start=($page-1)*$per_page;
    $query5=mysqli_query($con,"select birthdate,firstappt,gender,personalinfo.staffID,rankname,ranktype,surname,lastProm,othernames,tblunit.unitname,
      (datediff(now(),lastProm) div 365) as lastPromotion
		   from personalinfo JOIN users on users.staffID = personalinfo.staffID
    join tblunit on tblunit.unitid=personalinfo.unit
    join ranks on ranks.rankID=personalinfo.rank
    where (datediff(now(),lastProm) div 365) >= 3
        and suspended='0' and empstat='1'and personalinfo.unit='$unit'  && unitRole!='head'");
    $count=mysqli_num_rows($query5);
    echo mysqli_error($con);
    if($count>0){
        echo	"<div style='font-family:Palatino Linotype;font-size:30px;color:green;'algn='left' class='lead'>Due for Promotion : $pages_query</div>";
        echo "<div class='table-responsive text-center'>";
        echo "<table  class='table table-condensed table-bordered' style='min-width:50%'>
			<tr><thead>
			<td><b>S/No.</b></td><td ><b>Staff ID</b></td><td ><b>Name</b></td><td><b> Sex</b></td><td><b> Unit</b></td>
			<td><b> Cadre</b></td><td><b> Rank</b></td><td><b>Last Promotion Date</b></td><td><b> Last Promotion (Years)</b></td><td><b></b></td>";
        echo "</tr></thead> ";
        $i=($per_page*($page-1))+1;
        while($result=mysqli_fetch_assoc($query5)){
            $sid = $result['staffID'];
            $surname = $result['surname'];
            $othernames = $result['othernames'];
            $name = $surname." ".$othernames;
            $rank = $result['rankname'];
            $cadre = $result['ranktype'];
            $createdfa = date_create($result['lastProm']);
            $fappt = date_format($createdfa, 'jS F, Y');
            echo "<tr><td align='center'>".$i."</td><td align='justify'>".$result['staffID']."</td>
            <td align='justify'>".$name."</td><td align='justify'>".$result['gender']."</td>
            <td aign='justify'>".$result['unitname']."</td><td aign='justify'>".$cadre."</td><td aign='justify'>".$rank."</td><td aign='justify'>".$fappt."</td>
                <td aign='justify'>".$result['lastPromotion']."</td><td>".'
            <a class="btn btn-success" data-toggle="modal" data-sid="'.$result["staffID"].'"href="#approve"><i class="glyphicon glyphicon-transfer"></i> Action</a>


            </td>';
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
    }else echo "<h2 class='text-danger text-center'>No one is due for promotion in your Unit</h2>";?>
</div>
</div>
<script>
    $(document).ready(function(){
        $('#approve').on('show.bs.modal',function(e){
            var did=$(e.relatedTarget).data('sid');
            $(e.currentTarget).find('input[name="ssid"]').val(did);
        });
    });


</script>
<!-- Add Document Modal -->
<div class="modal fade" id="approve" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h3 class="modal-title">Approve/Deny Promotion</h3>
            </div>
            <div class="modal-body">
                <form method="POST" action="promotion_approval.php" class="form-horizontal" role="form" >
                    <input type="text"name="ssid" id="ssid" style="display: none">
                    <div class="form-group">
                        <label for="inputEmail1" class="col-lg-2 control-label">Select</label>
                        <div class="col-lg-10">
                            <select name="select" class="form-control">
                                <option value='recommended' >Recommend</option>
                                <option value='denied' >Deny</option>
                            </select>
                        </div>
                    </div>
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

</div>
<div id="push"></div>
<!-- JavaScript libs are placed at the end of the document so the pages load faster -->
<script src="../assets/js/smoothscroll.js"></script>
<script src="../dist/js/bootstrap.min.js"></script>
<script src="../includes/footer.js"></script>
</body>
</html>