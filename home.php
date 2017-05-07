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
        <title>NetMate | Login or Sign up</title>
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="css/home.style.css">
        <link rel="shortcut icon" type="image/x-icon" href="images/little_icon.png">
</head>
<body>
	
	<div class="container">
		<div class="row" id="head_wrap">
			<div class="col-md-7">
				<ul>
					<li><a class="active" href="home.php">Home</a></li>
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
						$user_id = $row['user_id'];
						$user_image = $row['user_image'];
						$firstName = $row['user_firstname'];
						$lastName = $row['user_lastname'];
						$country = $row['user_country'];
						$sex = $row['user_gender'];
						$register_date = $row['register_date'];
						$last_login = $row['last_login'];

						$posts = "SELECT * FROM `posts` WHERE `user_id` = '$user_id'";
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
							<li><a href='my_messages.php?id=$user_id'>Messages(3)</a></li>
							<li><a href='my_posts.php?id=$user_id'>Posts($number_of_posts)</a></li>
							<li><a href='edit_profile.php?id=$user_id'>Edit my accout</a></li>
							<li><a href='logout.php'>Log Out</a></li>
						  </ul>	
						";
					?>
				</div>
				<div class="col-md-9" id="timeline">
					<form method="POST" action="home.php?id=<?php echo $user_id;?>">
						<h3>Share your thoughts...</h3>
						<input type="text" name="status_topic_title" class="form-control" placeholder="Title" required="true">
						<textarea name="status_text" id="textarea" cols="30" rows="4" class="form-control" placeholder="What's on your mind..." required="true"></textarea>
						<span class="small" id="textarea_feedback"></span> <br>
						<select class="form-control" name="select_topic" id="select_topic">
							<option>Select a topic</option>
							<?php showOption(); ?>
						</select>
						<input type="submit" value="Post" name="add_status" class="btn btn-large btn-primary">
						<?php insertUser(); ?>
					</form>
					
					<div id="posts">
						<h4 class="header">My news feed</h4>
						<?php displayPosts(); ?>
					</div><br><br>
					<?php include 'pagination.php'; ?>
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