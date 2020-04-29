<?php
include 'databaseInfo.php';
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
    }
} 

$numberOfRows = json_encode($numberOfRows);
$keywordsJSON = json_encode($keywords);
$descriptionsJSON = json_encode($descriptions);

$conn->close();
?>