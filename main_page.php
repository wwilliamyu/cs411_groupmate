<?php
session_start();
?>

<!DOCTYPE html>
<html>
<head>
<title>My main page</title>
<style>

	table.empty{
            border-collapse:collapse;
            empty-cells:hide;
            margin-left:auto; 
	    margin-right:auto;
	   
         }
         td.empty{
            padding:5px;
            border-style:solid;
            border-width:1px;
            border-color:#999999;
         }
	html, body {
        	height: 100%;
    	}
    	html {
        	display: table;
        	margin: auto;
    	}
    	body {
        	display: table-cell;
        	vertical-align: top;
    	}
    	#header {
        	<!--background-color:white;-->
        	color:black;
        	text-align:center;
        	padding:10px;
    	}
    	#nav {
        	width:100px;
        	height:300px;
        	float:left;
        	line-height:30px;
        	padding:10px;
        	      
    	}
    	#section {
        	width:350px;
        	height:300px;
        	float:left;
        	color:black;
        	padding:10px;
    	}
    	#footer {
        	<!--background-color:white;-->
        	color:black;
        	clear:both;
        	text-align:center;
        	padding:10px;	 	 
    	}
    	button { 
        	width:100px; 
    	} 
</style>
</head>

<body>

<div id="header">
	<h1> My Main Page </h1>
		<table class="empty">
	<!-- Add PHP here -->
	<tr>   
	<td class="empty">
	TOTAL BALANCE:
	<?php
	
	require "TestPHP.php";
       	$uEmail = $_SESSION['login_user'];
	$sql_query = "SELECT user_id FROM Users WHERE email = '$uEmail';";
	$query_result = mysqli_query($conn, $sql_query);
	while($row = mysqli_fetch_array($query_result, MYSQL_ASSOC)) {	
		$uID = intval($row['user_id']);
		//echo $uID;
	}
	//from
	$sql_query = "SELECT money_amount FROM Transactions WHERE from_user_id = $uID";
	$sql_result = mysqli_query($conn, $sql_query);
	$total_balance = 0;
	$total_bill = 0;
	$total_payback = 0;
	while($row = mysqli_fetch_array($sql_result, MYSQL_ASSOC)){
		$current_user_bill = $row['money_amount'];
		//echo $current_user_bill;
		$total_bill = $total_bill + intval($current_user_bill);
		//echo strval($total_bill);
	}
	$sql_query = "SELECT money_amount FROM Transactions WHERE to_user_id = $uID";
	$sql_result = mysqli_query($conn, $sql_query);
	while($row = mysqli_fetch_array($sql_result, MYSQL_ASSOC)){
		$current_user_payback = $row['money_amount'];
	
		$total_payback = $total_payback + intval($current_user_payback);
	}
	$total_balance = $total_bill - $total_payback;
	echo "$";
	echo strval($total_balance);
	?>
	</td>
        <td class="empty">
        YOU OWE: 
        <?php
        echo "$";
        echo $total_payback;
        ?>
        </td>
        <td class="empty">YOU ARE OWED:
        <?php
        echo "$";
        echo $total_bill;
        ?>
        </td>
     
	</tr>
	</table>
	

	
</div>


<div id="nav">
	<!-- Add LINK To Other Page. -->
	<div class="btn-group-vertical" role="group" aria-label="...">
	<button onclick="location.href = 'http://groupmate.web.engr.illinois.edu/change_details.php';" type="button" class="btn btn-default">Edit my profile</button>
        <button onclick="location.href = 'http://groupmate.web.engr.illinois.edu/add_friend.html';" type="button" class="btn btn-default">Add a friend</button>
        <button onclick="location.href = 'http://groupmate.web.engr.illinois.edu/group.php';" type="button" class="btn btn-default">Add a group</button>
        <button onclick="location.href = 'http://groupmate.web.engr.illinois.edu/yuching.html';" type="button" class="btn btn-default">Add a transaction</button>
        <button onclick="location.href = 'http://groupmate.web.engr.illinois.edu/transaction.php';" type="button" class="btn btn-default">Add a bill</button>
        <button onclick="location.href = 'http://groupmate.web.engr.illinois.edu/price_range.php';" type="button" class="btn btn-default">Get items recommended for payback</button>
        <button onclick="location.href = 'http://groupmate.web.engr.illinois.edu/main_page.php';" type="button" class="btn btn-default">Back to my main page</button>
        <button onclick="logout()" type="button" class="btn btn-default">Log out</button>
        <script>
	function logout() {
		var r = confirm("Do you really want to log out?");
		if (r) {
       			window.location.href = 'logout.php'
    		}
	}
	</script>
    	</div>
</div>

