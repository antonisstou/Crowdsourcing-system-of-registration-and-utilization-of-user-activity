<?php include('functions.php') ?>
<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login page</title>
     <link rel="stylesheet" type="text/css" href="style.css">
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<body;>

<ul class="topnav">
     <li><a href="index.php"><img src="images/home.png" alt="Home logo">Home</a></li>
     <li><a class="active" href="login.php"><img src="images/user-18.ico" alt="User logo">Login</a></li>
     <li><a href="register.php"><img src="images/add-user-18.ico" alt="Add user logo">Sign up</a></li>
     <li class="right"><a href="#about">About</a></li>
</ul>

<form method="post" action="login.php">

     <?php echo display_error(); ?>

     <div class="formdiv">
          <label>Username</label>
          <input type="text" name="username" >
     </div>
     <div class="formdiv">
          <label>Password</label>
          <input type="password" name="password">
     </div>
     <div class="formdiv">
          <button type="submit" class="btn" name="login_btn">Login</button>
     </div>
</form>

<div class="centerBlack">
     <a name="about"></a>
     <h2>ABOUT</h2>
     <h4>Εργασηριακή άσκηση 2019-2020</h4>
     <h4>Αντώνιος Στουρνάρας, ΑΜ: 1051950</h4>
     <h4>Κωνσταντίνα Κορκοτσέλου, ΑΜ: 1047145</h4>
</div>

</body>
</html>
