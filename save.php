<?php
	include 'databaseInfo.php';

	$setID =$_POST['setID'];
	$noteID = $_POST['noteID'];
	$keyword=$_POST['keyword'];
	$description=$_POST['description'];
	$sql = "INSERT INTO notes (setID, noteID, keyword, description) VALUES ('$setID','$noteID', '$keyword', '$description')";;
	if (mysqli_query($conn, $sql)) {
		echo json_encode(array("statusCode"=>200));
	} 
	else {
		echo json_encode(array("statusCode"=>201));
	}
	mysqli_close($conn);
?>