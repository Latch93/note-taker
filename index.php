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
			console.log(UpdateCardNumber)
			if (UpdateCardNumber > -1 && UpdateCardNumber <= maxCardNumber - 1){
			cardNumber = UpdateCardNumber
			$('#keyword').html(cardKeywords[cardNumber]);
			$('#description').html(cardDescriptions[cardNumber]);
		} 


	}

		cardKeywords = <?php echo $keywordsJSON ?>; //grabs keywords from php and stores it in object
		cardDescriptions = <?php echo $descriptionsJSON ?>; // grabs descriptions from php and store it in object
		cardNumber = 0 
		maxCardNumber = "<?php echo $numberOfRows?>" // grabs how many cards there are 

		//first card on inital load
		updateCard(cardNumber)

		//changes to the next card in the object
		$("#nextBtn").click(function(){			
			updateCard(cardNumber+1);
		});

		//changes to the previous card in the object
		$("#backBtn").click(function(){			
			updateCard(cardNumber-1);
		});

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

		//does not work
		/*$("#newCard").click(function(){
			$('#keyword').html('<form action="insert.php" method="post"><input type="text" name="keyword" id="keywordInput"></form>');

			
		});

		<button id='newCard'>New Card <img src='img/plus.png'></img></button> */


		
	});	
	function newCard(){
			
		}
</script>

<body>
	<div style="margin-top:100px">
		<div class="flip-card" style="margin:auto">
		  	<div class="flip-card-inner" id="flipCard">
		    	<div class="flip-card-front">
		      		<h1 class="cardText" id="keyword"></h1>
		      	</div>
		
		    	<div class="flip-card-back">
		      		<h2 class="cardText" id="description"></h2>
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
			  		<button id='new'>New Card<img src='img/plus.png' style='height:30px;'></img></button>
			 </div>
		</div>
	</div>

	<form action="newCard.php" method="post">	
		<input type="text" name="keyword" id="keywordInput"> 
		<input type="text" name="description" id="descriptionInput"> 
		<input type="submit" value="Submit">
	</form>


</body>
</html>