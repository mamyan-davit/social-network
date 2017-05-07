<?php
ob_start();
 	$get_id = $_GET['post_id'];;
	$get_comments = "SELECT * FROM `comments` WHERE post_id='$get_id' ORDER BY 1 DESC ";
	$get_comments_run = mysqli_query($con, $get_comments);
	
	
	while ($row_comments = mysqli_fetch_array($get_comments_run)) {
		$comment = $row_comments['comment'];
		$comment_author = $row_comments['comment_author'];
		$date = $row_comments['date'];

		echo "
			<div class='thumbnail' id='comments'>
				<h6 id='author'><a href='home.php?id='>$comment_author</a></h6> <span id='date'>($date)</span>
				<p id='comment'>$comment</p>
			</div>
		";
	}

?>