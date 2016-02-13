<?php

require "TestPHP.php";

   $this_user_email = $_COOKIE['username'];
   $this_user_id = $_COOKIE['user_id'];
   $this_user_name = $_COOKIE['firstname'];

$cpassword = $_POST["InputPassword"];
$cemail = $_POST["InputEmail"];
$cfirstname = $_POST["InputFirstName"];
$clastname = $_POST["InputLastName"];
$cphone = $_POST["InputPhoneNumber"];
$cpreference = $_POST["InputPreference"];

$sql_query2 = "UPDATE groupmat_master.Users 
               SET preference='" . $cpreference . "', phone='" . $cphone . "', firstname='" . $cfirstname . "', lastname='" . $clastname . "', password='" . $cpassword . "', email='" . $cemail . "' 
               WHERE user_id=" . $this_user_id . ";";

mysqli_query($conn, $sql_query2);
   
echo "Updated database.";

?>