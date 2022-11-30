<?php 
   require("dbinfo.php");
   $db =mysqli_connect('localhost', $usernameDB, $passwordDB, $database);
	if (!$db) {
		die('Not connected : ' . mysqli_error());
	}

	if (!mysqli_select_db($db, "web_proj")) {
     die ('Can\'t use db : ' . mysqli_error()); }
     
if (isset($_POST['SelectCriteria_btn'])) {
     session_start();
     $fromyear = $_POST['FromYear'];
     $toyear = $_POST['ToYear'];
     $frommonth = $_POST['FromMonth'];
     $tomonth = $_POST['ToMonth'];
    
     $_SESSION['fromyear'] = $fromyear;
     $_SESSION['toyear'] = $toyear;
     $_SESSION['frommonth'] = $frommonth;
     $_SESSION['tomonth'] = $tomonth; 
	 
     header("location: heatmapChartsPage.html");
}	 
?>