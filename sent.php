<?php
	echo "
		<table class='table table-control'>
			<tr>
				<th>To:</th>
				<th>Subject: </th>
				<th>Date: </th>
				<th>Status: </th>
				<th></th>
			</tr>
		";
			
				if ($user_id != $user_current) {
					$user_another=$user_id;
				}
					$msg = "SELECT * FROM `messages` WHERE `receiver`='$user_id'ORDER BY 1 DESC ";
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