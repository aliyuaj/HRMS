<?php
/**
 * Created by PhpStorm.
 * User: HP USER
 * Date: 2/19/2017
 * Time: 2:42 PM
 */
include '../includes/conn.php'	;
$title = 'KASU HRMS Unit Promotion List';
include  'header.php';
?>
<script>
    $(document).ready(function(){
        $('#note').on('show.bs.modal',function(e){
            var did=$(e.relatedTarget).data('sid');
            $(e.currentTarget).find('input[name="delId"]').val(did);
        });
         });

</script>

<div>
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
    $per_page=15;

    $pages_query=mysqli_num_rows(mysqli_query($con,"SELECT * FROM promotion
  JOIN personalinfo ON promotion.empid=personalinfo.staffID
  JOIN tblunit on tblunit.unitid=personalinfo.unit where status !='approved'"));
    $pages=ceil($pages_query/$per_page);
    $page=(isset($_GET['page']))? (int)$_GET['page']:1;
    if($page==0){
        header ('location:404.php');
    }
    $start=($page-1)*$per_page;
    $query5=mysqli_query($con,"SELECT * FROM promotion
  JOIN personalinfo ON promotion.empid=personalinfo.staffID
  JOIN tblunit on tblunit.unitid=personalinfo.unit where status !='approved' ORDER BY promdate DESC LIMIT $start,$per_page");
    $count=mysqli_num_rows($query5);
    echo mysqli_error($con);
    if($pages_query>0){
        echo	"<div style='font-family:Palatino Linotype;font-size:30px;color:green;'algn='left' class='lead'>Recommended Promotion List: $pages_query</div>";
        echo "<div class='table-responsive text-center'>";
        echo "<table  class='table table-condensed table-bordered' style='min-width:50%'>
			<tr><thead>
			<td><b>S/No.</b></td><td ><b>Name</b></td><td ><b>Date Recommended</b></td><td ><b>Comment</b></td>
		<td><b>Status</b></td><td>Processed By </td><td>Action </td>";
        echo "</tr></thead> ";
        $i=($per_page*($page-1))+1;
        while($result=mysqli_fetch_assoc($query5)){
            echo "<tr><td align='center'>".$i."</td><td >".$result['surname']." ".$result['othernames']."</td>
            <td>".$result['promdate']."</td><td >".$result['comment']."</td><td>".$result['status'].'</td>';
            echo '<td>';
            if($result['status']!='pending'){
                echo $result['unitHeadTitle'].", ".$result['unitname'];
            }
            echo '</td>
            <td>';
            if($result['status']!='approved') {
                echo '<a class="btn btn-success" data-toggle="modal" data-sid="' . $result["promid"] . '"href="#note"><i class="glyphicon glyphicon-transfer"></i> Approve</a>';
            }
            echo
            '</td>
            </tr>';
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
    }else echo "<h2 class='text-center text-danger'>No Staff pending for promotion approval</b></h2>";?>
</div>
</div>
</div>
<!-- / Delete Confirmation modal -->
<div class="modal fade" id="note" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Confirmation</h4>
            </div>
            <div class="modal-body">
                <form method="POST" action="promotion_list.php">
                    <input type="hidden" name="delId">
                    <h3>Are you sure you want to approve promotion ?</h3>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                <button type="submit" class="btn btn-danger" name="approve">Yes</button>
            </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div id="push"></div>
<!-- JavaScript libs are placed at the end of the document so the pages load faster -->
<script src="../assets/js/smoothscroll.js"></script>
<script src="../dist/js/bootstrap.min.js"></script>
<script src="../includes/footer.js"></script>
</body>
</html>
<?php
if(isset($_POST['approve'])){
      $pid= $_POST['delId'];

    $update = mysqli_query($con,"UPDATE promotion SET status='approved' WHERE promid='$pid'");
  if($update){
      $_SESSION['doc']="<h3 style='color:green;'>Promotion approved successful</h3>";
  }else{
      $_SESSION['doc']="<h3 style='color:green;'>Unable to aapprove</h3>";
  }
    header('location:promotion_list.php');
}
?>