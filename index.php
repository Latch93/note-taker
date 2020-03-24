<?php
$servername = "localhost";
$username = "root";
$password = "password";
$dbname = "note-taker";
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT userid, keyword, description FROM notes";
$result = $conn->query($sql);

if (!$result) {
    trigger_error('Invalid query: ' . $conn->error);
}
$counter = 0;
$arr = [];
$myObj = new stdClass();
if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        
        $myObj->userid = $row["userid"];
		$myObj->keyword = $row["keyword"];
		$myObj->description = $row["description"];

		$myJSON = json_encode($myObj);
		array_push($arr,$myJSON);
    }
} else {
    echo "0 results";
}
$arrLength = count($arr);
for($i = 1; $i < $arrLength; $i++){
	$toppings = json_decode($arr[$i], true);
	echo $toppings['userid'];
	echo $toppings['keyword'];
	echo $toppings['description'];
	$userid = $toppings['userid'];
	$keyword = rtrim($toppings['keyword']);
	$description = rtrim($toppings['description']);
};

$conn->close();
?>

<html>
<head>
	<script src="js/jquery.js"></script>
	<script src="js/jquery.flip.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/styles.css">
</head>
<script>
	$(document).ready(function(){
		var keyword = "<?php echo $keyword ?>";
		var description = "<?php echo $description ?>";
		$('#keyword').append(keyword);
		$('#description').append(description);
	});
</script>
<body>
	<div class="flip-card">
	  <div class="flip-card-inner">
	    <div class="flip-card-front">
	      <h1 id="keyword"></h1>
	    </div>
	    <div class="flip-card-back">
	      <h2 id="description"></h2>
	    </div>
	  </div>
	</div>
</body>
</html>