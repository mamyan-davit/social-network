<table class="table">
	<tr>
		<th>S.N.</th>
		<th>ID</th>
		<th>Name</th>
		<th>Surname</th>
		<th>Email</th>
		<th>Photo</th>
		<th>Gender</th>
		<th>Country</th>
		<th>Edit</th>
		<th>Delete</th>
	</tr>

	<?php 
		$query = "SELECT * FROM `users` ORDER BY 1 DESC ";
		$query_run = mysqli_query($con, $query);
		$i=0;
		while($row = mysqli_fetch_array($query_run)){

			$id = $row['user_id'];
			$firstname = $row['user_firstname'];
			$lastname = $row['user_lastname'];
			$email = $row['user_email'];
			$photo = $row['user_image'];
			$sex = $row['user_gender'];
			$country = $row['user_country'];
			$i++
	?>

	<tr>
		<td><?php echo $i; ?></td>
		<td><?php echo $id; ?></td>
		<td><?php echo $firstname; ?></td>
		<td><?php echo $lastname; ?></td>
		<td><?php echo $email; ?></td>
		<td><img width='30' height='30' src='../user/user_images/<?php echo $photo; ?>'></td>
		<td><?php echo $sex; ?></td>
		<td><?php echo $country; ?></td>
		<td><a href='index.php?view_users&edit=<?php echo $id; ?>'>Edit</a></td>
		<td><a href='delete_user.php?delete=<?php echo $id; ?>'>Delete</a></td>
	</tr>
	<?php } ?>
</table>



<?php
	if (isset($_GET['edit'])) {
		$edit_id = $_GET['edit'];
		$query = "SELECT * FROM `users` where `user_id` = '$edit_id' ";
		$query_run = mysqli_query($con, $query);
			$row = mysqli_fetch_array($query_run);
			$id = $row['user_id'];
			$firstname = $row['user_firstname'];
			$lastname = $row['user_lastname'];
			$email = $row['user_email'];
			$photo = $row['user_image'];
			$sex = $row['user_gender'];
			$country = $row['user_country'];
?>

		<h4>Edit User Account</h4>
<form action="" method="POST" class="form-horizontal" enctype="multipart/form-data">
    <table id="reg">
            <tr>
                  <td align="right">
                        <label class="label label-primary">First Name</label>
                        <input type="text" name="firstName" class="form-control" value=<?php echo $firstname; ?>>
                  </td>
            </tr>
            <tr>
                  <td align="right">
                        <label class="label label-primary">Last Name</label>
                        <input type="text" name="lastName" class="form-control" value="<?php echo $lastname; ?>">
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
                        <label class="label label-primary">Select country</label>
                        <select name="country" class="form-control">
                              <option><?php echo $country; ?></option>
                              <?php include '../includes/countrylist.php'; ?>
                        </select>
                  </td>
            </tr>
            <tr>
                  <td align="right">
                        <label class="label label-primary">Select gender</label>
                        <select name="gender" id="genderList" class="form-control">
                              <option><?php echo $sex; ?></option>
                              <option value="Male">Male</option>
                              <option value="Female">Female</option>
                              <option value="Transgender">Transgender</option>
                        </select>
                  </td>
            </tr>
            
            <tr><br><br>
                  <td>
                        <input type="submit" value="Update" name="update" class="btn btn-primary pull-right">
                  </td>
            </tr>
    </table>
    <?php } ?>
</form>

<?php
if (isset($_POST['update'])) {
		$firstname = $_POST['firstName'];
		$lastname = $_POST['lastName'];
		$email = $_POST['email'];
		$country = $_POST['country'];
		$gender = $_POST['gender'];
		$update_query = "UPDATE `users` SET `user_firstname` = '$firstname', `user_lastname` = '$lastname', `user_email` = '$email', `user_gender` = '$gender', `user_country` = '$country' WHERE `user_id` = '$edit_id' ";
		$update_query_run = mysqli_query($con, $update_query);

		if ($update_query_run) {
			echo "<script>alert('User info has been updated')</script>";
			echo "<script>window.open('index.php', '_self')</script>";
		}
	}	
?>		