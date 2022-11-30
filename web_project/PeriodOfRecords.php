<?php
  session_start();
  require("dbinfo.php");
	$db = mysqli_connect('localhost', $usernameDB, $passwordDB, $database);
	if (!$db) {
		die('Not connected : ' . mysqli_error());
	}

	if (!mysqli_select_db($db, $database)) {
		die ('Can\'t use db : ' . mysqli_error());
	}

$userID = $_SESSION['user']['id'];	
$data = array();
$query = "SELECT FROM_UNIXTIME(timestampMs,'%d %M %Y') FROM data WHERE id='$userID' ORDER BY FROM_UNIXTIME(timestampMs) ASC LIMIT 1";
$result1 = mysqli_query($db, $query);
while ( $row = mysqli_fetch_array($result1) )
{   array_push($data,$row); }

$query = "SELECT FROM_UNIXTIME(timestampMs,'%d %M %Y') FROM data WHERE id='$userID' ORDER BY FROM_UNIXTIME(timestampMs)  DESC LIMIT 1";
$result2 = mysqli_query($db, $query);
while ( $row = mysqli_fetch_array($result2) )
{   array_push($data,$row); }

echo json_encode($data);


?>