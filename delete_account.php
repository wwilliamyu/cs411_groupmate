<?php
require "TestPHP.php";

$dpassword1 = $_POST["delete_password1"];
$dpassword2 = $_POST["delete_password2"];
$demail = $_POST["delete_email"];

if ($dpassword1 != $dpassword2) {
   echo "Password is not equal! You don't really want to delete your account, do you!";
} else {
   $sql_query1 = "SELECT * FROM groupmat_master.Users WHERE email='$demail' AND password='$dpassword1';";
   $sql_query2 = "DELETE FROM groupmat_master.Users WHERE email='$demail' AND password='$dpassword1';";
   $result = mysqli_query($conn, $sql_query1);

   if (mysqli_num_rows($result)) {
      mysqli_query($conn, $sql_query2);
      echo "Your account has been deleted.";
   } else {
      echo "Your password is wrong, or no such user exists." . mysqli_error($conn);
   }
}
mysqli_close($conn);
?>