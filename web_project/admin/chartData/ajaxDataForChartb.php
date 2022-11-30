<?php
require("../../dbinfo.php");
$db = mysqli_connect('localhost', $usernameDB, $passwordDB, $database);
	if (!$db) {
		die('Not connected : ' . mysqli_error());
	}

	if (!mysqli_select_db($db, "web_proj")) {
	die ('Can\'t use db : ' . mysqli_error()); }

mysqli_set_charset( $db, 'utf8');



$query = "SELECT u.name, u.lastname, COUNT(d.id) FROM users u INNER JOIN data d ON (d.id = u.id) GROUP BY u.id;";
$result = mysqli_query($db, $query);
$datab = array();
while ( $row = mysqli_fetch_array($result) ){ 
	
	$datab[] = array($row['name'], $row['lastname'], (int)$row['COUNT(d.id)']);
}

echo json_encode($datab, JSON_UNESCAPED_UNICODE );

?>

