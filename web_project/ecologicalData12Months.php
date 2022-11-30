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
$currentMonth = date("m");
$currentYear = date("Y");
$firstDayOfCurrentMonth = $currentYear."-".$currentMonth."-"."01"." "."00:00:00";


$query = "SELECT MONTHNAME(FROM_UNIXTIME(timestampMs)),YEAR(FROM_UNIXTIME(timestampMs)), COUNT(*) FROM data WHERE id='$userID' AND FROM_UNIXTIME(timestampMs) >= DATE_SUB('$firstDayOfCurrentMonth', INTERVAL 12 MONTH) AND activity_type != 'NULL' AND activity_type != 'STILL' AND activity_type != 'TILTING' AND
          activity_type!='IN_VEHICLE' AND activity_type!='IN_CAR' AND activity_type!='IN_RAIL_VEHICLE' AND activity_type!='IN_ROAD_VEHICLE' AND activity_type!='EXITING_VEHICLE' GROUP BY MONTHNAME(FROM_UNIXTIME(timestampMs)),YEAR(FROM_UNIXTIME(timestampMs))";
$result = mysqli_query($db, $query);
$data1 = array();
while ( $row = mysqli_fetch_array($result) ){ 
	$data1[] = array('month' => $row['MONTHNAME(FROM_UNIXTIME(timestampMs))'],'year' => $row['YEAR(FROM_UNIXTIME(timestampMs))'],'records' => (int)$row['COUNT(*)']);
}


$query = "SELECT MONTHNAME(FROM_UNIXTIME(timestampMs)),YEAR(FROM_UNIXTIME(timestampMs)), COUNT(*) FROM data WHERE id='$userID' AND FROM_UNIXTIME(timestampMs) >= DATE_SUB('$firstDayOfCurrentMonth', INTERVAL 12 MONTH) AND activity_type != 'NULL' AND activity_type != 'STILL' AND activity_type != 'TILTING' AND (activity_type='IN_VEHICLE' 
           OR activity_type='IN_CAR' OR activity_type='IN_RAIL_VEHICLE' OR activity_type='IN_ROAD_VEHICLE' OR activity_type='EXITING_VEHICLE') GROUP BY MONTHNAME(FROM_UNIXTIME(timestampMs)),YEAR(FROM_UNIXTIME(timestampMs))";
$result = mysqli_query($db, $query);
$data2 = array();
while ( $row = mysqli_fetch_array($result) ){ 
	$data2[] = array('month' => $row['MONTHNAME(FROM_UNIXTIME(timestampMs))'],'year' => $row['YEAR(FROM_UNIXTIME(timestampMs))'],'records' => (int)$row['COUNT(*)']) ;
}

$date3 =array();
foreach ($data1 as $row1) {
	foreach ($data2 as $row2)
    { if ($row1['month']== $row2['month'] && $row1['year']== $row2['year'] )
        {   $per= $row1['records']/ ($row1['records'] + $row2['records']); 
            $percentage = round((float)$per,2);
	        $data3[] = array('month' => $row1['month'],'year' => $row1['year'] ,'percentage' => $percentage ) ;  }
	}
}

echo json_encode($data3);

?>