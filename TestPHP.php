<?php
$servername = "engr-cpanel-mysql.engr.illinois.edu";
$username = "groupmat_admin";
$user_password = "password1";
$dbname = "groupmat_master";

// Create connection
$conn = new mysqli($servername, $username, $user_password, $dbname);

// Check connection
if (mysqli_connect_error()) {
   die("Database connection failed: " . mysqli_connect_error());
}
// echo "Connected successfully<br><br>";

?>