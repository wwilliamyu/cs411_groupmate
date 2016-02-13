<html>
<head>
   <title>Enter new transaction</title>
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
   <link rel="stylesheet" href="bootstrap-3.3.5-dist/css/bootstrap.min.css">
   <link rel="stylesheet" href="css/bootstrap-datetimepicker.min.css">
   <link rel="stylesheet" href="css/style.css">
   <script src="js/jquery-1.11.3.min.js"></script>
   <script src="bootstrap-3.3.5-dist/js/bootstrap.min.js"></script>
</head>
<body>

		<div class="col-sm-10">
		
			<form action="suggestion.php" method="post">
				<font color="white" class="title">GET A SUGGESTION!</font>
				<input type="text" name="searchInput" placeholder="Enter search item">
				<input type="submit" name="submit" value="Submit" class="button" />
				
<?php

	require "TestPHP.php";
	
	$minsup = 0.05;
	$minconf = 0.05;
	
	//delete all the shit
	$sql_delete = "DELETE FROM groupmat_master.Rules;";
	mysqli_query($conn, $sql_delete);
	
	
	$sql_query1 = "SELECT item1, item2, item3 FROM groupmat_master.Bills WHERE item1 <> '' AND item2 <> ''; ";
	$query_result = mysqli_query($conn, $sql_query1);
	
        $rows = array();
        
        
        while ($rows = mysqli_fetch_array($query_result)) { // loop to go through each row
		
		
		$item11 = $rows['item1'];
		$item22 = $rows['item2'];
		$item33 = $rows['item3'];
		$occur = 0;
		
		for ($i = 0; $i < 3; $i++) { // loop to go through each relationship
		
		
			if($i==0)
			{
				$item1=$item11;
				$item2=$item22;
			}
			
			if($i==1)
			{
				$item1=$item11;
				$item2=$item33;
			}
			
			if($i==2)
			{
				$item1=$item22;
				$item2=$item33;
			}
			
			if ($item1 == '' || $item2 == '') {
				continue;
			}
	
		
			$sql_query2 = "SELECT * FROM groupmat_master.Rules WHERE item1 = '$item1' AND item2 = '$item2';";
			$query_result2 = mysqli_query($conn, $sql_query2);
			
			if ($query_result2->num_rows == 1) { //relationship exists
				$rows2 = mysqli_fetch_array($query_result2);
				$occur =$rows2['support'] + 1;
				$query_update = "UPDATE groupmat_master.Rules Set support = $occur WHERE item1= '$item1' AND item2 = '$item2';";
				mysqli_query($conn, $query_update);
				$query_update = "UPDATE groupmat_master.Rules Set support = $occur WHERE item1= '$item2' AND item2 = '$item1';";
				mysqli_query($conn, $query_update);
				$query_update = "UPDATE groupmat_master.Rules Set confidence = $occur WHERE item1= '$item1' AND item2 = '$item2';";
				mysqli_query($conn, $query_update);
				$query_update = "UPDATE groupmat_master.Rules Set confidence = $occur WHERE item1= '$item2' AND item2 = '$item1';";
				mysqli_query($conn, $query_update);
				
				
			}
			else if ($query_result2->num_rows == 0) { //relationship does not exist
				$query_insert = "INSERT INTO groupmat_master.Rules(item1, item2, support, confidence) Values ('$item1', '$item2', 1, 1);";
				mysqli_query($conn, $query_insert);
				$query_insert = "INSERT INTO groupmat_master.Rules(item1, item2, support, confidence) Values ('$item2', '$item1', 1, 1);";
				mysqli_query($conn, $query_insert);
			
			}
			else {
				echo "N/A";
			}
		
		}
		
	}
		
		// get total transactions from Bills
		$sql_tot_transactions = "SELECT * FROM groupmat_master.Bills;";
		$output = mysqli_query($conn, $sql_tot_transactions);
		$numrows = $output->num_rows;

		//select all rules
		$sql_rules = "SELECT * FROM groupmat_master.Rules;";
		$output = mysqli_query($conn, $sql_rules);
		
		// update support by dividing current occurrences with # total transactions
		$row = array();
		

		$i = 1;
		while($row = mysqli_fetch_array($output))
		{
			
			$supportt = $row['support'];
			$supportt = $supportt / $numrows;

			
			
			$row1 = $row['item1'];
			$row2 = $row['item2'];
			
			
			$sql_change_support = "UPDATE groupmat_master.Rules SET support = $supportt WHERE item1 = '$row1' AND item2 = '$row2' ;"; 
			mysqli_query($conn, $sql_change_support);
			
		}
		
		// get all the rules from table
		$sql_rules = "SELECT * FROM groupmat_master.Rules;";
		$query_result3 = mysqli_query($conn, $sql_rules);
		
		// for each rule, do this
		while($output1 = mysqli_fetch_array($query_result3))
		{
			$row1 = $output1['item1'];
			$row2 = $output1['item2'];
			
			// item1 of that rule
			$firstitem = $output1['item1'];
			
			// get all transactions that have $firstitem
			$sql_rules1 = "SELECT * FROM groupmat_master.Bills WHERE item1='$firstitem' OR item2='$firstitem' OR item3='$firstitem';";
			$output2 = mysqli_query($conn, $sql_rules1);
			
			//count how many of the above there are
			$occurrences_of_firstitem = $output2->num_rows;
			
			$new_confidences = $output1['confidence'] / $occurrences_of_firstitem;
			
			
			$sql_change_confidence = "UPDATE groupmat_master.Rules 
						  SET confidence=$new_confidences 
						  WHERE item1 = '$row1' 
						  AND item2 = '$row2' ;"; 
			mysqli_query($conn, $sql_change_confidence);
		}
		
		
        
        
        $searchitem = $_POST['searchInput'];
        
        $sql_outputer = "SELECT * FROM groupmat_master.Rules WHERE item1 = '$searchitem' AND support >= $minsup AND confidence >= $minconf;";
        $output = mysqli_query($conn, $sql_outputer);
        
        $row = array();
        while($row = mysqli_fetch_array($output))
        {
        	$print = $row['item2'];
      
        	echo "<div style=\"color: white;\">$print</div>";
       
        }
        
        
        
            	
?>
			</form>
		</div>
	
</body>


</html>