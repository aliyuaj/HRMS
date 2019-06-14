<?php
/**
 * Created by PhpStorm.
 * User: HP USER
 * Date: 12/13/2016
 * Time: 6:05 PM
 */
include '../includes/conn.php'	;
$title = 'KASU HRMS Updates';
include  'header.php';
?>
<div>
    <div>
        <a class='btn btn-success pull-right' data-toggle='modal' href='#addUpdate'><span class='glyphicon glyphicon-plus'></span> Add Update</a>
    </div>
    <?php
    if(isset($_SESSION['del'])){
        print $_SESSION['del']; unset($_SESSION['del']);
    }
    if(isset($_SESSION['update'])){
        print $_SESSION['update']; unset($_SESSION['update']);
    }

    $staffID=$_SESSION['pnum'];
    $per_page=15;
    $pages_query=mysqli_num_rows(mysqli_query($con,"SELECT * FROM updates"));
    $pages=ceil($pages_query/$per_page);
    $page=(isset($_GET['page']))? (int)$_GET['page']:1;
    if($page==0){
        header ('location:404.php');
    }
    $start=($page-1)*$per_page;
    $query5=mysqli_query($con,"SELECT * from updates ORDER BY date DESC LIMIT $start,$per_page");
    $count=mysqli_num_rows($query5);
    if($pages_query>0){
        echo	"<div style='font-family:Palatino Linotype;font-size:30px;color:green;'algn='left' class='lead'>Total Updates : $pages_query</div>";
        echo "<div class='table-responsive text-center'>";
        echo "<table  class='table table-condensed table-bordered' style='min-width:50%'>
			<tr><thead>
			<td><b>S/No.</b></td><td ><b>Title</b></td><td ><b>Content</b></td><td ><b>Poster</b></td><td><b>Date Posted</b></td><td><b>Action</b></td>";
        echo "</tr></thead> ";
        $i=($per_page*($page-1))+1;
        while($result=mysqli_fetch_assoc($query5)){
            echo "<tr><td align='center'>".$i."</td><td >".$result['title']."</td><td align='justify'>".$result['content']."</td><td>".$result['author']."</td>
            <td>".$result['date'].'</td><td>
					<div class="btn-group ">
						  <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown">Action <span class="caret"></span>
					</button>
					<ul class="dropdown-menu" role="menu">
						<li><a href="#editUpdate" data-toggle="modal" data-id="'.$result["newsID"].'"
						data-title="'.$result["title"].'"data-content="'.$result["content"].'" data-author="'.$result["author"].'"><span class="glyphicon glyphicon-pencil"></span> Edit Details</a></li>
            <li><a href="#delete" data-toggle="modal" data-del="'.$result["newsID"].'"><span class="glyphicon glyphicon-trash"></span> Remove </a></li>
                </ul></div>
                </td>
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
    }else echo "<h2 class='text-center text-danger'>You are yet to apply for leave</b></h2>";?>
</div>
</div>
<script>
    $(document).ready(function(){
        $('#delete').on('show.bs.modal',function(e){
            var did=$(e.relatedTarget).data('del');
            $(e.currentTarget).find('input[name="delId"]').val(did);
        });
        $('#editUpdate').on('show.bs.modal',function(e){
            var uid = $(e.relatedTarget).data('id');
            $(e.currentTarget).find('input[name="id"]').val(uid);
            var updateTitle = $(e.relatedTarget).data('title');
            $(e.currentTarget).find('input[name="title"]').val(updateTitle);
            var msg = $(e.relatedTarget).data('content');
            $(e.currentTarget).find('#content').val(msg);
            var poster = $(e.relatedTarget).data('author');
            $(e.currentTarget).find('input[name="author"]').val(poster);
        });
    });

</script>
<!-- Add update Modal -->
<div class="modal fade" id="addUpdate" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h3 class="modal-title">Add to General Updates</h3>
            </div>
            <div class="modal-body">
                <form method="POST" action="add_update.php" class="form-horizontal" role="form" >
                    <div class="form-group">
                        <label for="inputEmail1" class="col-lg-2 control-label">Title</label>
                        <div class="col-lg-10">
                            <input type="text" class="form-control"  name="addtitle" class="span12" placeholder="Title is required" required/>    </div>
                    </div>
                    <div class="form-group" id="content">
                        <label for="inputTitle" class="col-lg-2 control-label"  > Content</label>
                        <div class="col-lg-10">
                           <textarea class="form-control" name="addcontent" placeholder="Enter Content"></textarea>
                        </div>
                    </div>
                    <div class="form-group" id="author">
                        <label for="inputEmail1" class="col-lg-2 control-label">Author</label>
                        <div class="col-lg-10">
                            <input type="text" class="form-control"  name="addauthor" class="span12" placeholder="Author is required" required/>
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

<!-- Edit Video Modal -->
<div class="modal fade" id="editUpdate" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h3 class="modal-title">Edit Update</h3>
            </div>
            <div class="modal-body">
                <form method="POST" action="edit_update.php" class="form-horizontal" role="form" >
                    <div class="form-group">
                        <label for="inputEmail1" class="col-lg-2 control-label">Title</label>
                        <div class="col-lg-10">
                            <input type="text" class="form-control"  name="id" style="display: none"/>
                            <input type="text" class="form-control"  name="title" class="span12" placeholder="Title is required" required/>    </div>
                    </div>
                    <div class="form-group" >
                        <label for="inputTitle" class="col-lg-2 control-label"  > Content</label>
                        <div class="col-lg-10">
                            <textarea cols="20" rows="6" class="form-control" id="content" name="content"></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail1" class="col-lg-2 control-label">Author</label>
                        <div class="col-lg-10">
                            <input type="text" class="form-control"  id="author" name="author" placeholder="" required/>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="button" class="btn btn-default" data-dismiss="modal" value="Close"/>
                        <button type="submit" class="btn btn-primary" name="edit">Save Changes</button>
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
                <form method="POST" action="delete_update.php">
                    <input type="hidden" name="delId">
                    <h3>Are you sure you want to delete this update ?</h3>
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
