<?php
/**
 * Created by PhpStorm.
 * User: HP USER
 * Date: 12/20/2016
 * Time: 1:38 PM
 */
include '../includes/conn.php'	;
$title = 'KASU HRMS Unit Leave Applications';
include  'header.php';
?>
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

    $pages_query=mysqli_num_rows(mysqli_query($con,"SELECT * FROM leaveapplic JOIN leavetypes ON leaveapplic.leavetype=leavetypes.id
  JOIN personalinfo ON leaveapplic.applicantID=personalinfo.staffID
  JOIN tblunit on tblunit.unitid=personalinfo.unit"));
    $pages=ceil($pages_query/$per_page);
    $page=(isset($_GET['page']))? (int)$_GET['page']:1;
    if($page==0){
        header ('location:404.php');
    }
    $start=($page-1)*$per_page;
    $query5=mysqli_query($con,"SELECT * FROM leaveapplic JOIN leavetypes ON leaveapplic.leavetype=leavetypes.id
  JOIN personalinfo ON leaveapplic.applicantID=personalinfo.staffID
  JOIN tblunit on tblunit.unitid=personalinfo.unit ORDER BY dateapplied DESC LIMIT $start,$per_page");
    $count=mysqli_num_rows($query5);
    if($pages_query>0){
        echo	"<div style='font-family:Palatino Linotype;font-size:30px;color:green;'algn='left' class='lead'>Leave Applications: $pages_query</div>";
        echo "<div class='table-responsive text-center'>";
        echo "<table  class='table table-condensed table-bordered' style='min-width:50%'>
			<tr><thead>
			<td><b>S/No.</b></td><td ><b>Name</b></td><td ><b>Date Applied</b></td><td ><b>Leave Type</b></td><td ><b>No. of Days</b></td><td><b>Starting Date</b></td>
			<td><b>Ending Date</b></td><td><b>Leave Address</b></td><td><b>Status</b></td><td><b>File</b></td><td>Processed By </td>";
        echo "</tr></thead> ";
        $i=($per_page*($page-1))+1;
        while($result=mysqli_fetch_assoc($query5)){
            echo "<tr><td align='center'>".$i."</td><td >".$result['surname']." ".$result['othernames']."</td><td >".$result['dateapplied']."</td><td >".$result['leavetype']."</td><td>".$result['numdays']."</td>
            <td>".$result['datefrom']."</td><td >".$result['dateto']."</td><td >".$result['leaveaddress']."</td><td>".$result['status'].'</td>
            <td>';
            if($result['file']!="") {
                echo '<a href = "download.php?file_name='.$result["file"].'">Download Attachment </a >';
            }else echo "No file attached";
            echo '</td>';
            echo '<td>';
            if($result['status']!='pending'){
                echo $result['unitHeadTitle'].", ".$result['unitname'];
            }
            echo '</td></tr>';
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
    }else echo "<h2 class='text-center text-danger'>No leave applied by Unit Staff</b></h2>";?>
</div>
</div>
</div>
<div id="push"></div>
<!-- JavaScript libs are placed at the end of the document so the pages load faster -->
<script src="../assets/js/smoothscroll.js"></script>
<script src="../dist/js/bootstrap.min.js"></script>
<script src="../includes/footer.js"></script>
</body>
</html>