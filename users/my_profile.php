<?php
include '../includes/conn.php'	;
$title = 'KASU HRMS My Profile';
include  'header.php';
?>

<div class="row">
    <div class="col-md-9"> <span class="lead" >My Profile</span></div>
</div>
<div class="text"align="center">
    <?php
    $pnumber = $_SESSION['pnum'];
    $squery=mysqli_query($con,"select * from personalinfo
                        LEFT join tblcountries on tblcountries.countryid=personalinfo.nationality
                        LEFT join tblstate on tblstate.stateid=personalinfo.state
                        LEFT join tbllga on tbllga.lgaid=personalinfo.lga
                        LEFT join ranks on ranks.rankID=personalinfo.rank
                        LEFT JOIN users on users.staffID=personalinfo.staffID
                        LEFT join tblunit on tblunit.unitid=personalinfo.unit WHERE personalinfo.staffID = '$pnumber'");
    echo mysqli_error($con);
    if(mysqli_num_rows($squery) > 0) {
       while($row = mysqli_fetch_array($squery)) {
           $_SESSION['pnum'];
           $surname = $row['surname'];
           $othernames = $row['othernames'];
           $pnumber = $row['staffID'];
           $contactaddress = $row['contactaddress'];
           $birthdate = $row['birthdate'];
           $gender = $row['gender'];
           $passport = $row['passport'];
           $fullname = ucfirst($surname) . " " . ucfirst($othernames);
           $mstatus = $row['mstatus'];
           $country = $row['countryname'];
           $state = $row['statename'];
           $lga = $row['lganame'];
           $hometown = $row['hometown'];
           $hometown = $row['hometown'];
           $gsm = $row['gsm'];
           $firstAppt = $row['firstappt'];
           $email = $row['email'];
           $title = $row['title'];
           $rank = $row['rankname'];
           $cadre = $row['ranktype'];
           $unit = $row['unitname'];

       }
    }else echo '0';
        echo "<div class='table-responsive ' style='border:1px dashed #888;border-radius:5px;width: 90%;'>
        <img class='img-thumbnail img-responsive pull-right' src='../images/passport/".$passport."' height='100px' alt='mypassport'width='100px'>
        <table  class='table table-condensed table-striped' >";
        echo '
        <tr>
        <td style="background: #00ff00;font-weight: bold">Personal Info</td>
        </tr>
		<tr>
          <td >
          Name:
          </td>
          <td>'.ucfirst($title).' '.ucfirst($fullname).'</td>
        </tr>
        <tr>
          <td>
            Staff ID:
          </td>
          <td>'.ucfirst($pnumber).'</td>
        </tr>
		<tr>
          <td>
          Date of Birth:
          <td>'. ucfirst($birthdate).'</td>
        </tr>

    <tr>
        <td>
        Gender:
        <td>'. ucfirst($gender).' </td>
    </tr>
    <tr>
        <td    >
        Marital Status:
        </td>
        <td>'.ucfirst($mstatus).'</td>
    </tr>
     <tr>
        <td>Nationality:
        </td>
        <td>'. ucfirst($country).'</td>
    </tr>
     <tr>
        <td>State:
        </td>
        <td>'. ucfirst($state).'</td>
    </tr>
     <tr>
        <td>L.G.A.:
        </td>
        <td>'. ucfirst($lga).'</td>
    </tr>
    <tr>
        <td>Home Town
        </td>
        <td>'. ucfirst($hometown).'</td>
    </tr>

    <tr>
        <td>GSM Number:
                 </td>
        <td>
        '.ucfirst($gsm).'</td>
    </tr>
    <tr>
        <td>
        E-mail Address:
       </td>
        <td>'.($email).'</td>
    </tr>
    <tr>
        <td>
        Contact Address
        </td>
        <td>'. ucfirst($contactaddress).'</td>
    </tr>
    <tr>
        <td style="background: #00ff00;font-weight: bold">Job Info</td>
        </tr>
        <tr>
        <td>Cadre</td>
        <td>
        '.ucfirst($cadre).'</td>
    </tr>
    <tr>
        <td>
        Unit:
       </td>
        <td>'.($unit).'</td>
    </tr>
     <tr>
        <td>
        Rank:
        </td>
        <td>'. ucfirst($rank).'</td>
    </tr> <tr>
        <td>
        First Appointment:
        </td>
        <td>'. ucfirst($firstAppt).'</td>
    </tr>
        </table>';
    ?>

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