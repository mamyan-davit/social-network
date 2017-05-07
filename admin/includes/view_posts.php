<table class="table">
	<tr>
		<th>S.N.</th>
		<th>ID</th>
		<th>Title</th>
		<th>Content</th>
		<th>Author</th>
		<th>Date</th>
		<th>Edit</th>
		<th>Delete</th>
	</tr>

	<?php 
		$query = "SELECT * FROM `posts` ORDER BY 1 DESC ";
		$query_run = mysqli_query($con, $query);
		$i=0;
		while($row = mysqli_fetch_array($query_run)){

			$id = $row['post_id'];
			$user_id = $row['user_id'];
			$date = $row['post_date'];
			$post_title = $row['post_title'];
			$post_content = $row['post_content'];
			$i++;

		$select_user = "SELECT * FROM `users` WHERE `user_id` = '$user_id' ";
		$select_user_run = mysqli_query($con, $select_user);

		$row_user = mysqli_fetch_array($select_user_run);
		$author_name = $row_user['user_firstname'];
		$author_lastname = $row_user['user_lastname'];	
	?>

		<tr>
		<td><?php echo $i; ?></td>
		<td><?php echo $id; ?></td>
		<td><?php echo $post_title; ?></td>
		<td><?php echo $post_content; ?></td>
		<td><?php echo $author_name . ' ' . $author_lastname; ?></td>
		<td><?php echo $date; ?></td>
		
		<td><a href='index.php?view_posts&edit=<?php echo $id; ?>'>Edit</a></td>
		<td><a href='index.php?view_posts&delete=<?php echo $id; ?>'>Delete</a></td>
	</tr>

	<?php 
		if (isset($_GET['delete'])) {
			$get_delete_id = $_GET['delete'];
			$delete_post = "DELETE FROM `posts` WHERE `post_id` = '$get_delete_id' ";
			$delete_post_run = mysqli_query($con, $delete_post);

			if ($delete_post_run) {
			echo "<script>alert('Post has been deleted')</script>";
			echo "<script>window.open('index.php', '_self')</script>";
			}
		}
	?>
<?php } ?>	

	<?php if(isset($_GET['edit'])){
		$get_edit_id = $_GET['edit'];
		$query_edit = "SELECT * FROM `posts` ORDER BY 1 DESC WHERE `post_id` = '$get_edit_id' ";
		$query_edit_run = mysqli_query($con, $query_edit);
		$row_edit = mysqli_fetch_array($query_run);
		$post_title = $row_edit['post_title'];
		$post_content = $row_edit['post_content'];
	 ?>
	<form action="" method="POST" class="form-horizontal" enctype="multipart/form-data">
    	<table id="reg">
            <tr>
                  <td align="right">
                        <label class="label label-primary">Title</label>
                        <input type="text" name="title" class="form-control" value=<?php echo $post_title; ?>>
                  </td>
            </tr>
            <tr>
                  <td align="right">
                        <label class="label label-primary">Content</label>
                        <textarea class='form-control' cols='5' rows='10' name='content'><?php echo $post_content; ?></textarea>
                  </td>
            </tr>

            <tr>
            	<td> <input type='submit' value='Update' class='btn btn-sm btn-primary pull-right' name='update_post'> </td>
            </tr>
        </table>
    </form>        

   <?php		
			if (isset($_POST['update_post'])) {
    		$title = $_POST['title'];
    		$content = $_POST['content'];
    		$get_edit_id = $_GET['edit'];
			$edit_post = "UPDATE `posts` SET `post_title`='$title', `post_content` = '$content' WHERE `post_id` = '$get_edit_id'  ";
			$edit_post_run = mysqli_query($con, $edit_post);
			if ($edit_post_run) {
			echo "<script>alert('Post has been updated')</script>";
			echo "<script>window.open('index.php', '_self')</script>";
		}
    	}
	?>
	<?php } ?>
</table>
