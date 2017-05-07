<?php
	session_start();
	include '../includes/connection.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Admin Login</title>
	<link rel="stylesheet" href="../css/bootstrap.min.css">
	<link rel="stylesheet" href="admin.style.css">
</head>
<body>
	<div class="container">
      <form class="form-signin" action="" method="post">
        <h2 class="form-signin-heading">NetMate Admin</h2>

        <label for="inputEmail" class="sr-only">Email address</label>
        <input name="email" type="email" id="inputEmail" class="form-control" placeholder="Email address" required autofocus>

        <label for="inputPassword" class="sr-only">Password</label>
        <input name="password" type="password" id="inputPassword" class="form-control" placeholder="Password" required>

        <input name="submit" class="btn btn-lg btn-primary btn-block" type="submit" value="Log in">
      </form>
    </div> <!-- /container -->
    <?php
    	if (isset($_POST['submit'])) {
    		$email = mysqli_real_escape_string($con, $_POST['email']);
    		$password =mysqli_real_escape_string($con, $_POST['password']);

    		$get_admin = "SELECT * FROM `admins` WHERE `admin_email` = '$email' AND `admin_password` = '$password' ";
    		$get_admin_run = mysqli_query($con, $get_admin);

    		$check_if_there = mysqli_num_rows($get_admin_run);

    		if ($check_if_there==0) {
    			echo "<script>alert('Email or password is not correct.')</script>";
    		}else{
    			$_SESSION['admin_email'] = $email;
    			echo "<script>window.open('index.php', '_self')</script>";
    		}
    	}
    ?>
</body>
</html>