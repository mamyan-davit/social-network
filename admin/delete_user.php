<?php include '../includes/connection.php'; ?>
<?php 
	if (isset($_GET['delete'])) {
		$get_id = $_GET['delete'];
		$delete_user = "DELETE FROM `users` WHERE `user_id` = $get_id ";
		$delete_user_run = mysqli_query($con, $delete_user);

		$delete_user_posts = "DELETE FROM `posts` WHERE `user_id` = $get_id ";
		$delete_user_posts_run = mysqli_query($con, $delete_user_posts);

		if ($delete_user_run && $delete_user_posts_run) {
			echo "<script>alert('User has been deleted')</script>";
			echo "<script>window.open('index.php', '_self')</script>";
		}

	}
?>