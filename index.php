<?php
$servername = "localhost";
$username = "root";
$password = "password";
$dbname = "NoteKnight";
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM notes";
$result = $conn->query($sql);

if (!$result) { 
	echo "Not result" . $result;
    trigger_error('Invalid query: ' . $conn->error);
}

$numberOfRows = $result->num_rows;
$keywords = array();
$descriptions = array();

if ($numberOfRows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
    	array_push($keywords,$row["keyword"]);
    	array_push($descriptions, $row["description"]);
       // echo $row["userid"]. $row["keyword"]. " " . $row["description"]. "<br>";  
    }} else {
    echo "0 results";
}

$keywordsJSON = json_encode($keywords);
$descriptionsJSON = json_encode($descriptions);

$conn->close();
?>

<html>
<head>
	<script src="js/jquery.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/index.css">
</head>

<script>

	$(document).ready(function(){

		function updateCard(UpdateCardNumber){
			console.log("updatecardNo: ", UpdateCardNumber);
			if (UpdateCardNumber > -1 && UpdateCardNumber <= maxCardNumber){
				cardNumber = UpdateCardNumber;
				$('#keyword').html(cardKeywords[cardNumber-1]);
				$('#description').html(cardDescriptions[cardNumber-1]);
				$('#cardCounter').html(UpdateCardNumber + "/" + maxCardNumber);
			} 
		}

		cardKeywords = <?php echo $keywordsJSON ?>; //grabs keywords from php and stores it in object
		cardDescriptions = <?php echo $descriptionsJSON ?>; // grabs descriptions from php and store it in object
		cardNumber = 1;
		maxCardNumber = "<?php echo $numberOfRows?>" // grabs how many cards there are 

		//first card on inital load
		updateCard(cardNumber)

		//changes to the next card in the object
		$("#nextBtn").click(function(){		
			if(cardNumber < maxCardNumber){
				updateCard(cardNumber+1);
			}	
		});

		//changes to the previous card in the object
		$("#backBtn").click(function(){	
			if(cardNumber > 1)	{
				updateCard(cardNumber-1);
			}	
		});

		var newKeyword = $('#newKeyword').val();
		var newDescription = $('#newDescription').val();
		// <?php 
		// 	$servername = "localhost";
		// 	$username = "root";
		// 	$password = "password";
		// 	$dbname = "NoteKnight";
		// 	// Create connection
		// 	$conn = new mysqli($servername, $username, $password, $dbname);
		// 	$addCardSql = "INSERT INTO notes (keyword, description) VALUES ('$newKeyword', '$newDescription')";
		// ?>

		//function flips the card
		var cardFlipped = false;
		$("#flipBtn").click(function(){
			if (cardFlipped == false){
				$('.flip-card-inner').css("transform", "rotateY(180deg)");
				cardFlipped = true;
			}
			else {
				$('.flip-card-inner').css("transform", "rotateY(360deg)");
				cardFlipped = false;
			}
		});

		$("#addCardBtn").click(function(){
			var newKeyword = $('#newKeyword').val();
			var newDescription = $('#newDescription').val();
			var newCardCookie = "keywordCookie=" + newKeyword; 
			document.cookie = "keywordCookie=" + newKeyword + "," + newDescription; 
		  	$('#myModal').modal('hide');
		  	var cookie = document.cookie;
			<?php
				$newCookie = $_COOKIE["keywordCookie"];
				$cookieArr = explode(',', $newCookie);
				$newKeyword = $cookieArr[0];
				$newDescription = $cookieArr[1];
			?>;
			var check = "<?php echo $newKeyword ?>";
			<?php 
				$servername = "localhost";
				$username = "root";
				$password = "password";
				$dbname = "NoteKnight";
				// Create connection
				$conn = new mysqli($servername, $username, $password, $dbname);
				$sql = "INSERT INTO notes (keyword, description) VALUES ('$newKeyword', '$newDescription')";
				$conn->query($sql);
			?>
		});


		
	});	
</script>

<body>
	<div style="margin-top:100px">
		<div class="flip-card" style="margin:auto">
			<div id="cardCounter" style="display: flex; justify-content: center"></div>
		  	<div class="flip-card-inner" id="flipCard">
		    	<div class="flip-card-front">
		      		<h1 class="cardText" id="keyword"></h1>
		      		<div class="cardLabel">Keyword</div>
		      	</div>
		
		    	<div class="flip-card-back">
		      		<h2 class="cardText" id="description"></h2>
		      		<span class="cardlabel">Description</span>
		   		</div>
		  	</div>
		  	<div class="row" style="margin-top: 25px">
			  	<div style="float:left">
			  		<button id="backBtn">Back</button>
			  	</div>
			  	<div style="margin: auto;width: fit-content">
			  		<button id="flipBtn">Flip</button>
			  	</div>
			  	<div style="float:right">
			  		<button id="nextBtn">Next</button>
			  	</div>			  	
			 </div>

			 <div class="newCard"> 
			  		<button class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal" id='newCardBtn'>New Card<img src='img/plus.png' style='height:30px;'></img></button>
			 </div>
		</div>
	</div>

	<div class="container">

  <!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Add a new card</h4>
        </div>
        <div class="modal-body">
        	<div class="row">
        		<label>Keyword</label>
        		<input id="newKeyword"/>
        	</div>
        	<div class="row">
        		<label>Description</label>
        		<input id="newDescription"/>
        	</div>
        	<div>
        		<button id="addCardBtn">Add Card</button>
        	</div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Discard Changes</button>
        </div>
      </div>
      
    </div>
  </div>
  
</div>

</body>
</html>