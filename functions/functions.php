<!-- BELOW IS MYSQL CONNECTION. I DUNNO WHY I COUL'DND SPECIFY THE RIGHT PATH :D I'M A STUPID GUY :DD -->
<?php
	$mysql_server = "localhost";
	$mysql_user = "root";
	$mysql_password = "";
	$mysql_db = "netmate";
	$mysqli = new mysqli($mysql_server, $mysql_user, $mysql_password, $mysql_db);
	if ($mysqli->connect_errno) {
		printf("Connection failed: %s \n", $mysqli->connect_error);
		exit();
	}
	$mysqli->set_charset("utf8");
?>

<!-- THE FUNCTION BELOW IS FOR INSERTING USERNAME INTO TITLE SO THAT IT LOOKS CUUUUUUTE AND COOOOOOL -->
<?php 
	function usernameTitle(){
		global $con;
		$user_current = $_SESSION['email'];
		$get_user = "SELECT * FROM `users` WHERE `user_email` = '$user_current' ";
		$get_user_run = mysqli_query($con, $get_user);
		$row = mysqli_fetch_array($get_user_run);
		$firstName = $row['user_firstname']; 
		$lastName = $row['user_lastname'];
		echo $firstName .' '. $lastName;
	}
?>

<!-- THE FUNCTION BELOW IS SHOWING TOPICS AS OPTION -->
<?php 
	function showOption(){
		global $con;
		$topics="SELECT * FROM `topics` ";
		$topics_run = mysqli_query($con, $topics);
		while ($row=mysqli_fetch_array($topics_run)) {
			$topic_id = $row['topic_id'];
			$topic_title = $row['topic_title'];
			echo "<option value='$topic_id'>$topic_title</option>";
		}
	}
?>

<!-- INSERT USER'S POST -->
<?php 
	function insertUser(){
		global $con;
		global $user_id;
		global $topic_id;

		if (isset($_POST['add_status'])) {
			$post_title = mysqli_real_escape_string($con, $_POST['status_topic_title']);
			$status_text =  mysqli_real_escape_string($con, $_POST['status_text']);

			$insert = "INSERT INTO posts(`user_id`, `topic_id`, `post_title`, `post_content`, `post_date`)VALUES ('$user_id', '$topic_id', '$post_title', '$status_text', NOW() ) ";
			$insert_run = mysqli_query($con, $insert);
			if ($insert_run) {
				$posts_yes = "UPDATE `users` SET `posts`='yes' WHERE `user_id`='$user_id' ";
				$posts_yes_run = mysqli_query($con, $posts_yes);
			}
		}
	}
?>

<!-- DISPLAY USERS POSTS -->
<?php
	function displayPosts(){
		global $con;
		$per_page = 5;
		if (isset($_GET['page'])) {
			$page = $_GET['page'];
		}else {
			$page = 1;
		}
		$start_from = ($page-1) * $per_page;
		$get_posts = "SELECT * FROM `posts` ORDER BY 1 DESC LIMIT $start_from, $per_page ";
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
				<p id='cntnt'>$post_content</p>
				<a href='single.php?post_id=$post_id' style='float:right'><button class='btn btn-small btn-success'>View or Reply</button></a><br><br>
				</div>
			";
		}
	}
?>


<!-- DISPLAYING ONE SINGLE POST -->
<?php 
	function singlePost(){
		global $user_id;
		global $con;
		if (isset($_GET['post_id'])) {
			$id = $_GET['post_id'];
			$get_posts = "SELECT * FROM `posts` WHERE `post_id` = '$id' ";
			$get_posts_run = mysqli_query($con, $get_posts);
				
				$row = mysqli_fetch_array($get_posts_run);
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
				echo "<div class='thumbnail setMarginTop'>
					<p id='user_image' ><img src='user/user_images/$user_image' width='60' height='60'></p>
					<p id='statusWriter'><a href='user_profile.php?user_id=$user_id'>$firstName $lastName </a></p>
					<h4 id='title'>$post_title</h4>
					<p id='published'>$post_date</p>
					<p>$post_content</p>
					</div>
					<div>";
				include 'comments.php';
				echo "
						<form action='' method='POST' id='commentForm'>
							<textarea name='commentSection' id='commentSection' cols='15' rows='3' placeholder='Write a comment' class='form-control'></textarea><br>
							<input type='submit' class='btn btn-sm btn-primary pull-right' value='Reply' name='commentSender'>
						</form>
					</div>
				";

				if (isset($_POST['commentSender'])) {
						$user_current = $_SESSION['email'];
						$get_user = "SELECT * FROM `users` WHERE `user_email` = '$user_current' ";
						$get_user_run = mysqli_query($con, $get_user);
						$row = mysqli_fetch_array($get_user_run);
						$firstName = $row['user_firstname']; 
						$lastName = $row['user_lastname'];
					$comment = $_POST['commentSection'];
					$author = $firstName .' '.$lastName;
					$insert_comment = "INSERT INTO comments(`post_id`, `user_id`, `comment`, `comment_author`, `date`) VALUES('$post_id', '$user_id', '$comment', '$author', NOW()) ";
					$insert_comment_run = mysqli_query($con, $insert_comment);
				}	
			}
	}

