<html>
<head>
   <title>Enter a new bill</title>
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
   <link rel="stylesheet" href="bootstrap-3.3.5-dist/css/bootstrap.min.css">
   <link rel="stylesheet" href="css/bootstrap-datetimepicker.min.css">
   <script src="js/jquery-1.11.3.min.js"></script>
   <script src="bootstrap-3.3.5-dist/js/bootstrap.min.js"></script>
</head>

<body>

   <h1> Enter a new bill</h1>

<?php 

   require "TestPHP.php";
   $this_user_email = $_COOKIE['username'];
   $this_user_id = $_COOKIE['user_id'];
   $this_user_name = $_COOKIE['firstname'];

   echo "<p>Current date and time: " . date("r") . "</p>"; // just testing out the php function -- can delete this

   $sql_query = "SELECT group_name, groupmat_master.Groups.group_id AS group_id
                 FROM groupmat_master.Groups, groupmat_master.UserBelongToGroup 
                 WHERE groupmat_master.UserBelongToGroup.user_id='" . $this_user_id . "'
                    AND groupmat_master.Groups.group_id=groupmat_master.UserBelongToGroup.group_id;";

   $query_result = mysqli_query($conn, $sql_query);
   if (mysqli_num_rows($query_result) > 0) {
      while ($row = $query_result->fetch_assoc()) {
         $html_code .= '<li value="' . $row['group_id'] . '"><a href="#">'
                        . $row['group_name'] . 
                       '</a></li>';
      }
   } else {
      echo "You have no friends.";
      mysqli_error($conn);
   }
?>

<form id="myForm" data-toggle="validator" role="form">
   <label for="mygroups" class="col-sm-2 control-label">Shared between</label>
   <div class="col-sm-10">
   <div class="btn-group">
      <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
         <span class="selection">My Groups</span><span class="caret"></span></button>
      <ul class="dropdown-menu">
         <?php
            echo $html_code;
         ?>
      </ul>  
   </div>
   </div>

   <label for="date" class="col-sm-2 control-label">Date</label>
         <div class="col-sm-10">
            <input type="date" name="transact_day" id="date" required="true">
         </div>
   <label for="transact_money" class="col-sm-2 control-label">Price $</label>
         <div class="col-sm-10">
            <input type="text" name="transact_money" id="price" required="true">
         </div>
   <label for="category-group" class="col-sm-2 control-label">Category</label>
      <div class="col-sm-10">
         <div id="category-group" class="btn-group" id="category" data-toggle="buttons">
              <label class="btn btn-default"><input type="radio" class="btn btn-default" name="category" title="Dining out"><span class="glyphicon glyphicon-cutlery" aria-hidden="true"></span></label>
              <label class="btn btn-default"><input type="radio" class="btn btn-default" name="category" title="Bills"><span class="glyphicon glyphicon-usd" aria-hidden="true"></span></label>
              <label class="btn btn-default"><input type="radio" class="btn btn-default" name="category" title="Entertainment"><span class="glyphicon glyphicon-sunglasses" aria-hidden="true"></span></label>
              <label class="btn btn-default"><input type="radio" class="btn btn-default" name="category" title="Food & Household"><span class="glyphicon glyphicon-shopping-cart" aria-hidden="true"></span></label>
              <label class="btn btn-default"><input type="radio" class="btn btn-default" name="category" title="Home, Furniture"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></label>
              <label class="btn btn-default"><input type="radio" class="btn btn-default" name="category" title="Travel & Outdoors"><span class="glyphicon glyphicon-plane" aria-hidden="true"></span></label>
              <label class="btn btn-default"><input type="radio" class="btn btn-default" name="category" title="Gift"><span class="glyphicon glyphicon-gift" aria-hidden="true"></span></label>
              <label class="btn btn-default"><input type="radio" class="btn btn-default" name="category" title="Other"><span class="glyphicon glyphicon-question-sign" aria-hidden="true"></span></label>
         </div>
      </div>
      <label for="item" class="col-sm-2 control-label">Enter items bought</label>
         <div class="col-sm-10">
            <input type="text" name="transact_to" id="item_description" required="true">
         </div>
      <div class="form-group">
         <label for="search" class="col-sm-2 control-label">Find</label>
         <div class="col-sm-10">
         <input type="text" id="searchInput" placeholder="Enter search item">
         <button type="button" class="btn btn-default btn-sm" value="Search" id="searchEnter">Search</button>
         </div>
      </div>

   <!-- COMMENTING THIS OUT COS JUST TOO PAINFUL.
   <label for="store-group" class="col-sm-2 control-label">Store</label>
        <div class="col-sm-10">
           <div id="store-group" class="btn-group" role="store" data-toggle="buttons">
              <label class="btn btn-default"><input type="radio" class="btn btn-default" name="store" id="walmart">Walmart</label>
              <label class="btn btn-default"><input type="radio" class="btn btn-default" name="store" id="meijer">Meijer</label>
           </div>
        </div>
   -->
   
 <div class="container">
 <!-- THIS IS THE RESULTS FROM SEARCH -->
   
    <div class="row">
        
        <div class="col-xs-1">
        <button type="button" class="btn btn-default" aria-label="Left Align" id="btn-scroll-left">
           <span class="glyphicon glyphicon-backward" aria-hidden="true"></span>
        </button>
        </div>
        
        <div class="col-xs-2">
            <div id="panel1" class="panel panel-primary">
                <!--<div class="panel-heading" >#panel1</div>-->
                <div class="panel-body"></div>
                <div class="panel-footer"></div>
            </div>
        </div>

        <div class="col-xs-2">
            <div id="panel2" class="panel panel-primary">
                <!--<div class="panel-heading">#panel2</div>-->
                <div class="panel-body"></div>
                <div class="panel-footer"></div>
            </div>
        </div>

        <div class="col-xs-2">
            <div id="panel3" class="panel panel-primary">
                <!--<div class="panel-heading">#panel3</div>-->
                <div class="panel-body"></div>
                <div class="panel-footer"></div>
            </div>
        </div>
        
        <div class="col-xs-2">
            <div id="panel4" class="panel panel-primary">
                <!--<div class="panel-heading">#panel4</div>-->
                <div class="panel-body"></div>
                <div class="panel-footer"></div>
            </div>
        </div>

        <div class="col-xs-1">
        <button type="button" class="btn btn-default" aria-label="Left Align" id="btn-scroll-right">
           <span class="glyphicon glyphicon-forward" aria-hidden="true"></span>
        </button>
        </div>
        
    </div>   
 </div>
   
