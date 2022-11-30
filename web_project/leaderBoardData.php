<?php
require("dbinfo.php");
$db = mysqli_connect('localhost', $usernameDB, $passwordDB, $database);

	if (!$db) {
		die('Not connected : ' . mysqli_error());
	}

	if (!mysqli_select_db($db, "web_proj")) {
	die ('Can\'t use db : ' . mysqli_error()); }

mysqli_set_charset( $db, 'utf8');

//TREXON MHNAS
//$currentMonth = date("m");
//$query = "SELECT u.name, u.lastname, COUNT(d.id) FROM users u INNER JOIN data d ON (d.id = u.id) WHERE activity_type NOT LIKE 'IN%' AND activity_type NOT IN ('NULL', 'STILL', 'TILTING') AND MONTH(from_unixtime(timestampMs)) = '$currentMonth' GROUP BY u.id ORDER BY 3 ASC;";
$query = "SELECT u.name, u.lastname, COUNT(d.id) FROM users u INNER JOIN data d ON (d.id = u.id) WHERE activity_type NOT LIKE 'IN%' AND activity_type NOT IN ('NULL', 'STILL', 'TILTING') AND MONTH(from_unixtime(timestampMs)) = 12 GROUP BY u.id ORDER BY 3 ASC;";
$result = mysqli_query($db, $query);

$datab = array();
while ( $row = mysqli_fetch_array($result) ){ 
	$datab[] = array($row['name'], $row['lastname'], (int)$row['COUNT(d.id)']);
}

echo json_encode($datab, JSON_UNESCAPED_UNICODE );

?>