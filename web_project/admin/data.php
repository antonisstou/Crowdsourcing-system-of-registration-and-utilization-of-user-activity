<?php
require("ajaxDataMap.php");
session_start();
require("../dbinfo.php");
$db = mysqli_connect('localhost', $usernameDB, $passwordDB, $database);
	if (!$db) {
		die('Not connected : ' . mysqli_error());
	}

	if (!mysqli_select_db($db, "web_proj")) {
     die ('Can\'t use db : ' . mysqli_error()); }
     
    
     $fromyear = $_SESSION['fromyear'];
     $toyear = $_SESSION['toyear'];
     $frommonth = $_SESSION['frommonth'];
     $tomonth = $_SESSION['tomonth'];
     $fromtime = $_SESSION['fromtime'];
     $totime = $_SESSION['totime'];
     $activities = $_SESSION['activities'];
     $days = $_SESSION['days'];


    
     $query = "SELECT latitudeE7,longitudeE7 FROM data WHERE YEAR(from_unixtime(timestampMs)) BETWEEN $fromyear AND $toyear AND MONTH(from_unixtime(timestampMs)) BETWEEN $frommonth AND $tomonth AND DAYNAME(from_unixtime(timestampMs)) IN ('".$days."') AND TIME(from_unixtime(timestampMs)) BETWEEN '$fromtime' AND '$totime' AND activity_type IN ('".$activities."')";
     $result = mysqli_query($db, $query);
     $data = array();
     while ( $row = mysqli_fetch_assoc($result) ){ 
          $data[] = $row;
     }
     echo json_encode($data);

?>

