<?php 
require 'includes/connection.php'; ?>
<?php 
	if (isset($_POST['login'])) {
		$email = mysqli_real_escape_string($con, htmlentities($_POST['email']));
		$password = mysqli_real_escape_string($con, htmlentities($_POST['password']));

		$get_user = "SELECT * FROM `users` WHERE `user_email` = '$email' AND `user_password` = '$password' ";
		$get_user_run = mysqli_query($con, $get_user);
		$user_exists = mysqli_num_rows($get_user_run);

		if ($user_exists==1) {
			$_SESSION['email']=$email;
			echo "<script>window.open('home.php?id=".$user_id."', '_self')</script>";
		}else {
			echo "<script>alert('Something is terribly wrong')</script>";
		}
	}
?>