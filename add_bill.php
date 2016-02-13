<?php 

   require "TestPHP.php";
   $this_user_email = $_COOKIE['username'];
   $this_user_id = $_COOKIE['user_id'];
   $this_user_name = $_COOKIE['firstname'];
   $bill_group_name = $_POST['bill_group'];
   $bill_date = $_POST['bill_date'];
   $bill_amount = $_POST['bill_amount'];
   $bill_category = $_POST['bill_category'];
   $bill_description = $_POST['bill_description'];
   
   $sql_query0 = "SELECT groupmat_master.Groups.group_id as group_id
                  FROM groupmat_master.Groups
                  WHERE groupmat_master.Groups.group_name='" . $bill_group_name . "';";
   echo $sql_query0;

   $query_result = mysqli_query($conn, $sql_query0);

   if (mysqli_num_rows($query_result)) {

      $row = $query_result->fetch_assoc();
      $bill_group_id = $row['group_id'];

      $sql_query2 = "SELECT groupmat_master.UserBelongToGroup.user_id AS user_id 
                     FROM groupmat_master.UserBelongToGroup 
                     WHERE group_id=" . $bill_group_id . " AND user_id<>" . $this_user_id . ";";
      echo $sql_query2;

      $query_result2 = mysqli_query($conn, $sql_query2);
      $num_ppl = 1;
      while ($r = $query_result2->fetch_assoc()) {
         $friend_id[$num_ppl] = $r['user_id'];
         $num_ppl = $num_ppl+1;
      }
      echo $num_ppl;

      $divided_bill_amount = $bill_amount/$num_ppl;
      echo $divided_bill_amount;
      
      $looping = 1;
      while ($looping < $num_ppl) {
         $sql_query3 = "INSERT INTO groupmat_master.Transactions 
                        (date, from_user_id, to_user_id, group_id, money_amount) 
                        VALUES (
                       '" . $bill_date . "', 
                        " . $this_user_id . ",
                        " . $friend_id[$looping] . ",
                        " . $bill_group_id . ",
                        " . $divided_bill_amount . ");";
         echo $sql_query3;
         mysqli_query($conn, $sql_query3);
         $looping++;
      }

      if ($bill_description != "") {
         $word = explode(',', $bill_description);
         $n = count($word);
         for ($i = 0; $i < $n; $i++) {
            $word[$i] = trim($word[$i]);
         }
         if ($i < 3) {
            for ( ; $i < 3; $i++) {
               $word[$i] = "";
            }
         }
      }

      $sql_query1 = "INSERT INTO groupmat_master.Bills 
                     (money_amount, description, group_id, date, category, item1, item2, item3)
                     VALUES (
                     " . $bill_amount . ", 
                    '" . $bill_description . "', 
                     " . $bill_group_id . ",
                    '" . $bill_date . "',
                    '" . $bill_category . "',
                    '" . $word[0] . "', 
                    '" . $word[1] . "', 
                    '" . $word[2] . "');";
      echo $sql_query1;

      $query_result = mysqli_query($conn, $sql_query1);

   } else {
      echo "There's no group with such name.";
      mysqli_error($conn);
   }
?>