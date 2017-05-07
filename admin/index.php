<?php 
session_start();
include '../includes/connection.php'; 
if (!isset($_SESSION['admin_email'])) {
	header("Location: admin_login.php");
}else{
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>NetMate | Admin</title>
	<link rel="stylesheet" href="../css/bootstrap.min.css">
	<link rel="stylesheet" href="admin.style.css">
</head>
<body>
	
	<div class="container">
		<header>
			<div class="row">
				<div class="col-md-6 col-md-offset-3">
					<h3>Welcome to admin panel</h3>
				</div>
			</div>
		</header>

		<main>
			<div class="row">
			<div class="col-md-3">
				<aside id="sidebar">
					<h4>Manage Content</h4>
					<ul class="menu">
						<li><a href="index.php?view_users">View Users</a></li>
						<li><a href="index.php?view_posts">View Posts</a></li>
						<li><a href="index.php?view_comments">View Comments</a></li>
						<li><a href="index.php?view_topics">View Topics</a></li>
						<li><a href="index.php?add_topic">Add New Topic</a></li>
						<li><a href="admin_logout.php">Admin Logout</a></li>
					</ul>
				</aside>
			</div>
			
				<div class="col-md-9">	
					<div id="content">
						<?php
							if (isset($_GET['view_users'])){
								include 'includes/view_users.php';
							}else if(isset($_GET['view_posts'])){
								include 'includes/view_posts.php';
							}
						?>
					</div>
				</div>
			</div>
		</main>

		<footer>
			<div class="row">
				<div class="col-md-6 col-md-offset-3">
					<p>Copyright &copy; 2016 Created and powered by Mher Margaryan</p>
				</div>
			</div>
		</footer>
	</div>

	<script src='../js/jquery_3.0.0.js'></script>
	<script src='../js/mainscript.js'></script>
</body>
</html>

<?php } ?>