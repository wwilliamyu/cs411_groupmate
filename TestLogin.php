<?php
require "TestPHP.php";

$login_password = $_POST["login_password"];
$login_email = $_POST["login_email"];

$sql_query = "SELECT * FROM groupmat_master.Users WHERE email='$login_email' AND password='$login_password';";
$query_result = mysqli_query($conn, $sql_query);

if (mysqli_num_rows($query_result)) {
   setcookie('login_email', $_POST['login_email'], time()+3600, '/');
   setcookie('password', md5($_POST['password']), time()+3600, '/');
   header('Location: testtesttest.html');
   //echo "Log in successful!" .$sql_query;
} else {
   echo "Log in details incorrect, or no such user exists." . mysqli_error($conn);
   mysqli_close($conn);
}
?>