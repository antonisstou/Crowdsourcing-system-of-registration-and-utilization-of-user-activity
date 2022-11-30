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
$query = "SELECT last_upload FROM upload WHERE id='$userID'";
$result = mysqli_query($db, $query);
while ( $row = mysqli_fetch_array($result) )
{   array_push($data,$row); }

echo json_encode($data);


?>