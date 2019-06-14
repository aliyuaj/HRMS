<?php
/**
 * Created by PhpStorm.
 * User: HP USER
 * Date: 12/12/2016
 * Time: 11:17 PM
 */

include '../includes/conn.php'	;
$title = 'KASU HRMS Edit Staff Profile';
include  'header.php';
?><div class="row">

<div class="col-md-12">
<span class="lead"style='font-family:Palatino Linotype;font-size:30px;color:green;'>Edit Staff Profile </span>

<?php  if(isset($_SESSION['update'])){
    echo '<div  style="color:green;font-weight:bold;font-size:30px;">';
    print $_SESSION['update']; unset($_SESSION['update']);
    echo '</div>';
}?>

<script>
    $(document).ready(function(){
        $('#datetimepicker2').datetimepicker({
            lang:'en',
            timepicker:false,
            format:'Y-m-d',
            formatDate:'Y-m-d',
            minDate:'+1940-01-01', // yesterday is minimum date
            maxDate:'-1970-01-01' // and tommorow is maximum date calendar
        });
        $('#nationality').live("change", function(){
            if($('#nationality').val() != '125'){
                $("#state_row").hide();
                $("#lga_row").hide();
                $("#hometown_row").hide();
            }
            else{
                $("#state_row").show();
                $("#lga_row").show();
                $("#hometown_row").show();

                $(function(){
                    $("#state").change(function(){
                        $.get("local_govt.php", {state_id:$("#state").val()}, function(data){$("#lga").html(data);});
                        return false;
                    });
                });
            }
        });
    });