<div id="section">
	<p>YOU OWE</p>
	<?php
        require "TestPHP.php";
       	$uEmail = $_SESSION['login_user'];
	$sql_query = "SELECT user_id FROM Users WHERE email = '$uEmail';";
	$query_result = mysqli_query($conn, $sql_query);
	while($row = mysqli_fetch_array($query_result, MYSQL_ASSOC)) {	
		$uID = intval($row['user_id']);
	}
	//get all to_user_id when from_user_id = $uID
	$sql_query = "SELECT DISTINCT to_user_id FROM Transactions WHERE from_user_id = $uID";
	$query_result = mysqli_query($conn, $sql_query);
	//get user_id
	$total_user = [];
	while($row = mysqli_fetch_array($query_result, MYSQL_ASSOC)){
		$temp = $row['to_user_id'];
		//echo $temp;
		$total_user[] = $temp;
	}
	//for each person, calculate the balance

	
	foreach($total_user as $oneuID){
	//echo $oneuID;
	//echo "  ";
	$person_bill_total = 0;
	$bill_query = "SELECT money_amount FROM Transactions WHERE to_user_id=$oneuID AND from_user_id=$uID";
	$bill_result = mysqli_query($conn, $bill_query);
	while($row = mysqli_fetch_array($bill_result, MYSQL_ASSOC)){
		$bill = intval($row['money_amount']);
		$person_bill_total = $person_bill_total + $bill;
	}
	//echo strval($person_bill_total);
	//echo "  ";
	
	$payback_query = "SELECT money_amount FROM Transactions WHERE from_user_id = $oneuID AND to_user_id=$uID";
	$payback_result = mysqli_query($conn, $payback_query);
	while($row = mysqli_fetch_array($payback_result, MYSQL_ASSOC)){
		$payback = intval($row['money_amount']);
		//echo strval($payback);
		$person_bill_total = $person_bill_total - $payback;
	}
	//echo strval($person_bill_total);
	//echo "  ";
	
	
	$name_query = "SELECT firstname FROM Users WHERE user_id = $oneuID";
	$name_result = mysqli_query($conn, $name_query);
	$name = mysqli_fetch_array($name_result, MYSQL_ASSOC)['firstname'];
	if($person_bill_total<0){
			//$html .= '<tr>';
			//$html .= '<td>';
			
			echo $name;
			echo " ";
			
			//$html .= '</td>';
			//$html .= '<td>';
			echo "$";
			echo strval(-$person_bill_total)."<br>";
			//$html .= '</td>';
			//$html .= '</tr>';		
	}

	}
	$html .= '</table>';
	?>
	
</div>

<div id="section">
	
	<p> YOU ARE OWE </p>  	
  	<?php
        require "TestPHP.php";
       	$uEmail = $_SESSION['login_user'];
	$sql_query = "SELECT user_id FROM Users WHERE email = '$uEmail';";
	$query_result = mysqli_query($conn, $sql_query);
	while($row = mysqli_fetch_array($query_result, MYSQL_ASSOC)) {	
		$uID = intval($row['user_id']);
	}
	//get all to_user_id when from_user_id = $uID
	$sql_query = "SELECT DISTINCT to_user_id FROM Transactions WHERE from_user_id = $uID";
	$query_result = mysqli_query($conn, $sql_query);
	//get user_id
	$total_user = [];
	while($row = mysqli_fetch_array($query_result, MYSQL_ASSOC)){
		$temp = $row['to_user_id'];
		//echo $temp;
		$total_user[] = $temp;
	}
	//for each person, calculate the balance
	$html .= '<table style="width:100%" align="center">';
	
	foreach($total_user as $oneuID){
	//echo $oneuID;
	//echo "  ";
	$person_bill_total = 0;
	$bill_query = "SELECT money_amount FROM Transactions WHERE to_user_id=$oneuID AND from_user_id=$uID";
	$bill_result = mysqli_query($conn, $bill_query);
	while($row = mysqli_fetch_array($bill_result, MYSQL_ASSOC)){
		$bill = intval($row['money_amount']);
		$person_bill_total = $person_bill_total + $bill;
	}
	//echo strval($person_bill_total);
	//echo "  ";
	
	$payback_query = "SELECT money_amount FROM Transactions WHERE from_user_id = $oneuID AND to_user_id=$uID";
	$payback_result = mysqli_query($conn, $payback_query);
	while($row = mysqli_fetch_array($payback_result, MYSQL_ASSOC)){
		$payback = intval($row['money_amount']);
		//echo strval($payback);
		$person_bill_total = $person_bill_total - $payback;
	}
	//echo strval($person_bill_total);
	//echo "  ";
	
	$name_query = "SELECT firstname FROM Users WHERE user_id = $oneuID";
	$name_result = mysqli_query($conn, $name_query);
	$name = mysqli_fetch_array($name_result, MYSQL_ASSOC)['firstname'];
	if($person_bill_total>0){
			//$html .= '<tr>';
			//$html .= '<td>';
			echo $name;
			echo "		";
			
			//$html .= '</td>';
			//$html .= '<td>';
			echo "$";
			echo strval($person_bill_total)."<br>";
			//$html .= '</td>';
			//$html .= '</tr>';		
	}

	}
	//$html .= '</table>';
	?>
	
</div>



<div id="footer">

</div>

</body>
</html>