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
						$user_id = $row['user_id'];
						$user_image = $row['user_image'];
						$firstName = $row['user_firstname'];
						$lastName = $row['user_lastname'];
						$country = $row['user_country'];
						$sex = $row['user_gender'];
						$register_date = $row['register_date'];
						$last_login = $row['last_login'];
						echo "
						  	<span><img src='user/user_images/$user_image' width='200' height='200' class='thumbnail img-responsive'></span>
						  	<li id='name'>$firstName $lastName</li>
					  	 <ul class='user_list'>
						  	<li> <i> From: </i> $country</li>
						  	<li> <i> Sex: </i> $sex </li>
							<li> <i> Last visit: </i> $last_login</li>
							<li> <i> Member since: </i> $register_date</li>
							<li><a href='my_messages.php?user_id=$user_id'>Messages(3)</a></li>
							<li><a href='my_posts.php?user_id=$user_id'>Posts(2)</a></li>
							<li><a href='edit_profile.php?user_id=$user_id'>Edit my accout</a></li>
							<li><a href='logout.php'>Log Out</a></li>
						  </ul>	
						";
					?>
				</div>
				<div class="col-md-9" id="timeline">
					<h4>Your inbox</h4>
					<table class='table table-control'>
						<tr>
							<th>From:</th>
							<th>Subject: </th>
							<th>Date: </th>
							<th>Status: </th>
							<th></th>
						</tr>

							<?php
							if ($user_id != $user_current) {
								$user_another=$user_id;
							}
								$msg = "SELECT * FROM `messages` WHERE `receiver`='$user_another' AND `status`='unread' ORDER BY 1 DESC ";
								$msg_run = mysqli_query($con, $msg);
								$count_msg = mysqli_num_rows($msg_run);

								while ($row_msg = mysqli_fetch_array($msg_run)){
									$msg_id=$row_msg['msg_id'];
									$msg_sender = $row_msg['sender'];
									$msg_receiver = $row_msg['receiver'];
									$msg_subject = $row_msg['msg_subject'];
									$msg_content = $row_msg['msg_content'];
									$msg_date = $row_msg['msg_date'];
									$msg_status = $row_msg['status'];	

									$senderman = "SELECT * FROM `users` WHERE `user_id` = '$msg_sender' ";
									$senderman_run = mysqli_query($con, $senderman);
										
									$row_rec = mysqli_fetch_array($senderman_run);
									$from_name = $row_rec['user_firstname'];
									$from_surname = $row_rec['user_lastname']; 
									echo "
										<tr class='inbox'>
											<td> <a href='user_profile.php?user_id=$msg_sender'> $from_name $from_surname </a> </td>
											<td> <a href='my_messages.php?msg_id=$msg_id'> $msg_subject </a></td>
											<td> $msg_date </td>
											<td> $msg_status </td>
											<td> <a href='my_messages.php?msg_id=$msg_id'><button class='btn btn-default btn-sm' style='display:inline' >Reply</button></a> </td>
										</tr>
									";
								}
							?>
					</table>
					<?php
						if (isset($_GET['msg_id'])) {
							$msg_id = $_GET['msg_id'];
							$select_msg = "SELECT * FROM `messages` WHERE `msg_id` = '$msg_id' ";
							$select_msg_run = mysqli_query($con, $select_msg);
							$row_message = mysqli_fetch_array($select_msg_run);
							$msg_subject = $row_message['msg_subject'];
							$msg_content = $row_message['msg_content'];
							$msg_reply = $row_message['reply'];

							echo "
								<div class='thumbnail' id='msgRead'>
									<h5> You have new message from <a href='user_profile.php?user_id=$msg_sender'> $from_name $from_surname </a> </h5>
									<p class='date'> $msg_date </p>
										<div id='inBorder'>	
											<h4> $msg_subject </h4>
											<p> $msg_content </p>
										</div>
										<div id='myReply'>
											<h4>Your reply: </h4>
											<p>$msg_reply</p>
										</div>
								</div>

								<div class='thumbnail replyBox'>
									<form action='' method='POST'>
										<textarea name='replyContent' cols='7' rows='7' class='form-control' placeholder='Your reply'></textarea><br>
										<input type='submit' value='Reply' name='reply' class='btn btn-primary btn-sm pull-right'>
									</form>
								</div>	
							";

							if (isset($_POST['reply'])) {
								$replyContent = $_POST['replyContent'];
								if ($msg_reply!='no-reply') {
									echo "<script>alert('You have already replied to this message.')</script>";
									exit();
								}else{
									$update_msg = "UPDATE `messages` SET `reply` = '$replyContent' WHERE `msg_id` = '$msg_id' ";
									$update_msg_run = mysqli_query($con, $update_msg);
								}
							}
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