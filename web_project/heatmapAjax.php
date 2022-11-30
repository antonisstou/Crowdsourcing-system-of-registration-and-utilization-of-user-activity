<?php
    require("dbinfo.php");
    session_start();
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
     $userID = $_SESSION['user']['id'];	
	 
     $query = "SELECT latitudeE7,longitudeE7 FROM data WHERE id='$userID' AND YEAR(FROM_UNIXTIME(timestampMs)) BETWEEN '$fromyear' AND '$toyear' AND MONTH(FROM_UNIXTIME(timestampMs)) BETWEEN '$frommonth' AND '$tomonth' ";
     $result = mysqli_query($db, $query);
     $data = array();
     while ( $row = mysqli_fetch_assoc($result) ){ 
          $data[]= $row;
     }
     echo json_encode($data);
?>