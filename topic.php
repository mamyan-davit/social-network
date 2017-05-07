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
						echo "
						  	<span><img src='user/user_images/$user_image' width='200' height='200' class='thumbnail'></span>
						  	<li id='name'>$firstName $lastName</li>
					  	 <ul class='user_list'>
						  	<li> <i> From: </i> $country</li>
						  	<li> <i> Sex: </i> $sex </li>
							<li> <i> Last visit: </i> $last_login</li>
							<li> <i> Member since: </i> $register_date</li>
							<li><a href='my_messages.php'>Messages(3)</a></li>
							<li><a href='my_posts.php'>Posts(2)</a></li>
							<li><a href='edit_profile.php'>Edit my accout</a></li>
							<li><a href='logout.php'>Log Out</a></li>
						  </ul>	
						";
					?>
				</div>
				<div class="col-md-9" id="timeline">
					<h4>All posts in this category</h4>
					<?php 
							if (isset($_GET['topic'])) {
								$topic_id = $_GET['topic'];
							}

							$get_posts = "SELECT * FROM `posts` WHERE `topic_id` = '$topic_id' ORDER BY 1 DESC ";
							$get_posts_run = mysqli_query($con, $get_posts);
							while ($row = mysqli_fetch_array($get_posts_run)) {
								$post_id = $row['post_id'];
								$user_id = $row['user_id'];
								$post_title = $row['post_title'];
								$post_content = $row['post_content'];
								$post_date = $row['post_date'];

								//FIND WHO POSTED
								$poster = "SELECT * FROM `users` WHERE `user_id` = '$user_id' AND `posts` = 'yes' ";
								$poster_run = mysqli_query($con, $poster);
								$row_user = mysqli_fetch_array($poster_run);
								$firstName = $row_user['user_firstname']; 
								$lastName = $row_user['user_lastname'];
								$user_image = $row_user['user_image'];

								//DISPLAYING THE WHOLE THING
								echo "<div class='thumbnail'>
									<p id='user_image' ><img src='user/user_images/$user_image' width='60' height='60'></p>
									<p id='statusWriter'><a href='user_profile.php?user_id=$user_id'>$firstName $lastName </a></p>
									<h4 id='title'>$post_title</h4>
									<p id='published'>$post_date</p>
									<p>$post_content</p>
									<a href='single.php?post_id=$post_id' style='float:right'><button class='btn btn-small btn-success'>View or Reply</button></a><br><br>
									</div>
								";
							}
?>

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