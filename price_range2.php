<!DOCTYPE html>
<html lang="en">
<head>
    <title>Recommendations</title>
    <link rel="stylesheet" href="bootstrap-3.3.5-dist/css/bootstrap.min.css">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
</head>
<body>
<?php
require "TestPHP.php";
$cur_user_id = $_COOKIE['user_id'];
$email = $_POST["email"];

$sql_query = "SELECT user_id FROM Users WHERE email = '$email'";
$sql_result = mysqli_query($conn, $sql_query);
while($row = mysqli_fetch_array($sql_result, MYSQL_ASSOC)){
	$payback_ID = $row['user_id'];
	
}
	$person_bill_total = 0;
	$bill_query = "SELECT money_amount FROM Transactions WHERE to_user_id=$payback_ID AND from_user_id=$cur_user_id";
	$bill_result = mysqli_query($conn, $bill_query);
	while($row = mysqli_fetch_array($bill_result, MYSQL_ASSOC)){
		$bill = intval($row['money_amount']);
		$person_bill_total = $person_bill_total + $bill;
	}

	
	$payback_query = "SELECT money_amount FROM Transactions WHERE from_user_id = $payback_ID AND to_user_id=$cur_user_id";
	$payback_result = mysqli_query($conn, $payback_query);
	while($row = mysqli_fetch_array($payback_result, MYSQL_ASSOC)){
		$payback = intval($row['money_amount']);

		$person_bill_total = $person_bill_total - $payback;
	}

	
	$name_query = "SELECT firstname FROM Users WHERE user_id = $payback_ID";
	$name_result = mysqli_query($conn, $name_query);
	$name = mysqli_fetch_array($name_result, MYSQL_ASSOC)['firstname'];
	if($person_bill_total<0){
	/*
			echo $name;
			echo "		";

			echo "$";
			echo strval(-$person_bill_total)."<br>";
	*/	
	}
	

?>
<!--Display the search results-->
<div class="container">
    <div class="jumbotron">
        <h1>Recommendations</h1>
        <p>You owe 
        <?php 
        echo $name;
        echo " ";
        echo "$";
        echo strval(-$person_bill_total);
        ?>
        </p>
        <!--<p>separate interests by ',' capped at $50 atm</p>-->
            
        <button class="panel-button" data-panelid="panel1">#panel 1</button>
        <button class="panel-button" data-panelid="panel2">#panel 2</button>
        <button class="panel-button" data-panelid="panel3">#panel 3</button>
        <button class="panel-button" data-panelid="panel4">#panel 4</button>
    </div>

    <form>
    <div class="form-group">
        <label for="search" class="col-sm-2 control-label">Interests</label>
        <div class="col-sm-10">
        <input type="text" class="form-control" id="searchInput" type="text" placeholder="Enter search item">
        </div>
        <select class="form-control">
            <option selected value="walmart">Walmart</option>
            <option value="meijer">Meijer</option>
        </select>
        <button class="search-button" data-panelid="searchEnter">Recommends</button>
        <button class="search-button" onclick="location.href = 'http://groupmate.web.engr.illinois.edu/main_page.php';">Back to main page</button>
        
    </div>
    
    </form>

    <div class="row">
        <div class="col-xs-3">
            <div id="panel1" class="panel panel-primary">
                <div class="panel-heading">
                    #panel1
                </div>
                <div class="panel-body">
                    content
                </div>
                <div class="panel-footer">
                    price
                </div>
            </div>
        </div>

        <div class="col-xs-3">
            <div id="panel2" class="panel panel-primary">
                <div class="panel-heading">
                    #panel2
                </div>
                <div class="panel-body">
                    content
                </div>
                <div class="panel-footer">
                    price
                </div>
            </div>
        </div>

        <div class="col-xs-3">
            <div id="panel3" class="panel panel-primary">
                <div class="panel-heading">
                    #panel3
                </div>
                <div class="panel-body">
                    content
                </div>
                <div class="panel-footer">
                    price
                </div>
            </div>
        </div>
        
        <div class="col-xs-3">
            <div id="panel4" class="panel panel-primary">
                <div class="panel-heading">
                    #panel4
                </div>
                <div class="panel-body">
                    content
                </div>
                <div class="panel-footer">
                    price
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    
<script>
    results = {}; // contains search results in hash table
    
    $(document).ready(function(){
        
        $('.panel-button').click(function(){
            var panelID = $(this).attr('data-panelid');
            $('#'+panelID).toggle();   
        });
        
        $('.search-button').click(function(){
            var stuff = $("#searchInput").val();
            var interests = stuff.split(',');
            console.log(interests);
            var concatedStuffs = interests[0];
            for (var j = 1; j < interests.length; j++) {
                interests[j] = interests[j].trim();
                concatedStuffs += (" OR " + interests[j]);
            }
            console.log(concatedStuffs); // checking out if method is working
            var store = $('.form-control').find("option:selected").text();
            $("#searchInput").append($('br')).append($('stuff'));         
            var priceCeiling = <?php echo json_encode(strval(-$person_bill_total)); ?>; 
            searchFor(concatedStuffs, priceCeiling);
            return false;
        });
        
        $('#searchInput').click(function() {
            this.value='';
        });
 
        // web-crawler attempt #3 - works using Walmart API
        function searchFor(someItem, price) {
            $.ajax({
                url: "http://api.walmartlabs.com/v1/search?"+
                     "apiKey=2ngydndmvt9ezwsh65xyeaws&format=json&numItems=25"+
                     "&query=" + someItem + "&facet=on&facet.range=price:[0 TO "+
                     price + "]&callback=?",
                dataType: "jsonp",
                success: function ( response ) {
                    console.log( response ); // checking server response
                    results[someItem] = [];
                    for (var i = 0; i < 25; i++) { // max numItems handled by API=25
                        var a = {"name": response.items[i].name, 
                                 "price": response.items[i].salePrice, 
                                 "productURL": response.items[i].productUrl, 
                                 "image": response.items[i].thumbnailImage };
                        results[someItem].push(a);
                        console.log(results[someItem][i]); // printing result
                    }
                    displayResultsInPanel(someItem);
                }
            });
        }
        
        function displayResultsInPanel(someItem) {
            var k = 1;
            for (var i = 0; i < 4; i++) {
                $('#panel'+k).children()[0].innerHTML = results[someItem][i]["name"];
                $('#panel'+k).children()[1].innerHTML = "<img src=\""+results[someItem][i]["image"]+"\">";
                $('#panel'+k).children()[2].innerHTML = "<center>$" + results[someItem][i]["price"];
                k++;
            }
        }
        
    }); // this is the end of script brackets
</script>


</body>
</html>