<?php
//Database Connection
$host = 'localhost';
$username = 'root';
$password = '';
$con=mysqli_connect( $host, $username, $password,'kasu_hrms');
if(mysqli_connect_error()){
    echo 'Failed to connect to database';
}
?>