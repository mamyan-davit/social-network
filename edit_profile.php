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
	<title>NetMate | Edit Profile </title>
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
					<input type="text" name="search" class="form-control" id="searchBox" placeholder="Search a topic">
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
                                    $password = $row['user_password'];
                                    $email = $row['user_email'];
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
							<li><a href='my_messages.php?id=$user_id'>Messages(3)</a></li>
							<li><a href='my_posts.php?id=$user_id'>Posts(2)</a></li>
							<li><a href='edit_profile.php?id=$user_id'>Edit my accout</a></li>
							<li><a href='logout.php'>Log Out</a></li>
						  </ul>	
						";
					?>
				</div>
				<div class="col-md-9" id="timeline">
					<h4>Edit Account</h4>
					<form action="" method="POST" class="form-group" enctype="multipart/form-data">
                  <table id="reg">
                        <tr>
                              <td align="right">
                                    <label class="label label-primary">First Name</label>
                                    <input type="text" name="firstName" class="form-control" value=<?php echo $firstName; ?>>
                              </td>
                        </tr>
                        <tr>
                              <td align="right">
                                    <label class="label label-primary">Last Name</label>
                                    <input type="text" name="lastName" class="form-control" value="<?php echo $lastName; ?>">
                              </td>
                        </tr>
                        <tr>
                              <td align="right">
                                    <label class="label label-primary">Email</label>
                                    <input type="email" name="email" class="form-control"  value="<?php echo $email; ?>">
                              </td>
                        </tr>
                        <tr>
                              <td align="right">
                                    <label class="label label-primary">Password</label>
                                    <input type="password" name="password" class="form-control" value="<?php echo $password; ?>">
                              </td>
                        </tr>
                        <tr>
                              <td align="right">
                                    <label class="label label-primary">Confirm Password</label>
                                    <input type="password" name="confirmPassword" class="form-control" placeholder="Confirm password">
                              </td>
                        </tr>

                        <tr>
                              <td align="right">
                                    <label class="label label-primary">Add a photo</label>
                                    <input type="file" name="photo" class="form-control">
                              </td>
                        </tr>

                        <tr>
                              <td align="right">
                                    <label class="label label-primary">Select your country</label>
                                    <select name="country" class="form-control" disabled>
                                          <option><?php echo $country; ?></option>
                                          <?php include 'includes/countrylist.php'; ?>
                                    </select>
                              </td>
                        </tr>
                        <tr>
                              <td align="right">
                                    <label class="label label-primary">Select your gender</label>
                                    <select name="gender" id="genderList" disabled class="form-control">
                                          <option><?php echo $sex; ?></option>
                                          <option value="Male">Male</option>
                                          <option value="Female">Female</option>
                                          <option value="Transgender">Transgender</option>
                                    </select>
                              </td>
                        </tr>
                        
                        <tr>
                              <td>
                                    <input type="submit" value="Update" name="update" class="btn btn-primary pull-right">
                              </td>
                        </tr>
                  </table>
            </form>

            <?php
                  if (isset($_POST['update'])) {
                        $firstName = $_POST['firstName'];
                        $lastName = $_POST['lastName'];
                        $email = $_POST['email'];
                        $password = $_POST['password'];
                        $photo = $_FILES['photo']['name'];
                        $photo_tmp = $_FILES['photo']['tmp_name'];
                        move_uploaded_file($photo_tmp, "user/user_images/$photo");

                        $update = "UPDATE `users` SET `user_firstname`='$firstName', `user_lastname`='$lastName', `user_email`='$email', `user_password`='$password', `user_image`='$photo' WHERE `user_id` = '$user_id' ";
                        $update_run = mysqli_query($con, $update);
                        if ($update_run) {
                              echo "<script>alert('Your profile was updated!')</script>";
                              echo "<script>window.open('home.php', '_self')</script>";
                        }else {
                              echo "<script>alert('Something is terribly wrong!')</script>";
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