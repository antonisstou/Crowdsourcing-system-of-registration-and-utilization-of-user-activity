<?php
require("../dbinfo.php");
$db = mysqli_connect('localhost', $usernameDB, $passwordDB, $database);
	if (!$db) {
		die('Not connected : ' . mysqli_error());
	}

	if (!mysqli_select_db($db, "web_proj")) {
     die ('Can\'t use db : ' . mysqli_error()); }
     
if (isset($_POST['FromYear']) && isset($_POST['ToYear']) && isset($_POST['FromMonth']) && isset($_POST['ToMonth']) && isset($_POST['Days']) && isset($_POST['FromTime']) && isset($_POST['ToTime']) && isset($_POST['Activities'])) {
     session_start();
     $fromyear = $_POST['FromYear'];
     $toyear = $_POST['ToYear'];
     $frommonth = $_POST['FromMonth'];
     $tomonth = $_POST['ToMonth'];
     $fromtime = $_POST['FromTime'];
     $totime = $_POST['ToTime'];
     $activities = implode("','",$_POST['Activities']);
     $days = implode("','",$_POST['Days']);
    
     $_SESSION['fromyear'] = $fromyear;
     $_SESSION['toyear'] = $toyear;
     $_SESSION['frommonth'] = $frommonth;
     $_SESSION['tomonth'] = $tomonth;
     $_SESSION['fromtime'] = $fromtime;
     $_SESSION['totime'] = $totime;
     $_SESSION['activities'] = $activities;
     $_SESSION['days'] = $days;

     header("location: heatmap.php");
}

?>

