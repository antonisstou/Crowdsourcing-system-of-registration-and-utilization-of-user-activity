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
date_default_timezone_set("Europe/Athens");	

//Τα σχόλια αναφέρονται στον τρέχον μήνα
$currentMonth = '12';//date("m");
$currentYear = '2019';//date("Y");

$query = "SELECT * FROM data WHERE id='$userID' AND MONTH(FROM_UNIXTIME(timestampMs))= '$currentMonth' AND YEAR(FROM_UNIXTIME(timestampMs))= '$currentYear' AND activity_type != 'NULL' AND activity_type != 'STILL' AND activity_type != 'TILTING' AND
    activity_type!='IN_VEHICLE' AND activity_type!='IN_CAR' AND activity_type!='IN_RAIL_VEHICLE' AND activity_type!='IN_ROAD_VEHICLE' AND activity_type!='EXITING_VEHICLE' ";
$result = mysqli_query($db, $query);
$ecologic = mysqli_num_rows($result);


$query = "SELECT * FROM data WHERE id='$userID' AND MONTH(FROM_UNIXTIME(timestampMs))= '$currentMonth' AND YEAR(FROM_UNIXTIME(timestampMs))= '$currentYear' AND activity_type != 'NULL' AND activity_type != 'STILL' AND activity_type != 'TILTING' AND (activity_type='IN_VEHICLE' 
           OR activity_type='IN_CAR' OR activity_type='IN_RAIL_VEHICLE' OR activity_type='IN_ROAD_VEHICLE' OR activity_type='EXITING_VEHICLE')";
$result = mysqli_query($db, $query);
$in_vehicle = mysqli_num_rows($result);



if ($in_vehicle == 0 && $ecologic != 0)
{ $percentage = '100 %'; }
elseif ($in_vehicle != 0 && $ecologic == 0)
{ $percentage = '0 %';}
elseif($in_vehicle == 0 && $ecologic == 0)
{ $percentage = "no"; }
else 
{  $per= $ecologic/ ($in_vehicle + $ecologic); 
   $percentage = round((float)$per * 100 ) . ' %';
 }
 
echo $percentage;

?>