<div class="col-md-offset-1">
   <button type="submit" class="btn btn-default btn-lg" value="Return" id="submit-rtn" onClick="this.form.action='main_page.php';this.form.submit()">To Main <span class="glyphicon glyphicon-share-alt" aria-hidden="true"></span></button>
   <button type="submit" class="btn btn-default btn-lg" value="Submit" id="submit-btn">Submit <span class="glyphicon glyphicon-check" aria-hidden="true"></span></button>
</div>

</div>

</form>

<script type="text/javascript">
$("#btn btn-default").on("click", function(e) {
    e.preventDefault();
    // preventing refreshing page
});
</script>

<script type="text/javascript">
   $(".dropdown-menu li a").click(function () {
      $(this).parents(".btn-group").find('.selection').text($(this).text());
      $(this).parents(".btn-group").find('.selection').val($(this).text());
      selected_groupname = $(this).parents(".btn-group").find('.selection').val($(this).text())[0].innerHTML;
   });
</script>

<script type="text/javascript">

document.getElementById("submit-btn").onclick = function() {

   var group_id = selected_groupname;
   var date = document.getElementById("date").value;
   var price = document.getElementById("price").value;
   var category = $('input[type=radio]:checked')[0].title;
   var item_description = document.getElementById("item_description").value;

   $.ajax({
      method: "POST",
      url: "add_bill.php",
      data: { bill_group: group_id,
              bill_date: date,
              bill_amount: price,
              bill_category: category,
              bill_description: item_description },
      success: function(data){
         console.log(data); //echo what the server sent back...
         }        
      })
      .done(function(msg) {
         alert("Bill inserted");
   });
   return false;
}

</script>

<script>

    results = {}; // contains search results in hash table
    index = 0; // for scrolling through result index
    stuff = "";
    
    $(document).ready(function(){

        $(".container").hide(); //hides result panel when page first loaded without a search
        $('.panel-button').click(function(){
            var panelID = $(this).attr('data-panelid');
            $('#'+panelID).toggle();
        });
        
        document.getElementById("searchEnter").onclick = function() {
            stuff = $("#searchInput").val();
            //var store = $('.form-control').find("option:selected").text();
            $("#searchInput").append($('br')).append($('stuff'));
            searchFor(stuff);
            if ($(".container").is( ":hidden" )) {
               $(".container").toggle(1500);
            }
            return false;
        };
        
        $('#searchInput').click(function() {
            this.value='';
        });
        
        // web-crawler
        function searchFor(someItem) {
            $.ajax({
                url: "http://api.walmartlabs.com/v1/search?"+
                     "apiKey=2ngydndmvt9ezwsh65xyeaws&format=json&numItems=25"+
                     "&query=" + someItem + "&callback=?",
                dataType: "jsonp",
                success: function ( response ) {
                    console.log( response ); // checking server response
                    results[someItem] = [];
                    for (var i = 0; i < 25; i++) { // max numItems handled by API=25
                        var a = {"name": response.items[i].name, 
                                 "price": response.items[i].salePrice,
                                 "price2": response.items[i].msrp, 
                                 "productURL": response.items[i].productUrl, 
                                 "image": response.items[i].thumbnailImage };
                        results[someItem].push(a);
                        console.log(results[someItem][i]); // printing result
                    }
                    displayResultsInPanel(someItem, index);
                }
            });
        }
        
        function displayResultsInPanel(someItem, j) {
            var k = 1;
            for (var i = 0; i < 4; i++) {
                //$('#panel'+k).children()[0].innerHTML = results[someItem][i]["name"];
                $('#panel'+k).children()[0].innerHTML = "<center><img src=\""+results[someItem][j]["image"]+"\" title=\""+results[someItem][j]["name"]+"\"></center>";
                if (results[someItem][j]["price"] != null) {
                   $('#panel'+k).children()[1].innerHTML = "<center><b>$" + results[someItem][j]["price"];
                } else {
                   $('#panel'+k).children()[1].innerHTML = "<center><b>$" + results[someItem][j]["price2"];
                }
                k++;
                j++;
                j = modulus(j,25);
            }
        }
        
        document.getElementById("btn-scroll-left").onclick = function() {
          index -= 4;
          index = modulus(index,25);
          displayResultsInPanel(stuff, index);
       };
       
       document.getElementById("btn-scroll-right").onclick = function() {
          index++;
          index = modulus(index,25);
          displayResultsInPanel(stuff, index);
       };
    }); // this is the end of search script
</script>

<script type="text/javascript"> 
   function modulus(x, y) {
      if (x>=y) {
         return (x-y);
      }
      if (x<0) {
         return (y+x);
      }
      return x;
   }
</script>

</body>

</html>