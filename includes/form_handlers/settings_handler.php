<?php  
if(isset($_POST['update_details'])) {

	$first_name = $_POST['first_name'];
	$last_name = $_POST['last_name'];
	$designation = $_POST['designation'];
	$manager = $_POST['manager'];
	$skills= $_POST['skills'];
	$address = $_POST['address'];
	$gender = $_POST['gender'];
	
	$matched_user = $userLoggedIn;
	$message = "Details updated!<br><br>";
	$query = mysqli_query($con, "UPDATE registered_employee SET first_name='$first_name', last_name='$last_name',designation='$designation',manager='$manager',skills='$skills',address='$address',gender='$gender' WHERE profile_name='$userLoggedIn'");
	
}
else 
	$message = "";


//**************************************************

if(isset($_POST['update_password'])) {

	$old_password = strip_tags($_POST['old_password']);
	$new_password_1 = strip_tags($_POST['new_password_1']);
	$new_password_2 = strip_tags($_POST['new_password_2']);

	$password_query = mysqli_query($con, "SELECT password FROM signin WHERE profile_name='$userLoggedIn'");
	$row = mysqli_fetch_array($password_query);
	$db_password = $row['password'];
	
	if($old_password == $db_password) {

		if($new_password_1 == $new_password_2) {


			if(strlen($new_password_1) <= 4) {
				$password_message = "Sorry, your password must be greater than 4 characters<br><br>";
			}	
			else {
				$new_password_md5 = $new_password_1;
				$password_query = mysqli_query($con, "UPDATE signin SET password='$new_password_md5' WHERE profile_name='$userLoggedIn'");
				$password_message = "Password has been changed!<br><br>";
			}


		}
		else {
			$password_message = "Your two new passwords need to match!<br><br>";
		}

	}
	else {
			$password_message = "The old password is incorrect! <br><br>";
	}

}
else {
	$password_message = "";
}
?>