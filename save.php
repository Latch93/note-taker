<?php
	include 'databaseInfo.php';
	$keyword=$_POST['keyword'];
	$description=$_POST['description'];
	$sql = "INSERT INTO notes (keyword, description) VALUES ('$keyword', '$description')";;
	if (mysqli_query($conn, $sql)) {
		echo json_encode(array("statusCode"=>200));
	} 
	else {
		echo json_encode(array("statusCode"=>201));
	}
	mysqli_close($conn);
?>