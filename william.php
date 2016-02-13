<?php
session_start();
require "TestPHP.php";

 

$login_password = $_POST["password"];
$login_email = $_POST["username"];

$sql_query = "SELECT firstname, user_id FROM groupmat_master.Users WHERE email='$login_email' AND password='$login_password';";
$query_result = mysqli_query($conn, $sql_query);

if ($_POST['submit'] == 'Login') {
   if (mysqli_num_rows($query_result)) {

      $row = $query_result->fetch_assoc();
      setcookie('firstname', $row['firstname'], false); //cookies 
      setcookie('user_id', $row['user_id'], false); //cookies

      $_SESSION['login_user']= $login_email;
      setcookie('username', $_POST['username'], false); //cookies
      header('Location: summary.php');
      //echo "Log in successful!" .$sql_query;
   } else {
      echo "Log in details incorrect, or no such user exists.";
      mysqli_close($conn);
   }
} else if ($_POST['submit'] == 'Register') {
   header('Location: registration.html');
} else {
    //invalid action!
}

?>