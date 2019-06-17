<?php 
include("includes/header.php");
include("includes/form_handlers/settings_handler.php");
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

	<h4>Account Settings</h4>
	<?php
	echo "<img src='" . $user['profile_pic'] ."' class='small_profile_pic'>";
	?>
	<br>
	<a href="upload.php">Upload new profile picture</a> <br><br><br>

	Modify the values and click 'Update Details'

	<?php
	$user_data_query = mysqli_query($con, "SELECT * FROM registered_employee WHERE profile_name='$userLoggedIn'");
	$row = mysqli_fetch_array($user_data_query);

	$first_name = $row['first_name'];
	$last_name = $row['last_name'];
	$address = $row['address'];
	$designation = $row['designation'];
	$skills=$row['skills'];
	$interests = $row['interests'];
	$manager = $row['manager'];
	$gender = $row['gender'];
	$email = $row['email_id'];
	?>

	<form action="settings.php" method="POST">
		First Name: <input type="text" name="first_name" value="<?php echo $first_name; ?>" id="settings_input"><br>
		Last Name: <input type="text" name="last_name" value="<?php echo $last_name; ?>" id="settings_input"><br>
		Email: <input type="text" name="email" value="<?php echo $email; ?>" id="settings_input" readonly><br>
		Designation: <input type="text" name="designation" value="<?php echo $designation; ?>" id="settings_input"><br>
		Skills: &nbsp;&nbsp;&nbsp;&nbsp;<textarea rows="2" cols="40"  name="skills" ><?php echo $skills; ?> </textarea><br>
		Manager: <input type="text" name="manager" value="<?php echo $manager; ?>" id="settings_input"><br>
		Gender: <input type="text" name="gender" value="<?php echo $gender; ?>" id="settings_input"><br>
		Address: &nbsp;&nbsp;&nbsp;&nbsp;<textarea rows="2" cols="40"  name="address" ><?php echo $address; ?> </textarea><br>		
		<?php echo $message; ?>

		<input type="submit" name="update_details" id="save_details" value="Update Details" class="info settings_submit"><br>
	</form>

	<h4>Change Password</h4>
	<form action="settings.php" method="POST">
		Old Password: <input type="password" name="old_password" id="settings_input"><br>
		New Password: <input type="password" name="new_password_1" id="settings_input"><br>
		New Password Again: <input type="password" name="new_password_2" id="settings_input"><br>

		<?php echo $password_message; ?>

		<input type="submit" name="update_password" id="save_details" value="Update Password" class="info settings_submit"><br>
	</form>


</div>

</div>
</div>


  <?php
include 'includes/footer.php';
?>