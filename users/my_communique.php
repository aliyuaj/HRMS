<?php
/**
 * Created by PhpStorm.
 * User: HP USER
 * Date: 12/12/2016
 * Time: 11:20 PM
 */

include '../includes/conn.php'	;
$title = 'KASU HRMS My Communique';
include  'header.php';
?>
<div>
    <?php
    if(isset($_SESSION['delete'])){
        echo '<div  class="text-success">';
        print $_SESSION['delete']; unset($_SESSION['delete']);
        echo '</div>';
    }
    if(isset($_SESSION['doc'])){
        echo '<div  class="text-success">';
        print $_SESSION['doc']; unset($_SESSION['doc']);
        echo '</div>';
    }
    $staffID=$_SESSION['pnum'];
    $per_page=15;
    $pages_query=mysqli_num_rows(mysqli_query($con,"SELECT * FROM communique WHERE recID='$staffID'"));
    $pages=ceil($pages_query/$per_page);
    $page=(isset($_GET['page']))? (int)$_GET['page']:1;
    if($page==0){
        header ('location:404.php');
    }
    $start=($page-1)*$per_page;
    $query5=mysqli_query($con,"SELECT * from communique WHERE recID='$staffID' LIMIT $start,$per_page");
    $count=mysqli_num_rows($query5);
    if($pages_query>0){
        echo	"<div style='font-family:Palatino Linotype;font-size:30px;color:green;'algn='left' class='lead'>Communiques : $pages_query</div>";
        echo "<div class='table-responsive text-center'>";
        echo "<table  class='table table-condensed table-bordered' style='min-width:50%'>
			<tr><thead>
			<td><b>S/No.</b></td><td ><b>Subject</b></td><td ><b>Content</b></td><td><b> Date Posted</b></td><td><b>Action</b></td>";
        echo "</tr></thead> ";
        $i=($per_page*($page-1))+1;
        while($result=mysqli_fetch_assoc($query5)){
            $created = date_create($result['timecreated']);
            $created = date_format($created, 'jS F, Y | h:i:s a');
            echo "<tr><td align='center'>".$i."</td><td align='justify'>".$result['subject']."</td><td align='justify'>".$result['content']."</td><td aign='justify'>".$created."</td>";
            if(!empty($result['filename'])){
            echo '<td>
                   <a class="btn btn-default" href="comm_download.php?file_name='.$result["filename"].'" ><i class="glyphicon glyphicon-download-alt"></i> Download</a></li>
				</td>';
				}
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
    }else echo "<h2 class='text-danger text-center'>You have not uploaded any document</h2>";?>
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
<div class="modal fade" id="delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Confirm Delete</h4>
            </div>
            <div class="modal-body">
                <form method="POST" action="delete_document.php">
                    <input type="hidden" name="delId">
                    <h3>Are you sure you want to delete the document ?</h3>
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