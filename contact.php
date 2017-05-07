<?php
error_reporting(0);
	if ($_POST['submit']) {
		$result = "<div class='alert alert-success'><strong>Thank you.</strong>We'll get in touch.</div>";

		if (!$_POST['name']) {
			$error = "<br>Please enter your name.";
		}

		if (!$_POST['email']) {
			$error .= "<br>Please enter your email address.";
		}

		if (!$_POST['comment']) {
			$error .= "<br>Please enter message.";
		}

		if ($_POST['email']!='' AND !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
			$error .= "<br>Please enter a valid email address.";
		}

		if ($error) {
			$result = "<div class='alert alert-danger'><strong>Some errors occured during submitting form:</strong> ". $error ." </div>";
		}else{
			$to = 'margaryan.mher.28@gmail.com';
			$subject = 'Contact Form';
			$body = $_POST['comment'];
			$headers = 'From: '.$_POST['email'].'';
			mail($to, $subject, $body, $headers);
		}
	}
?>


<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>NetMate | Contact</title>
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/contact.css">
	<link rel="shortcut icon" type="image/x-icon" href="images/little_icon.png">
</head>
<body>
	
		<div class="container">
			<div class="row">
				<div class="col-md-6 col-md-offset-3">
					<div class="page-header">
						<h1>Get in touch <small>We won't make you wait!</small></h1>
					</div>
						<?php echo $result; ?>
					<form action="contactadmin.php" method="POST" enctype="multipart/form-data">
						<div class="form-group">
						    <label for="name" class="label label-primary">Your Name </label>
						    <input type="text" class="form-control" id="name" name="name" required autofocus value="<?php if (isset($_POST['name'])) {
						    	 echo $_POST['name'];} ?>">
						</div>
						<div class="form-group">
						    <label for="name" class="label label-primary">Your Email </label>
						    <input type="email" class="form-control" id="email" name="email" required value="<?php if (isset($_POST['email'])) {echo $_POST['email'];} ?>">
						</div>
						<div class="form-group">
						    <label for="name" class="label label-primary">Your Message </label>
						    <textarea name="comment" cols="30" rows="10" id="textarea" required class="form-control" maxlength="300" value="<?php if (isset($_POST['comment'])) {echo $_POST['comment'];} ?>"></textarea>
						    <span class="small" id="textarea_feedback"></span>
						</div>
						
						<a href="index.php" class="btn btn-default">Go Back</a>
						<input type="submit" name="submit" class="btn btn-primary btn-lg pull-right" value="Send" >
					</form>
				</div>
			</div>
		</div>

	<script src="js/bootstrap.js"></script>
	<script src="js/jquery_3.0.0.js"></script>
	<script src="js/mainscript.js"></script>
</body>
</html>