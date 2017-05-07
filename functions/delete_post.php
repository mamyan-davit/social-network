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

<?php 
	if (isset($_GET['post_id'])) {
		$id = $_GET['post_id'];
		$delete_post = "DELETE FROM `posts` WHERE `post_id` = '$id' ";
		$delete_post_run = mysqli_query($mysqli, $delete_post);
		if ($delete_post) {
			echo "<script>window.open('../my_posts.php', '_self')</script>";
		}
	}

?>