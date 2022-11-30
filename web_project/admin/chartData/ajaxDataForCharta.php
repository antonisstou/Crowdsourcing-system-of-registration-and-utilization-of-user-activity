 <?php
require("../../dbinfo.php");
$db = mysqli_connect('localhost', $usernameDB, $passwordDB, $database);
	if (!$db) {
		die('Not connected : ' . mysqli_error());
	}

	if (!mysqli_select_db($db, "web_proj")) {
	die ('Can\'t use db : ' . mysqli_error()); }

$query = "SELECT activity_type, COUNT(*) FROM data WHERE activity_type != 'NULL' AND activity_type != 'STILL' AND activity_type != 'TILTING' GROUP BY activity_type;";
$result = mysqli_query($db, $query);
$data = array();
while ( $row = mysqli_fetch_array($result) ){ 
	
	$data[] = array($row['activity_type'],(int)$row['COUNT(*)']);
}

echo json_encode($data);

?>

