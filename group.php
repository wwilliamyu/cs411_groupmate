<html>
<head>
   <title>Add group</title>
   <link rel="stylesheet" href="css/bootstrap.min.css">
   <link rel="stylesheet" href="css/bootstrap-datetimepicker.min.css">
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
   <script src="bootstrap-3.3.5-dist/js/bootstrap.js"></script>
   <script src="bootstrap-3.3.5-dist/js/bootstrap.min.js"></script>
</head>

<body>

   <?php
        require "TestPHP.php";
        $this_user_email = $_COOKIE['username'];
        $this_user_id = $_COOKIE['user_id'];
        $this_user_name = $_COOKIE['firstname'];

        $sql_query = "SELECT firstname, lastname, user_id FROM groupmat_master.Addfriends, groupmat_master.Users WHERE groupmat_master.Addfriends.user_id2 = groupmat_master.Users.user_id AND groupmat_master.Addfriends.user_id1 = (SELECT user_id FROM groupmat_master.Users WHERE email='$this_user_email');";
        $query_result = mysqli_query($conn, $sql_query);
        $html_code = '';
        if (mysqli_num_rows($query_result)) {
            while ($row = $query_result->fetch_assoc()) {
               $html_code .= '<label class="btn btn-default friend">
                              <input type="radio" autocomplete="off" name="myfriends" value="'
                              . $row['user_id'] . 
                             '">' . $row['firstname'] . ' ' . $row['lastname'] .
                             '</label>';
            }
        } else {
            $html_code .= "You have no friends.";
            //mysqli_error($conn);
        }
    ?>

<h1> Add a new group!</h1>


<form method="POST">

   <div class="form-group">
      <label for="friends">Select from my friends:</label>
      <div id="friends" class="btn-group" data-toggle="buttons">
      <?php
         echo $html_code;
      ?>
      </div>
      <button type="submit" class="btn btn-add-friend" id="add-friend">Add</button>
   </div>

   <div class="col-xs-12">
   
   
   
   <div class="input-group">
      <span class="input-group-addon" id="sizing-addon1">Search Strangers</span>
      <input type="text" class="form-control" name="search" id="friend_name" placeholder="Enter some stranger's name here!">
   </div>
   </div><br><br>

   <div class="container-fluid" id="searchResults">
       <table class="table table-hover table-condensed" id="strangers-results">
       </table>
   <div><center><input class="btn btn-default" type="button" value="Add stranger" id="add-stranger"></center></div>
   </div>

   <p><p>
   <div class="container" id="newGroup" div-justified>
      <div class="input-group">
         <span class="input-group-addon" id="new-group-name" required>Group name</span>
         <input type="text" class="form-control" name="groupname" id="new_group_name" placeholder="Enter your new group name here.">
      </div>

      <table class="table" id="new-group-table">
      </table>
   <div><center><input class="btn btn-default" type="button" value="Create New Group" id="make-new-group"></center></div>
   </div>
</form>

<br><center>
<button onclick="location.href = 'http://groupmate.web.engr.illinois.edu/main_page.php';" type="button" class="btn btn-default">Back to my main page</button>
</center>



<script type="text/javascript">
    results = [];
    new_members = [];
    new_members_names = [];

    $(document).ready(function(){

        $(".container-fluid").hide();
        $(".container").hide();

        $('#friend_name').keyup(function(){
            results = []; // contains search results in hash table;
            var searchString = $("#friend_name").val();
            $("#friend_name").append($('br')).append($('searchString'));
            //console.log(searchString); // checking the string got from keyboard 

            // if searchString is not empty
            if (searchString) {
                $.ajax({
                    method: "POST",
                    url: "person_query.php",
                    data: { object_string: searchString
                          },
                    success: function(data){
                        displayStrangers(data); //echo what the server sent back...
                    }
                })
                .done(function(msg) {
                    //console.log("Successfully searched for " + searchString);
                });
                return false;
            } else {
                $(".container-fluid").hide();
                results = [];
            };

        });
    })
</script>

<script type="text/javascript">
    function displayStrangers(string) {
        if (string == "") {
            $(".container-fluid").hide();
        } else {
            if ($(".container-fluid").is( ":hidden" )) {
               $(".container-fluid").toggle(1500);
            }
            document.getElementById("strangers-results").innerHTML = string;
        }
    }
</script>

<script type="text/javascript">

$('#strangers-results').on('click', '.clickable-row', function(event) {
   new_member_uid= $(this).attr('value');
   new_member_name = $(this).children()[0].outerText + " " + $(this).children()[1].outerText;
   $(this).addClass('active').siblings().removeClass('active');
});
</script>

<script type="text/javascript">
$('.btn.btn-default.friend').on('click', function(event) {
   new_member_uid= $(this).children()[0].value;
   new_member_name = $(this).text().trim();
});
</script>

<script type="text/javascript">
$('#add-stranger').on('click', function(event) {
   if (new_members.indexOf(new_member_uid) > -1) {
      alert("That person is already in the list.");
   } else {
      new_members.push(new_member_uid);
      new_members_names.push(new_member_name);
   }
   event.preventDefault(); // prevent from refreshing the page
   show_new_group_information();
});
</script>

<script type="text/javascript"> 
$('#add-friend').on('click', function(event) {
   $('.btn.btn-default.friend').removeClass('active');
   if (new_members.indexOf(new_member_uid) > -1) {
      alert("That person is already in the list.");
   } else {
      new_members.push(new_member_uid);
      new_members_names.push(new_member_name);
   }
   event.preventDefault();
   show_new_group_information();
});
</script>

<script type="text/javascript">
function show_new_group_information() {
   if ($(".container").is( ":hidden" )) {
      $('.container').toggle(1000);
      var this_person_id = <?php echo $this_user_id; ?>;
      new_members.push(this_person_id.toString());
      new_members_names.push("Me");
   }
   new_group = "<tr><td>Number</td><td>Name</td></tr>";
   for (var i = 0; i < new_members_names.length; i++) {
      var count = i+1;
      var n_mem = "<tr><td>" + count + "</td><td>" + new_members_names[i] + "</td></tr>"
      new_group += n_mem;
   }
   document.getElementById("new-group-table").innerHTML = new_group;
};
</script>

<script type="text/javascript">
$('#make-new-group').on('click', function(event) {
   var new_name = $("#new_group_name").val();
   var members = "";
   for (var i = 0; i < new_members.length; i++) {
      members += (new_members[i] + " ");
   }
   $.ajax({
      method: "POST",
      url: "make_new_group.php",
      data: {uid: members,
             groupname: new_name},
      success: function(data){
         // console.log(data); //echo what the server sent back...
         alert("Your group has been made!");
         }
  })
  .done(function(msg) {
     
  });
});
</script>
</body>

</html>