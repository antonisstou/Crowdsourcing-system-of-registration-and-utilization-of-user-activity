<?php 
	include('functions.php');

	if (!isLoggedIn()) {
		$_SESSION['msg'] = "Πρέπει να συνδεθείς πρώτα";
		header('location: login.php');
	}

?>
<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>User - Home Page</title>
     <link rel="stylesheet" type="text/css" href="style.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>

<ul class="topnav">
	<li><a href="index.php?logout='1'" style="color: red;">Logout</a></li>
	<li><a href="userPage.html">My Page</a></li>
	<li><a href="shapemap.php">Upload data</a></li>
	<li class="right"><a href="#about">About</a></li>
</ul>


</div>
	<div class="content">
		<?php if (isset($_SESSION['success'])) : ?>
			<div class="error success" >
				<h4>
					<?php 
						echo $_SESSION['success']; 
						unset($_SESSION['success']);
					?>
				</h4>
			</div>
		<?php endif ?>
	</div>
</div>



<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>


<div class="centerBlack">
     <a name="about"></a>
     <h2>ABOUT</h2>
     <h4>Εργασηριακή άσκηση 2019-2020</h4>
     <h4>Αντώνιος Στουρνάρας, ΑΜ: 1051950</h4>
     <h4>Κωνσταντίνα Κορκοτσέλου, ΑΜ: 1047145</h4>
</div>

</body>
</html>
