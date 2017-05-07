<?php require 'connection.php'; ?>
<?php
	if (isset($_POST['signup'])) {
			$result = "<div class='alert alert-success'><strong>Congrats!.</strong>You successfully registered in NetMate.com</div>";
			$firstName = mysqli_real_escape_string ($con, htmlentities($_POST['firstName']));
			$lastName = mysqli_real_escape_string($con, htmlentities($_POST['lastName']));
			$email = mysqli_real_escape_string($con, htmlentities($_POST['email']));
			$password = mysqli_real_escape_string($con, htmlentities($_POST['password']));
			$password_confirm = mysqli_real_escape_string($con, htmlentities($_POST['confirmPassword']));
			$country = $_POST['country'];
			$gender = $_POST['gender'];
			$birthday = mysqli_real_escape_string($con, htmlentities($_POST['birthday']));
			$status = 'unverified';
			$posts = 'no';

			$get_user_email = "SELECT * FROM `users` WHERE `user_email` = '$email' ";
			$get_user_email_run = mysqli_query($con, $get_user_email);
			$user_exists = mysqli_num_rows($get_user_email_run);
			if ($user_exists==1) {
				echo "<script>alert('The email address you entered is already registered. Do you want to log in?')</script>";
				exit();
			}

			if (strlen($password)<8) {
				echo "<script>alert('Password must be more than 8 characters')</script>";
				exit();
			}

			if ($password!=$password_confirm) {
				echo "<script>alert('Passwords do not match.')</script>";
				exit();
			}
				$insert = "INSERT INTO users(`user_firstname`, `user_lastname`, `user_email`, `user_password`, `user_country`, `user_gender`, `user_birthday`, `user_image`, `register_date`, `last_login`, `status`, `posts`) VALUES ('$firstName', '$lastName', '$email', '$password', '$country', '$gender' , '$birthday', 'default.jpg', NOW(), NOW(), '$status', '$posts') ";
				$insert_run = mysqli_query($con, $insert);

				if ($insert_run) {
					$_SESSION['email']=$email;
					echo "<script>window.open('home.php', '_self')</script>";
				}

		}
?>