<!DOCTYPE html>

<html lang='en'> 
<head>
    <meta charset="UTF-8" /> 
    <title>
        USER SUMMARY
    </title>
    <link rel="stylesheet" type="text/css" href="css/style.css" />
    

</head>
<body bgcolor="#FFF">
	<div class="summary">
	
		
		<p> Welcome, 
			<?php
			require "TestPHP.php";
			$COOK=$_COOKIE['username'];
			$sql_query2 = "SELECT firstname, lastname FROM groupmat_master.Users WHERE email='$COOK';";
			$query_result2 = mysqli_query($conn, $sql_query2);
			
			while ($row = $query_result2->fetch_assoc()) {
				echo "<B>".$row['firstname']. ' ' . $row['lastname'] ."</b>";
	             	}
			
			?> 
		</p>
		 
		<p> List of friends: 
			<?php require "TestPHP.php"; 
			$COOK=$_COOKIE['username'];
			$sql_query = "SELECT firstname, lastname FROM groupmat_master.Addfriends, groupmat_master.Users WHERE groupmat_master.Addfriends.user_id2 = groupmat_master.Users.user_id AND groupmat_master.Addfriends.user_id1 = (SELECT user_id FROM groupmat_master.Users WHERE email='$COOK');";
			
			$query_result = mysqli_query($conn, $sql_query);

			
			if (mysqli_num_rows($query_result)>0) {
            			
            			$row = array();
            			$i = 0;
            			while ($row = mysqli_fetch_array($query_result)) {
	               			$i++;
	               			if ($i == $query_result->num_rows) {
	               				echo "<B>".$row['firstname']. ' ' . $row['lastname'] ."</b>";
	               			}
	               			else {
	               				echo "<B>".$row['firstname']. ' ' . $row['lastname'] . ', ' ."</b>";
	               			}
	               			
            			}
       		 	}
       		 	
			
			
			
		
			?> 
		</p>
			
		<p> Current groups you are active in:  
			<?php
			require "TestPHP.php";
			$COOK=$_COOKIE['username'];
			$USER_ID=$_COOKIE['user_id'];
			$sql_query3 = "SELECT groupmat_master.Groups.group_name AS group_name
			               FROM groupmat_master.Groups, groupmat_master.UserBelongToGroup 
				       WHERE groupmat_master.UserBelongToGroup.user_id=" . $USER_ID .
				       " AND groupmat_master.UserBelongToGroup.group_id=groupmat_master.Groups.group_id;";
			$query_result2 = mysqli_query($conn, $sql_query3);
			
			$groups = array();
			$i = 0;
			while ($groups = mysqli_fetch_array($query_result2)) {
				$i++;
	               		if ($i == $query_result2->num_rows) {
	               			echo "<B>".$groups['group_name']."</b>";
	               		}
	               		else {
	               			echo "<B>".$groups['group_name'] . ', ' ."</b>";
	               		}
	             	}
			
			?>
		
		</p>
		<br>
		
		<form action="main_page.php"> 
			<input type="submit" name="submit" value="Manage my money!" class="button" />
		</form>



		<form action="add_friend.html">
			
			<input type="submit" name="submit" value="Add a friend" class="button" />
		</form>
	
	
		<form action="group.php">
			
			<input type="submit" name="submit" value="Add a group" class="button" />
		</form>
		

		<form action="yuching.html">
			<input type="submit" name="submit" value="Add a transaction" class="button" />
		</form>
	


		<form action="transaction.php">
			<input type="submit" name="submit" value="Add a bill" class="button" />
		</form>
		


		<form action="suggestion.php">
			<input type="submit" name="submit" value="Get a suggestion" class="button" />
		</form>
	
		<form action="price_range.php">
			<input type="submit" name="submit" value="Suggest Payback" class="button" />
		</form>
	
		<form action="logout.php">
		
			<input type="submit" name="submit" value="Logout" class="button" />
		</form>
		
	</div>
	

</div>


</body>
</html>