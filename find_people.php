<?php
require "TestPHP.php";

$areacode = $_POST["areacode"];

$sql_query1 = "SELECT * FROM groupmat_master.Users WHERE phone LIKE '$areacode%';";
$result = mysqli_query($conn, $sql_query1);

if (mysqli_num_rows($result) > 0) {
   while($row = mysqli_fetch_assoc($result)) {
      echo "Name: " . $row["firstname"] . " " . $row["lastname"] . "<br>";
   }
} else {
   echo "You have no one to stalk.";
}
mysqli_close($conn);
?>