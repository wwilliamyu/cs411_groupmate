<?php

	require "TestPHP.php";

	$this_user_id = $_COOKIE['user_id'];
	$search_string = $_POST['object_string'];
        $html_code = "";
	/*search database for persons with this string*/
	$sql_query1 = "SELECT firstname, lastname, user_id 
                       FROM (SELECT *
                             FROM groupmat_master.Users 
                             WHERE user_id NOT IN (SELECT user_id2
                                                   FROM Addfriends
                                                   WHERE user_id1=" . $this_user_id . ")
                             ) AS Strangers
                       WHERE (firstname LIKE '%" . $search_string . "%' OR
                              lastname LIKE '%" . $search_string . "%' OR
                              email LIKE '%" . $search_string . "%') 
                              AND user_id<>" . $this_user_id . ";";
        // echo $sql_query1; // checking if right query output

	$query_result= mysqli_query($conn, $sql_query1);
       
        if (mysqli_num_rows($query_result) > 0) {
            $count = 0;
	    while ($row = $query_result->fetch_assoc()) {
                $stranger_detail = "<tr class='clickable-row' value=" . $row['user_id'] . "><td id='table-row" . $count . "'>" . $row['firstname'] . "</td>
                                        <td>" . $row['lastname'] . "</td>
                                    </tr>";
                echo $stranger_detail;
                $count++;
            }
        } 
        //echo $html_code;
?>