</script>
<?php
$sid = $_SESSION['pnum'];
$squery=mysqli_query($con,"select * from personalinfo
                        left join tblcountries on tblcountries.countryid=personalinfo.nationality
                        LEFT join tblstate on tblstate.stateid=personalinfo.state
                        LEFT join tbllga on tbllga.lgaid=personalinfo.lga
                        LEFT join ranks on ranks.rankID=personalinfo.rank
                        LEFT JOIN users on users.staffID=personalinfo.staffID
                        LEFT JOIN empstatus on empstatus.statid=personalinfo.empstat
                        LEFT join tblunit on tblunit.unitid=personalinfo.unit WHERE personalinfo.staffID = '$sid'");
if(mysqli_num_rows($squery) > 0) {
    $row = mysqli_fetch_array($squery);

    $surname = $row['surname'];
    $othernames = $row['othernames'];
    $pnumber = $row['staffID'];
    $contactaddress = $row['contactaddress'];
    if($row['birthdate']!="") {
        $birthdate = date_create($row['birthdate']);
        $birthdate = date_format($birthdate, 'jS F, Y');
    }else $birthdate = $row['birthdate'];
    $gender = $row['gender'];
    $passport = $row['passport'];
    $country = $row['countryname'];
    $state = $row['statename'];
    $stateid = $row['stateid'];
    $lga = $row['lganame'];
    $lgaid = $row['lgaid'];
    $bloodgroup = $row['bgroup'];
    $fullname = ucfirst($surname) . " " . ucfirst($othernames);
    $mstatus = $row['mstatus'];
    $hometown = $row['hometown'];
    $gsm = $row['gsm'];
    $firstAppt = date_create($row['firstappt']);
    $firstAppt = date_format($firstAppt, 'jS F, Y');
    $email = $row['email'];
    $title = $row['title'];
    echo '<div align="center"><table class="" style="width:70%">

            <tr><td></td>
            <td align="right">
                <form id="imageform" action="ajaximage.php" method="post" enctype="multipart/form-data">
                    <div clas="pull-right">
                        <div id="preview">
                             <img class="pull-right" src="../images/passport/'.$passport.'" height="150px" alt="mypassport" width="150px">
                        </div><BR/>
                        <input type="input" name ="sid" value="'.$pnumber.'" style="display:none" placeholder="Passport is Required"/>
                        <input type="file" name="photoimg" id="photoimg" class="span12" placeholder="Passport is Required" required/>
                    </div>
                </form>
            </td>
            </tr>
      <tr>
        <td style="background: #0f0;font-weight: bold;border-radius:15px;padding-left:10px">Personal Info</td>
        </tr>
        <form role="form" action="" method="POST" class="form-inline" enctype="multipart/form-data">
            <tr></tr>';
    echo '<tr><td><span class="tl">Staff ID:</span></td>';
    echo '<td colspan="2"><div class="form-group"><input type="text" name="id" class="form-control" value="' . $pnumber . '" readonly></div></td></tr>
        <tr><td><span class="tl">Title:</span></td>';
    echo '<td colspan="2">
    <div class="form-group">
        <select class="form-control" name="title">';
    if($title!=""){
        echo '<option selected="selected">'.$title.'</option>
            <option value="Mr.">Mr.</option>
            <option value="Miss.">Miss</option>
            <option value="Mrs.">Mrs.</option>
            <option value="Dr.">Dr.</option>
            <option value="Prof.">Prof.</option>';
    }else {
        echo '
            <option selected="selected">' . $title . '</option>
            <option value="Mr.">Mr.</option>
            <option value="Miss.">Miss</option>
            <option value="Mrs.">Mrs.</option>
            <option value="Dr.">Dr.</option>
            <option value="Prof.">Prof.</option>';
    }
    echo '</select></div></td></tr>
        <tr><td><span class="tl">Surname:</span></td>';
    echo '<td colspan="2"><div class="form-group"><input type="text" name="surname" class="form-control" value="' . $surname . '" >
        </div></td></tr>';
    echo '<tr><td><span class="tl">Other Names:</span></td>';
    echo '<td colspan="2"><div class="form-group"><input type="text" name="onames" class="form-control" value="' . $othernames . '" ></div></td></tr>';
    echo '<tr><td><span class="tl">Gender:</span></td>';
    echo '<td colspan="2">
        <div class="form-group">
        <select class="form-control" name="gender">
            <option value="Male">Male</option>
            <option value="Female.">Female</option>';
    if($gender!=""){
        echo '<option selected="selected">'.$gender.'</option>';
    }
    echo '</select></div>
        </td></tr>';
    echo '<tr><td><span class="tl">Marital Status:</span></td>';
    echo '<td colspan="2">
        <div class="form-group">
        <select class="form-control" name="mstatus">
            <option value="Single.">Single</option>
            <option value="Married.">Married</option>';
    if($mstatus!=""){
        echo '<option selected="selected">'.$mstatus.'</option>';
    }
    echo '</select></div>
        </td></tr>';
    echo '<tr><td><span class="tl">Date of Birth:</span></td>';
    echo '<td colspan="2"><div class="form-group">
            <input type="text" class="form-control" id="datetimepicker2" value="'.$birthdate.'" name="dob" class="span12" placeholder="Date to birthday is Required" required/>
            </div>
        </td></tr>';
    echo '<tr><td><span class="tl">Phone number:</span></td>';
    echo '<td colspan="2"><div class="form-group"><input type="text" name="gsm" prefix="+234" class="form-control" value="' . $gsm. '"></td></div></tr>';
    echo '<tr><td><span class="tl">Email:</span></td>';
    echo '<td colspan="2"><div class="form-group"><input type="email" name="email" class="form-control" value="' . $email. '" ></div></td></tr>';
    echo '<tr><td><span class="tl">Residential Address:</span></td>';
    echo '<td colspan="2"><div class="form-group"><textarea class="form-control" name="residence">';
    if($contactaddress!=""){
        echo $contactaddress ;
    }
    echo '</textarea></div></td></tr>';
    echo '<tr>
                <td>Blood Group:</td>
                <td colspan="2">
                <div class="form-group">
                    <select name="bgroup" id="select" class="form-control">';
    if($bloodgroup!=""){
        echo '<option selected="selected">'.$bloodgroup.'</option>
        <option value="O+">O+</option>
        <option value="O">O</option>
        <option value="A+">A+</option>
        <option value="A">A</option>
        <option value="B+">B+</option>
        <option value="B">B</option>
        <option value="B+">AB+</option>
        <option value="B">AB-</option>';
    }
    else { echo '<option value="sel">--Please Select--</option>
        <option value="O+">O+</option>
        <option value="O">O</option>
        <option value="A+">A+</option>
        <option value="A">A</option>
        <option value="B+">B+</option>
        <option value="B">B</option>
        <option value="B+">AB+</option>
        <option value="B">AB-</option>';
    }
    echo '</select>
                </div>
            </td>
        </tr>
        <tr>
            <td>Nationality:</td>
            <td colspan="2">
                <div class="form-group" id="spryselect1">
                    <select id="nationality" name="nationality" class="form-control">
                        ';
    if($country!=""){
        echo '<option value="'.$row['countryid'].'" selected="selected">'.$country.'</option>';
    }else echo '<option value="">--Select Country--</option>';
    $sql = "SELECT * FROM tblcountries";
    $result = mysqli_query($con,$sql);
    while($row = mysqli_fetch_array($result)) {
        $countryname = $row['countryname'];
        $countryid = $row['countryid'];
        echo "<option value = $countryid>$countryname</option>";
    }
    echo '</select>
                    </div>
                </td>
            </tr>
            <tr id = "state_row">
                <td>State of Origin:</td>
                <td colspan="2"><div class="form-group">
                    <select id="state" name="state" class="form-control">';
    if($state!=""){
        echo '<option selected="selected" value="'.$stateid.'">'.$state.'</option>';
    }else echo '<option value="">--Select State--</option>';
    $result = mysqli_query($con,"SELECT * FROM tblstate");
    while($row = mysqli_fetch_array($result)) {
        $statename = $row['statename'];
        $stateid = $row['stateid'];
        echo "<option value = $stateid>$statename</option>";
    }
    echo'</select>
                   </div>
                </td>
            </tr>
            <tr id = "lga_row">
                <td>LGA:</td>
            <td colspan="2">
                <div class="form-group">
                    <select id="lga" name="lga" class="form-control">';
    if($lga!=""){
        echo '<option selected="selected" value="'.$lgaid.'">'.$lga.'</option>';
    }else echo '<option value="">--Select LGA--</option>';
    echo '</select>
                </div>
                </td>
            </tr>
            <tr id = "hometown_row">
                <td>Hometown:</td>
                <td><div class="form-group">
                    <input type="text" name="hometown" class="form-control" value="'.$hometown.'" size="32" />
                    </div>
                </td>
            </tr>
       <td colspan="3" class="text-right"><input type="submit" name="save" value="Save Changes" class="btn btn-primary"></td></tr>';

    echo '</table>';
}
?>

</form>
</div>
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
<?php
/**
 * Created by PhpStorm.
 * User: HP USER
 * Date: 12/13/2016
 * Time: 11:47 PM
 */
if(isset($_POST['save'])) {
    $sid = $_POST['id'];
    $stitle = $_POST['title'];
    $ssurname = $_POST['surname'];
    $sonames = $_POST['onames'];
    $sgender = $_POST['gender'];
    $smstatus = $_POST['mstatus'];
    $sdob = $_POST['dob'];
    $birthdate = date('Y-m-d',strtotime($sdob));
    $sgsm = $_POST['gsm'];
    $semail = $_POST['email'];
    $sresidence = $_POST['residence'];
    $sbgroup = $_POST['bgroup'];
    $snationalty = $_POST['nationality'];
    $sstate = $_POST['state'];
    $slga = $_POST['lga'];
    $shometown = $_POST['hometown'];

    $update = mysqli_query($con, "UPDATE personalinfo SET staffID='$sid', title='$stitle', surname='$ssurname',othernames= '$sonames',
gender='$sgender',mstatus='$smstatus',birthdate='$birthdate',gsm='$sgsm',email='$semail',contactaddress='$sresidence',bgroup='$sbgroup',
nationality='$snationalty',
state='$sstate',lga='$slga',hometown='$shometown'
 WHERE staffID='$sid'");
    if (($update)) {
        echo $_SESSION['update'] = "<h3 style='color:green'>Edited successfully</h3>";
        header('location:edit_profile.php?id='.$sid.'');
    } else {
        echo $_SESSION['update'] = "<h3 style='color:red'>unable to edit update.</h3>" . mysqli_error($con);
        header('location:edit_profile.php?id='.$sid.'');

    }
}
?>