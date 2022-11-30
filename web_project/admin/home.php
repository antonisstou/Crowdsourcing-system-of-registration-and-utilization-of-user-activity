<?php 
	include('../functions.php');

	if (!isAdmin()) {
		$_SESSION['msg'] = "Πρέπει να συνδεθείτε πρώτα";
		header('location: ../login.php');
	}

?>
<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin - Home Page</title>
	<link rel="stylesheet" type="text/css" href="../style.css">
	<link rel="stylesheet" type="text/css" href="../style1.css">
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<body>

<ul class="topnav">
	<li><a href="../index.php?logout='1'" style="color: red;">Logout</a></li>
</ul>


<form method="post" action="home.php">
	<div class="btn-group">
  		<button class="buttonG" name="chart_btn">Απεικόνιση κατάστασης ΒΔ </button>
  		<button class="buttonG" name="onmap_btn">Απεικόνιση στοιχείων σε χάρτη</button>
  		<button class="buttonG" name="deleteDB_btn" onclick="return confirm('Σίγουρα θέλετε να διαγράψετε τη ΒΔ?')">Διαγραφή δεδομένων ΒΔ</button>
		<button class="buttonG" name="extract_btn" <?php if (!isset($_SESSION['fromyear'])){ ?>style="opacity:0.5" disabled <?php  } ?>>Εξαγωγή δεδομένων</button>
	</div>
</form>

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

<script>
	function confirmation(){
		var result = confirm("Are you sure to delete?");
    		if(result){

    		}
}
</script>



</body>
</html>
