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
	 
	 $query = "SELECT activity_type, COUNT(*) FROM data WHERE id='$userID' AND YEAR(from_unixtime(timestampMs)) BETWEEN '$fromyear' AND '$toyear' AND MONTH(from_unixtime(timestampMs)) BETWEEN '$frommonth' AND '$tomonth'  AND activity_type != 'NULL' AND activity_type != 'STILL' AND activity_type != 'TILTING' GROUP BY activity_type;";
     $result = mysqli_query($db, $query);
     $data = array();
     while ( $row = mysqli_fetch_array($result) ){ 
	   $data[] = array($row['activity_type'],(int)$row['COUNT(*)']);
      }
	  
    echo json_encode($data);
?>