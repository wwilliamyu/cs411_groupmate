<?php

	require "TestPHP.php";
	$id = $_COOKIE['user_id'];
	$friend = $_GET['id'];


	/*gets number*/
	$sql_query1 = "SELECT user_id FROM groupmat_master.Users WHERE email='$friend';";
	$friend_number = mysqli_query($conn, $sql_query1);
	
	$nig = array();
	$nig = mysqli_fetch_array($friend_number);
	$nig1 = $nig[0];

	$sql_query2 = "INSERT INTO groupmat_master.Addfriends values('$nig1','$id');";
	mysqli_query($conn, $sql_query2);

	$sql_query3 = "INSERT INTO groupmat_master.Addfriends values('$id','$nig1');";
	mysqli_query($conn, $sql_query3);
	
	
	//header('Location: http://groupmate.web.engr.illinois.edu/add_friend.html');
	
	$message = "Successfully Added a friend!";
	echo "<script type='text/javascript'>alert('$message'); window.location = 'http://groupmate.web.engr.illinois.edu/add_friend.html';</script>";
?>