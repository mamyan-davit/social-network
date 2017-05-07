<?php 
	$query = "SELECT * FROM `posts` ";
	$result = mysqli_query($con, $query);

	$per_page = 3;
		if (isset($_GET['page'])) {
			$page = $_GET['page'];
		}else {
			$page = 1;
		}

	//COUNT THE TOTAL RECORDS
	$total_posts = mysqli_num_rows($result);
	//DEVIDE TOTAL RECORDS ON PER PAGE
	$total_pages = ceil($total_posts/$per_page);
	//GOING TO FIRST PAGE
	echo "
		<center>
		<ul class='pagination'>
		<li><a href='home.php?page=1'>&laquo;</a></li>
	";

	for ($i=1; $i < $total_pages; $i++) { 
		echo "<li><a href='home.php?page=$i'>$i</a></li>";
	}

	//FOR LAST PAGE
		echo "<li><a href='home.php?page=$total_pages'>&raquo;</a></li>
		</ul>
		</center>";
?>