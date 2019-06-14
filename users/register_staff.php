<?php
include '../includes/conn.php'	;
$title = 'KASU HRMS Register Staff';
include  'header.php';
$usertype = $_SESSION['usertype'];
/*if($usertype!='management'){
    session_destroy();
    header('location: ../404.html');
}*/
?>	<div class="">
        <form action="register_staff.php" class="form-mid" style=" max-width: 350px;padding-top: 60px;padding-bottom: 180px;margin: 0 auto;" method = "post">
            <?php
        // Checking for error message
        if(isset($_SESSION['result'])) {
            echo "<div class='alert alert-success' style='color: green; font-size: 20px;'>";
            print $_SESSION['result'];
            unset($_SESSION['result']);
            echo "</div>";
        }?>
            <fieldset><legend class="text-center" > Register User</legend>
                <div class="form-group">
                    <label for="exampleInputEmail1">User Level</label>
                    <select name="usergroup" class="form-control" id="select">
                        <option value="JS">Junior Staff</option>
                        <option value="SS">Senior Staff</option>
                    </select>
                </div>

                <div class="form-group">
                <label for="exampleInputEmail1">Surname</label>
                    <input type="text" name="surname"  class="form-control" size="30" required/>
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">Other Names</label>
                    <input type="text" name="onames" class="form-control" required/>
            </div>
            <input type="submit" name="register"
                   value="Register" class="btn btn-success pull-right"/>
            </fieldset>
        </form>
    </div>
</div>
	</div>
	<!-- JavaScript libs are placed at the end of the document so the pages load faster -->
	<script src="../assets/js/smoothscroll.js"></script>
    <script src="../dist/js/bootstrap.min.js"></script>
	<script src="../includes/footer.js"></script>
</body>
</html>
<?php
if(isset($_POST['register'])){
   $group = $_POST['usergroup'];
    $onames = $_POST['onames'];
    $surname = $_POST['surname'];
    $idquery= mysqli_query($con,"SELECT * FROM users WHERE staffID LIKE '$group%' ORDER BY staffID DESC LIMIT 1");
   $row=mysqli_fetch_assoc($idquery);
    $lastID=substr($row['staffID'],2);
    $nextID = $lastID+1;
    echo $nextID=$group.$nextID;
    function generateRandomString($length)
    {
        $characters = array('0','1','2','3','4','5','7','8','9','A','B','C','D','E','F','H','J','K','M','N','P','Q','R','S','T','W','X','Y','Z');
        $string = '';
        for( $p = 0; $p < $length; $p++)
        {
            $string .= $characters[mt_rand(0, count($characters)-1)];
        }
        return $string;
    }
    $password = generateRandomString(7);
    $createuserquery=mysqli_query($con,"INSERT INTO users(staffID,password) VALUES('$nextID','$password')");
    $createpersonalquery= mysqli_query($con,"INSERT INTO personalinfo(staffID,surname,othernames,lastProm) VALUES('$nextID','$surname','$onames',CURDATE())");
    if(mysqli_affected_rows($con)>0){
        $_SESSION['result']="Account successfully created</br>Staff ID = $nextID Password = $password";
        header('location:register_staff.php');
    }else{
        $_SESSION['result']="Unable to create account due to".mysqli_error($con);
        header('location:register_staff.php');
    }

}
?>