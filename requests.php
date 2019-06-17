<?php
include("includes/header.php"); //Header 
?>

<div class="main">
	<div class="content_resize">
	
	<div class="user_details column">
			<a href="<?php echo $userLoggedIn; ?>">
				<img src="<?php echo $user['profile_pic']; ?>">
			</a>

			<div class="user_details_left_right">
				<a href="<?php echo $userLoggedIn; ?>">
			<?php
echo $user['first_name'] . " " . $user['last_name'];

?>
			</a>
				<br>
			<?php

			echo "Posts: " . $post['tot_post'] . "<br>";
			echo "Likes: " . $likes['like_count'];

?>
		</div>
		</div>
	
	
	
	<div class="main_column column">
	<h4>Friend Requests</h4>

	<?php  
	$query = mysqli_query($con, "SELECT * FROM relationship WHERE receiver_name='$userLoggedIn' AND friendship_status= 'Sent'");
	
	if(mysqli_num_rows($query) == 0)
		echo "You have no friend requests at this time!";
	else {

		while($row = mysqli_fetch_array($query)) {
			$user_from = $row['sender_name'];
			$user_from_obj = new User($con, $user_from);
			
			echo $user_from_obj->getFirstAndLastName() . " sent you a friend request!";

			#$user_from_friend_array = $user_from_obj->getFriendArray();

			if(isset($_POST['accept_request' . $user_from ])) {
				$add_friend_query = mysqli_query($con, "UPDATE relationship SET friendship_status= 'Accepted' WHERE receiver_name='$userLoggedIn' AND sender_name= '$user_from'");
				echo "You are now friends!";
				header("Location: requests.php");
			}

			if(isset($_POST['ignore_request' . $user_from ])) {
				$delete_query = mysqli_query($con, "UPDATE relationship SET friendship_status= 'Declined' WHERE receiver_name='$userLoggedIn' AND sender_name= '$user_from'");
				echo "Request ignored!";
				header("Location: requests.php");
			}

			?>
			<form action="requests.php" method="POST">
				<input type="submit" name="accept_request<?php echo $user_from; ?>" id="accept_button" value="Accept">
				<input type="submit" name="ignore_request<?php echo $user_from; ?>" id="ignore_button" value="Ignore">
			</form>
			<?php


		}

	}

	?>
	<h4>Friend list</h4>
	<div>
	<?php 
		$receiverquery = mysqli_query($con, "SELECT * FROM relationship WHERE receiver_name='$userLoggedIn' AND friendship_status= 'Accepted'");
		$senderquery = mysqli_query($con, "SELECT * FROM relationship WHERE sender_name='$userLoggedIn' AND friendship_status= 'Accepted'");
		if(mysqli_num_rows($receiverquery) == 0 && mysqli_num_rows($senderquery) == 0)
			echo "You have no friend at this time!";
		/*else if(mysqli_num_rows($receiverquery) == 0){
			while($row = mysqli_fetch_array($receiverquery)) {
				$user_from = $row['receiver_name'];
				$user_from_obj = new User($con, $user_from);
				$user_query = mysqli_query($con,"SELECT * FROM registered_employee WHERE profile_name='$user_from'");
				$row = mysqli_fetch_array($user_query);
				
				echo "<br><div class='search_result'>
	    
	    
					<div class='result_profile_pic'>
						<a href='" . $row['profile_name'] ."'><img src='". $row['profile_pic'] ."' style='height: 100px;'></a>
			    
					</div>
		    <a href='" . $row['profile_name'] ."'> " . $row['first_name'] . " " . $row['last_name'] . "
			    
				</div>";
			}
		}
		else if(mysqli_num_rows($senderquery) == 0){
			while($row = mysqli_fetch_array($receiverquery)) {
				$user_from = $row['sender_name'];
				$user_from_obj = new User($con, $user_from);
				$user_query = mysqli_query($con,"SELECT * FROM registered_employee WHERE profile_name='$user_from'");
				$row = mysqli_fetch_array($user_query);
				
				echo "<br><div class='search_result'>
				    
				    
					<div class='result_profile_pic'>
						<a href='" . $row['profile_name'] ."'><img src='". $row['profile_pic'] ."' style='height: 100px;'></a>
				    
					</div>
		    <a href='" . $row['profile_name'] ."'> " . $row['first_name'] . " " . $row['last_name'] . "
				    
				</div>";
			}
		}*/
		else{
			while($row = mysqli_fetch_array($receiverquery)) {
				$user_from = $row['sender_name'];
				$user_from_obj = new User($con, $user_from);
				
				
				
				$user_query = mysqli_query($con,"SELECT * FROM registered_employee WHERE profile_name='$user_from'");
				$row = mysqli_fetch_array($user_query);
				
				echo "<br><div class='search_result'>
			    
			    
					<div class='result_profile_pic'>
						<a href='" . $row['profile_name'] ."'><img src='". $row['profile_pic'] ."' style='height: 100px;'></a>
		    
					</div>
		    <a href='" . $row['profile_name'] ."'> " . $row['first_name'] . " " . $row['last_name'] . "
		    
				</div>";
				
				
				
				
			}
			while($row = mysqli_fetch_array($senderquery)) {
				$user_from = $row['receiver_name'];
				$user_from_obj = new User($con, $user_from);
				
				
				
				
				
				
				
				$user_query = mysqli_query($con,"SELECT * FROM registered_employee WHERE profile_name='$user_from'");
				$row = mysqli_fetch_array($user_query);
				
				echo "<br><div class='search_result'>
				    
				    
					<div class='result_profile_pic'>
						<a href='" . $row['profile_name'] ."'><img src='". $row['profile_pic'] ."' style='height: 100px;'></a>
		        
					</div>
		    <a href='" . $row['profile_name'] ."'> " . $row['first_name'] . " " . $row['last_name'] . "
					    
				</div>";
			}
		}
	?>
	</div>
	</div>
</div>
</div>

<?php
include 'includes/footer.php';
?>