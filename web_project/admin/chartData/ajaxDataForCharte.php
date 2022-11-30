<?php
require("../../dbinfo.php");
$db = mysqli_connect('localhost', $usernameDB, $passwordDB, $database);
	if (!$db) {
		die('Not connected : ' . mysqli_error());
	}

	if (!mysqli_select_db($db, "web_proj")) {
	die ('Can\'t use db : ' . mysqli_error()); }


$query = "SELECT HOUR(from_unixtime(timestampMs))as hour, COUNT(*) FROM data GROUP BY 1;";
$result = mysqli_query($db, $query);
$data = array();
while ( $row = mysqli_fetch_array($result) ){ 
	
	$data[] = array($row['hour'],(int)$row['COUNT(*)']);
}

echo json_encode($data);

?>

