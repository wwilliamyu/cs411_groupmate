<?php
require "TestPHP.php";

   $this_user_email = $_COOKIE['username'];
   $this_user_id = $_COOKIE['user_id'];
   $this_user_name = $_COOKIE['firstname'];

   echo "<p>Current date and time: " . date("r") . "</p>"; // just testing out the php function -- can delete this

   $sql_query = "SELECT lastname, password, phone, preference
                 FROM groupmat_master.Users
                 WHERE groupmat_master.Users.user_id='" . $this_user_id . "';";

   $query_result = mysqli_query($conn, $sql_query);
   if (mysqli_num_rows($query_result) > 0) {
      $row = $query_result->fetch_assoc();
      $this_user_lastname = $row['lastname'];
      $this_user_phone = $row['phone'];
      $this_user_preference = $row['preference'];
      $this_user_password = $row['password'];

      $html_code = '

		  <div class="form-group">
		    <label for="email">Email address</label>
		    <input type="email" class="form-control" id="InputEmail" placeholder="' . $this_user_email . '">
		  </div>
		  <div class="form-group">
		    <label for="password">Password</label>
		    <input type="password" class="form-control" id="InputPassword" placeholder="' . $this_user_password . '">
		  </div>
		  <div class="form-group">
		    <label for="firstname">First name</label>
		    <input type="text" class="form-control" id="InputFirstName" placeholder="' . $this_user_name . '">
		  </div>
		  <div class="form-group">
		    <label for="lastname">Last name</label>
		    <input type="text" class="form-control" id="InputLastName" placeholder="' . $this_user_lastname . '">
		  </div>
		  <div class="form-group">
		    <label for="phone">Phone Number</label>
		    <input type="text" class="form-control" id="InputPhoneNumber" placeholder="' . $this_user_phone . '">
		  </div>
		  <div class="form-group">
		    <label for="preference">Interests</label>
		    <input type="text" class="form-control" id="InputPreference" placeholder="' . $this_user_preference . '">
		  </div>
		  ';
		
   } else {
      echo "There is an error in processing your request.";
      mysqli_error($conn);
   }
?>


<html>
<head>
   <title>Edit my profile</title>
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
   <link rel="stylesheet" href="bootstrap-3.3.5-dist/css/bootstrap.min.css">
   <link rel="stylesheet" href="css/bootstrap-datetimepicker.min.css">
   <script src="js/jquery-1.11.3.min.js"></script>
   <script src="bootstrap-3.3.5-dist/js/bootstrap.min.js"></script>
</head>

<body>

   <h1>Change your details</h1>

   <form>
       <div class="form-group">
          <p class="help-block">Please put new details (only the ones you want to change).</p>
       </div>

       <div class="col-md-6 col-md-offset-1">
       <?php
          echo $html_code;
       ?>
       <button type="submit" class="btn btn-default" id="submit-btn">Submit</button>
       </div>
       <div class="col-md-6 col-md-offset-1">
       <button type="button" onclick="window.location.href='http://groupmate.web.engr.illinois.edu/main_page.php'" class="btn btn-default" >Go back to my main page</button>
       </div>
   </form>

<script type="text/javascript">
document.getElementById("submit-btn").onclick = function() {
   
   var email = document.getElementById("InputEmail").value;
   if (email == "") {
      email = document.getElementById("InputEmail").placeholder;
   }
   var password = document.getElementById("InputPassword").value;
   if (password == "") {
      password = document.getElementById("InputPassword").placeholder;
   }
   var firstname = document.getElementById("InputFirstName").value;
   if (firstname == "") {
      firstname = document.getElementById("InputFirstName").placeholder;
   }
   var lastname = document.getElementById("InputLastName").value;
   if (lastname == "") {
      lastname = document.getElementById("InputLastName").placeholder;
   }
   var phonenumber = document.getElementById("InputPhoneNumber").value;
   if (phonenumber == "") {
      phonenumber = document.getElementById("InputPhoneNumber").placeholder;
   }
   var preference = document.getElementById("InputPreference").value;
   if (preference == "") {
      preference = document.getElementById("InputPreference").placeholder;
   }

   console.log(email, password, firstname, lastname, phonenumber, preference);
   
   $.ajax({
      method: "POST",
      url: "update_details.php",
      data: { InputEmail: email,
              InputPassword: password,
              InputFirstName: firstname,
              InputLastName: lastname,
              InputPhoneNumber: phonenumber,
              InputPreference: preference }
      })
      .done(function(msg) {
         alert('Information Updated.');
      });
   location.reload();
};
</script>

</body>
</html>