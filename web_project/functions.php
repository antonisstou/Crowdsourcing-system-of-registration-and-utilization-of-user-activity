<?php
	require("dbinfo.php");

	session_start();
	$db = mysqli_connect('localhost', $usernameDB, $passwordDB, $database);
	if (!$db) {
		die('Not connected : ' . mysqli_error());
	}

	if (!mysqli_select_db($db, $database)) {
		die ('Can\'t use db : ' . mysqli_error());
	}

	mysqli_set_charset( $db, 'utf8');

	$username = "";
	$email = "";
	$errors = array();


	if (isset($_POST['register_btn'])) {
		register();
	}

	if (isset($_POST['login_btn'])) {
		login();
	}

	if (isset($_FILES['filename'])) {
		//echo $_FILES['filename']["name"];
		load();
		//header("location: home.php");
	}

	if (isset($_GET['logout'])) {
		session_destroy();
		unset($_SESSION['user']);
		header("location: ../login.php");
	}

	if (isset($_POST['deleteDB_btn'])) {
		deletedb();
	}

	if (isset($_POST['chart_btn'])) {
		header("location: charts.htm");
	}

	if (isset($_POST['onmap_btn'])) {
		header("location: dataONmap.php");
	}

	if (isset($_POST['extract_btn'])) {
		header("location: data4.php");
	}


	function deletedb(){
		global $db;
		$queryd = "DELETE FROM data";
		mysqli_query($db, $queryd);
	}

	function register(){
		global $db, $errors;

		$username = e($_POST['username']);
		$email = e($_POST['email']);
		$password_1 = e($_POST['password_1']);
		$password_2 = e($_POST['password_2']);
		$sname = e($_POST['sname']);
		$lname = e($_POST['lname']);

		if (empty($username)) { 
			array_push($errors, "Το Username απαιτείται"); 
		}
		if (empty($email)) { 
			array_push($errors, "Το Email απαιτείται"); 
		}
		if (empty($password_1)) { 
			array_push($errors, "Το Password απαιτείται"); 
		}
		if ($password_1 != $password_2) {
			array_push($errors, "Τα δυο passwords δεν ταιριάζουν");
		}
		if (empty($sname)) { 
			array_push($errors, "Το όνομα απαιτείται"); 
		}
		if (empty($lname)) { 
			array_push($errors, "Το επώνυμο απαιτείται"); 
		}

		

		if (count($errors) == 0) {

			$password = md5($password_1);

			$id = openssl_encrypt($email, "AES-128-ECB", $password_1);

			$query = "INSERT INTO users (id, username, email, user_type, password, name, lastname) 
			VALUES('$id','$username', '$email', 'user', '$password','$sname','$lname')";

			if (mysqli_query($db, $query)) {
				//echo "New record created successfully";
			}
			else {
				echo "Error: " . $query . "<br>" . mysqli_error($db);
   			}

			$logged_in_user_id = mysqli_insert_id($db);
			echo print_r(getUserById($logged_in_user_id));

			$_SESSION['user'] = getUserById($logged_in_user_id);
			$_SESSION['success']  = "Είστε συνδεδεμένος";
			header('location: home.php');
		}
	}

	function getUserById($id){
		global $db;
		$query = "SELECT * FROM users WHERE id=" . $id;
		$result = mysqli_query($db, $query);

		$user = mysqli_fetch_assoc($result);
		return $user;
	}


	function login(){
		global $db, $username, $errors;

		$username = e($_POST['username']);
		$password = e($_POST['password']);

		
		if (empty($username)) {
			array_push($errors, "Το Username απαιτείται");
		}
		if (empty($password)) {
			array_push($errors, "Το Password απαιτείται");
		}


		if (count($errors) == 0) {
			$password = md5($password);

			$query = "SELECT * FROM users WHERE username='$username' AND password='$password' LIMIT 1";
			$results = mysqli_query($db, $query);
			

			

			if (mysqli_num_rows($results) == 1) {
				$logged_in_user = mysqli_fetch_assoc($results);
				if ($logged_in_user['user_type'] == 'admin') {

					$_SESSION['user'] = $logged_in_user;
					$_SESSION['success']  = "Είστε συνδεδεμένος";
					header('location: admin/home.php');
					//echo "ok";		  
				}else{
					$_SESSION['user'] = $logged_in_user;
					$_SESSION['success']  = "Είστε συνδεδεμένος";

					header('location: home.php');
				}
			}else {
				array_push($errors, "Λανθασμένος συνδιασμός username/password");
			}
		}
	}

	function isLoggedIn()
	{
		if (isset($_SESSION['user'])) {
			return true;
		}
		else{
			return false;
		}
	}

	function isAdmin(){
		if (isset($_SESSION['user']) && $_SESSION['user']['user_type']  == 'admin'){
			return true;
		}
		else{
			return false;
		}
	}

	function e($val){
		global $db;
		return mysqli_real_escape_string($db, trim($val));
	}

	function display_error() {
		global $errors;

		if (count($errors) > 0){
			echo '<div class="error">';
				foreach ($errors as $error){
					echo $error .'<br>';
				}
			echo '</div>';
		}
	}

	function load() {
		global $db;

		$myfile = $_FILES['filename']["name"];
		$jsonobj = file_get_contents($myfile);

		$json_a = json_decode($jsonobj, true);
		

		$user_id = $_SESSION['user']['id'];	
		
		$max_conf = 0;
		$tmp_type = "NULL";
		
		
		foreach($json_a['locations'] as $x) { 
			if (distance(38.230462,21.753150,$x['latitudeE7']/10**7,$x['longitudeE7']/10**7) > 10){
				continue;
			}
			if (inShape(str_pad($x['latitudeE7'],14,"0"), str_pad($x['longitudeE7'],14,"0"))){
				continue;
			}
			if (array_key_exists("activity", $x)){
				foreach($x['activity'] as $y){
					
					$tmp_conf = 0;
					$max_conf = 0;
					foreach($y['activity'] as $z){
						if ($z['type'] != "UNKNOWN"){
							if ($max_conf <= $z['confidence']){
								$max_conf = $z['confidence'];
								$tmp_type = $z['type'];
								$tmp_conf = $z['confidence'];
							}
						    
						}
					}
					
				}
				
			}
			$tmptime = round($x['timestampMs'],-3)/1000;
			$tmplat = $x['latitudeE7']/10**7;
			$tmplong = $x['longitudeE7']/10**7;
			$query1 = "INSERT INTO data (id, timestampMs, latitudeE7, longitudeE7, activity_type) 
			VALUES('$user_id','$tmptime', '$tmplat','$tmplong','$tmp_type')";
			if (mysqli_query($db, $query1)) {
				//echo "New record created successfully";
			}
			else {
				echo "Error: " . $query1 . "<br>" . mysqli_error($db);
			}
			$tmp_type = "NULL";
			
		}
		
	    	$query2 = "SELECT * FROM upload WHERE id = '$user_id'";
        	$result2 = mysqli_query($db, $query2);
		if (mysqli_num_rows($result2) != 0)
			{
				$query3 = "UPDATE upload SET last_upload= CURRENT_DATE() WHERE id= '$user_id'";					
			}
		else	
		   {
			$query3 = "INSERT INTO upload (id, last_upload) VALUES('$user_id',CURRENT_DATE())";	
		   }
		   if (mysqli_query($db, $query3)) {
				//echo "New record created successfully";
			   }
			  else {
				   echo "Error: " . $query1 . "<br>" . mysqli_error($db);
			   }
	  	header('location: userPage.html');				
		
	}

	function distance($lat1, $lon1, $lat2, $lon2) {
		if (($lat1 == $lat2) && ($lon1 == $lon2)) {
			return 0;
		}
		else {
			$theta = $lon1 - $lon2;
			$dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
			$dist = acos($dist);
			$dist = rad2deg($dist);
			$km = $dist * 60 * 1.1515 * 1.609344;
			   
		    return ($km);
		}
	}
	function inShape($lat, $lon){
		if (isset($_POST['custId'])){
			
			$songData = $_POST['custId'];
		
			$songData =json_decode($songData, true); 
			
			if(empty($songData)){
				 
				return false;
			} 
			
		
			$minlat = str_replace('.','',min( $songData[0][0]["lat"], $songData[0][1]["lat"]));
			$maxlat = str_replace('.','',max( $songData[0][0]["lat"], $songData[0][1]["lat"]));
			$minlng = str_replace('.','',min( $songData[0][0]["lng"], $songData[0][3]["lng"]));
			$maxlng = str_replace('.','',max( $songData[0][0]["lng"], $songData[0][3]["lng"]));
		
			if (($lat > $minlat && $lat < $maxlat) && ($lon > $minlng && $lon < $maxlng)){
				
				return true;
			}
			else{
				
				return false;
			}
		
		}
	}

?>