?>

<!-- DISPLAY USER'S POSTS -->
<?php
	function DisplayMyPosts(){
		global $con;
		global $user_id;
		global $post_id;

		if (isset($_GET['id'])) {
			$id=$_GET['id'];
		}
		$get_posts = "SELECT * FROM `posts` WHERE `user_id`='$user_id' ORDER BY 1 DESC ";
		$get_posts_run = mysqli_query($con, $get_posts);
		while ($row = mysqli_fetch_array($get_posts_run)) {
			$post_id = $row['post_id'];
			$user_id = $row['user_id'];
			$post_title = $row['post_title'];
			$post_id = $row['post_id'];
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
				<p id='cntnt'>$post_content</p>
				
				<a href='functions/delete_post.php?post_id=$post_id' style='float:right'><button class='btn crud btn-small btn-default'>Delete</button></a>
				<a href='functions/edit_post.php?post_id=$post_id' style='float:right'><button class='btn crud btn-small btn-default'>Edit</button></a>
				<a href='single.php?post_id=$post_id' style='float:right'><button class='btn crud btn-small btn-default'>View</button></a>
				
				</div>
			";
			include 'delete_post.php';
		}
	}
?>

<?php 
	function userProfile(){
		global $mysqli;
		$user_id = $_GET['user_id'];
		$user = "SELECT * FROM `users` WHERE `user_id`='$user_id' ";
		$user_run = mysqli_query($mysqli, $user);
		$row = mysqli_fetch_array($user_run);

		$user_id = $row['user_id'];
		$user_firstname = $row['user_firstname'];
		$user_lastname = $row['user_lastname'];
		$user_email = $row['user_email'];
		$user_country = $row['user_country'];
		$user_gender = $row['user_gender'];
		$user_birthday = $row['user_birthday'];
		$user_image = $row['user_image'];
		$register_date = $row['register_date'];
		$last_login = $row['last_login'];
		$status = $row['status'];

		if ($user_gender=='Male') {
			$msg = 'Send him a message';
		}else if($user_gender=='Transgender'){
			$msg = 'Send it a message';
			//i'm not a homofobic or else, but i dunno what to write...
		} else {
			$msg = 'Send her a message';
		}

		echo "
			<div class='user'>
				<ul>
					<img src='user/user_images/$user_image' width='150' height='150' id='user_image_area'>
					<li id='user_id_area' >NetMate address: <a href='user_profile.php?user_id=$user_id'><strong> user_id=$user_id</strong></a><br>
					<li id='user_name_area'>Name: <strong> $user_firstname</strong></li><br>
					<li id='user_sirname_area'>Surname: <strong> $user_lastname</strong></li><br>
					<li>Email:<strong> $user_email</strong></li>
					<li>Sex: <strong>  $user_gender</strong></li>
					<li>Birthday: <strong> $user_birthday</strong></li>
					<li>Registration date: <strong> $register_date</strong></li>
					<li>Last logged in: <strong> $last_login</strong></li>
					<li>Status:<strong> $status</strong></li>
					<li><a href='messages.php?user_id=$user_id'><button id='msgBtn' class='btn btn-default btn-sm pull-right'>$msg</button></a></li>
				</ul>
			</div>
		";

		newMembers();
 	}
?>


<?php 
	function newMembers(){
			global $mysqli;
			$newUsers = "SELECT * FROM `users` ";
			echo "
				<div class='newMembers'>
					<hr>
					<h4>New members</h4>
				</div>
			";
			$newUsersRun = mysqli_query($mysqli, $newUsers);
			while($row = mysqli_fetch_array($newUsersRun)){
			$user_id = $row['user_id'];
			$user_firstname = $row['user_firstname'];
			$user_lastname = $row['user_lastname'];
			$user_image = $row['user_image'];

			echo "
				<span class='newMembersListed'>
					<a href='user_profile.php?user_id=$user_id'>
						<img src='user/user_images/$user_image' title='$user_firstname $user_lastname' width='50' height='50' style='float:left'>
					</a>
				</span>
			";
		}
	}
?>