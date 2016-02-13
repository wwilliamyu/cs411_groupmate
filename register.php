<?php
require "TestPHP.php";

$rfirst_name = $_POST["rfirstname"];
$rlast_name = $_POST["rlastname"];
$rpassword1 = $_POST["rpassword1"];
$rpassword2 = $_POST["rpassword2"];
$remail = $_POST["remail"];
$phone = "";
$balance = "0";
$preference = "";
$user_id = "";

if ($rpassword1 != $rpassword2) {
   echo "Password is not equal!";
} else {
   $sql_query = "INSERT INTO groupmat_master.Users values('$remail','$rpassword1','$rfirst_name','$rlast_name', '$phone', '$balance', '$preference', '$user_id');";

   if (mysqli_query($conn, $sql_query)) {
         header("Location: http://groupmate.web.engr.illinois.edu/william.html");
         die();
   } else {
      echo "Data insertion error..." . mysqli_error($conn);
   }
   

   
}
mysqli_close($conn);
?>