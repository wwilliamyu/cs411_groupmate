<?php
		require "TestPHP.php";
		
		if ($_POST['submit'] == "Add a transaction") {
			$tdate = $_POST["transact_day"];
			$moneyamount = $_POST["money_amount"];
			$fromuser = $_COOKIE['user_id'];
			
			$toname = $_POST["to_name"];
			$sql_query2 = "SELECT user_id FROM groupmat_master.Users WHERE email='$toname';";
			$query_result2 = mysqli_query($conn, $sql_query2);
			$niglet = $query_result2->fetch_assoc();
			$touser = $niglet['user_id'];
			
			$groupname = $_POST["group_name"]; // change to group_id for entering
			
			$sql_query = "SELECT group_id FROM groupmat_master.Groups WHERE group_name='$groupname';";
			$query_result = mysqli_query($conn, $sql_query);
			$row = $query_result->fetch_assoc();
			$groupid = $row['group_id'];
			
		        $sql_query1 = "INSERT INTO groupmat_master.Transactions(date, money_amount, group_id, from_user_id, to_user_id)
		        						VALUES('$tdate','$moneyamount', '$groupid', '$fromuser', '$touser');";
			mysqli_query($conn, $sql_query1);
			
			if (mysqli_query($conn, $sql_query)) {
	         		header("Location: http://groupmate.web.engr.illinois.edu/summary.php");
	         		die();
	   		} else {
	      			echo "Invalid transaction" . mysqli_error($conn);
	   		}
	   		
	   	}
	   	else if ($_POST['submit'] == 'Back to main page.') {
	   		header("Location: main_page.php");	   	
	   	}
	   	else {
	   	
	   	}
	  
?>