<?php
	$con=mysqli_connect("localhost","my_user","my_password","my_db");
	
	
	$firstname = $_POST("firstname");
	$lastname = $_POST("lastname");
	$email = $_POST("email");
	$password = $_POST("password");
    
    $statement = mysqli_prepare($con, "SELECT * FROM User WHERE email = ? AND password = ?");
    $mysqli_stmt_bind_param($statement, "ss", $email, $password);
    $mysqli_stmt_execute($statement);
    
    mysqli_stmt_store_result($statement);
    mysqli_stmt_bind_result($statement, $user_id, $email, $password, $firstname, $lastname, $phone, $balance, $preference);
    
    $user = array();
    
    while(mysqli_stmt_fetch($statement)){
        $user[user_id] = $user_id;
        $user[email] = $email;
        $user[password] = $password;
        $user[firstname] = $firstname;
        $user[lastname] = $lastname;
        $user[phone] = $phone;
        $user[balance] = $balance;
        $user[preference] = $preference;
    }
    
    echo json_encode($user);
    
    mysqli_stmt_close($statement);
    
    
    mysqli_close($con);
    ?>
