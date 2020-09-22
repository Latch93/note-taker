<?php
include 'databaseInfo.php';
// Check connection

$setID =$_POST['setID'];

$sql = "SELECT * FROM notes WHERE setID = " .$setID;
$result = mysqli_query($con,$sql);

$cards = array();

    // output data of each row
    while( $row = mysql_fetch_array($result) ){
    	$cardKeyword = $row['keyword'];
    	$cardDescription = $row['description'];

    	$cards[] = array("cardKeyword" => $cardKeyword, "cardDescription" => $cardDescription);
    }

echo json_encode($cards);
