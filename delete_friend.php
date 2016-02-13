<?php

	require "TestPHP.php";
	$id = $_COOKIE['user_id'];
	$friend = $_GET['id2'];


	/*gets number*/
	$sql_query1 = "SELECT user_id FROM groupmat_master.Users WHERE email='$friend';";
	$friend_number = mysqli_query($conn, $sql_query1);
	
	$nig = array();
	$nig = mysqli_fetch_array($friend_number);
	$nig1 = $nig[0];

	$sql_query2 = "DELETE FROM groupmat_master.Addfriends WHERE user_id1 = '$nig1' AND user_id2 = '$id';"; 
	mysqli_query($conn, $sql_query2);

	$sql_query3 = "DELETE FROM groupmat_master.Addfriends WHERE user_id2 = '$nig1' AND user_id1 = '$id';"; 
	mysqli_query($conn, $sql_query3);
	
	
	//header('Location: http://groupmate.web.engr.illinois.edu/add_friend.html');
	$message = "Successfully deleted a friend!";
	echo "<script type='text/javascript'>alert('$message'); window.location = 'http://groupmate.web.engr.illinois.edu/add_friend.html';</script>";
?>