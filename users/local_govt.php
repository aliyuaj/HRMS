<?php
	include'../includes/conn.php';

	$id = $_GET['state_id'];

	$sql = "select * from tbllga where stateid = '$id';";
	$query = mysqli_query($con,$sql);
	$count = mysqli_num_rows($query);
	if($count == 0)
	{
		echo '<option value="">--Select Local Govt.--</option>';
	}
	else 
	{
		while($row = mysqli_fetch_array($query)){
		echo '<option value="'.$row["lgaid"].'">'.$row["lganame"].'</option>';
		}
	}
?>