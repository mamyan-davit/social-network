<?php session_start(); 
require 'includes/connection.php';
include 'functions/functions.php';
if (!isset($_SESSION['email'])) {
	header('location: index.php');
}else {
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>NetMate | <?php usernameTitle() ?> </title>
        <meta charset="UTF-8">
        <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1"/>
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="css/home.style.css">
        <link rel="shortcut icon" type="image/x-icon" href="images/little_icon.png">
</head>
<body>
	
	<div class="container">
		<div class="row" id="head_wrap">
			<div class="col-md-7">
				<ul>
					<li><a href="home.php">Home</a></li>
					<li><a href="members.php">Members</a></li>
					<li id="nopadding"><strong>Topics:   </strong></li>
					<?php
						$fetch_topic = "SELECT * FROM `topics` ";
						$fetch_topic_run = mysqli_query($con, $fetch_topic);
						while ($row=mysqli_fetch_array($fetch_topic_run)) {
							$topic_id=$row['topic_id'];
							$topic_title=$row['topic_title'];
							echo "<li><a href='topic.php?topic=$topic_id'> $topic_title</a></li>";
						}
					?>
				</ul>
			</div>
			<div class="col-md-5">
				<form action="results.php" class="form-inline" method="GET" id="searchForm">
					<input type="text" name="search" class="form-control" id="searchBox" placeholder="Search a post">
					<input type="submit" value="Search" class="btn btn-default btn-sm" name="searchBtn">
				</form>
			</div>
		</div>

		<div id="content">
			<div class="row">
				<div class="col-md-3" id="user_details">
					<?php 
						$user_current = $_SESSION['email'];
						$get_user = "SELECT * FROM `users` WHERE `user_email` = '$user_current' ";
						$get_user_run = mysqli_query($con, $get_user);
						$row = mysqli_fetch_array($get_user_run);
						$user_id_now = $row['user_id'];
						$user_image = $row['user_image'];
						$firstName = $row['user_firstname'];
						$lastName = $row['user_lastname'];
						$country = $row['user_country'];
						$sex = $row['user_gender'];
						$register_date = $row['register_date'];
						$last_login = $row['last_login'];

						$posts = "SELECT * FROM `posts` WHERE `user_id` = '$user_id_now'";
						$posts_run = mysqli_query($con, $posts);
						$number_of_posts = mysqli_num_rows($posts_run);

						echo "
						  	<span><img src='user/user_images/$user_image' width='200' height='200' class='thumbnail img-responsive'></span>
						  	<li id='name'>$firstName $lastName</li>
					  	 <ul class='user_list'>
						  	<li> <i> From: </i> $country</li>
						  	<li> <i> Sex: </i> $sex </li>
							<li> <i> Last visit: </i> $last_login</li>
							<li> <i> Member since: </i> $register_date</li>
							<li><a href='my_messages.php?id=$user_id_now'>Messages(3)</a></li>
							<li><a href='my_posts.php?id=$user_id_now'>Posts($number_of_posts)</a></li>
							<li><a href='edit_profile.php?id=$user_id_now'>Edit my accout</a></li>
							<li><a href='logout.php'>Log Out</a></li>
						  </ul>	
						";
					?>
				</div>
				<div class="col-md-9" id="timeline">
					<?php
						if (isset($_GET['user_id'])) {
							$user_id = $_GET['user_id'];
							$user = "SELECT * FROM `users` WHERE `user_id`='$user_id' ";
							$user_run = mysqli_query($con, $user);
							$row = mysqli_fetch_array($user_run);
							$user_id = $row['user_id'];
							$user_firstname = $row['user_firstname'];
							$user_lastname = $row['user_lastname'];
							$user_image = $row['user_image'];
							$register_date = $row['register_date'];
						}
					?>
					<div class='messageBox'>
						<h4>Send a message to <span style='color:#777'> <?php echo $user_firstname .' '. $user_lastname ?></span> </h4>
						<form enctype="form/multipart-data" method="post" action="messages.php?user_id=<?php echo $user_id; ?>" >
							<input type="text" name="msg_title" class="form-control" placeholder="Subject">
							<textarea name="msg_content" id="" cols="15" rows="10" placeholder="Message" class="form-control"></textarea>
							<input type="submit" value="Send" name="send" class="btn btn-primary btn-md pull-right addSomeMargin">
						</form>
						<?php 
							if (isset($_POST['send'])) {
								$user_id = $_GET['user_id'];
								$user_id = $row['user_id'];
								$user_firstname = $row['user_firstname'];
								$user_lastname = $row['user_lastname'];

								$msg_title = $_POST['msg_title'];
								$msg_content = $_POST['msg_content'];

								$insert_message = "INSERT INTO messages (`msg_subject`, `msg_content`, `sender`, `receiver`, `reply`, `status`, `msg_date`) VALUES ('$msg_title', '$msg_content', '$user_id_now', '$user_id', 'no-reply', 'unread', NOW() )";
								$insert_message_run = mysqli_query($con, $insert_message);
								if (!$insert_message_run) {
									echo "<script>alert('We were not able to send your message. Sorry :( ')</script>";
								}else {
									echo "<h6>Your message to <strong> $user_firstname $user_lastname </strong> was sent successfully</h6>";
								}
							}
						?>
					</div>
				</div>
			</div>
		</div>

	</div>

	<!-- SCRIPTS START -->
	<script src='js/jquery_3.0.0.js'></script>
	<script src='js/bootstrap.js'></script>
	<script src='js/mainscript.js'></script>
	<!-- SCRIPTS END -->
</body>
</html>

<?php } ?>