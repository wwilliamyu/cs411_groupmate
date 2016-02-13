<?php

   require "TestPHP.php";

   $this_user_id = $_COOKIE['user_id'];
   $array = $_POST['uid'];
   $group_name = $_POST['groupname'];
   
   // register for new group first
   $sql_query1 = "INSERT INTO groupmat_master.Groups (group_name)
                  VALUE ('" . $group_name . "');";

   $sql_result1 = mysqli_query($conn, $sql_query1);
   
   // get the new group number
   $sql_query2 = "SELECT group_id 
                  FROM groupmat_master.Groups 
                  WHERE group_name='" . $group_name . "';";
   
   //echo $sql_query2; // working

   $sql_result2 = mysqli_query($conn, $sql_query2);
   $row = $sql_result2->fetch_assoc();
   $group_id = $row['group_id'];
   
   //echo $group_id; // working
   
   // now insert new group members into UserBelongToGroup database
   $array_elem = [];
   $array_elem = explode(' ', $array);
   //print_r($array_elem);
   
   for ($i = 0; $i < count($array_elem); $i++) {
      if ($array_elem[$i] == "") {
         continue;
      }
      //print_r($array_elem[$i]);
      $group_members[$i] = intval($array_elem[$i]);
      
      $sql_query3 = "INSERT INTO groupmat_master.UserBelongToGroup (group_id, user_id)
                     VALUE ('" . $group_id ."', " . $group_members[$i] . ");";
      mysqli_query($conn, $sql_query3);
   }
   // echo "Users should have all been updated.";

?>