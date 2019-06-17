<?php
include ("config/db_config.php");
include 'includes/form_handlers/login_handler.php';
include 'includes/form_handlers/registration_handler.php';

?>
<html>
<head>
<title>BigApple</title>
<link rel="stylesheet" type="text/css" href="assets/css/register.css">
<script
	src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="assets/js/utilities.js"></script>
</head>
<body>

<?php

if (isset($_POST['register_button'])) {
    echo '
		<script>

		$(document).ready(function() {
			$("#login_first").hide();
			$("#login_second").show();
		});

		</script>

		';
}

?>
	
	
	<div class=main>
		<div class="wrapper">
			<div class="login_box">
				<div class="login_header">
					<h1>
						<span>Big</span>Apple
						<small>Share and Collaborate</small>
					</h1>
				</div>
				<div id="login_first">
					<form action="index.php" method="POST">

						<input type="text" name="login_id" placeholder="BigApple ID"
							value="<?php
    if (isset($_SESSION['log_id'])) {
        echo $_SESSION['log_id'];
    }
    ?>"
							required>
						<br>
						<input type="password" name="login_password"
							placeholder="Password" required>
						<br>
					<?php 
					debug_to_console($error_array);
					if(in_array("Unable to login", $error_array)) {
					    echo  "Signin Failed. Try again <br>"; 
					}
					?>	
					<input type="submit" name="login_button" value="Login">
						<br>
						<a href="#" id="signup" class="signup">Register New Account</a>

					</form>

				</div>

				<div id="login_second">

					<form action="index.php" method="POST">

						<input type="text" name="reg_fname" placeholder="First Name"
							value="<?php
    if (isset($_SESSION['reg_fname'])) {
        echo $_SESSION['reg_fname'];
    }
    ?>"
							required>
						<br>
					<?php if(in_array("Your first name must be between 2 and 25 characters<br>", $error_array)) echo "Your first name must be between 2 and 25 characters<br>"; ?>
					
					


					<input type="text" name="reg_lname" placeholder="Last Name"
							value="<?php
    if (isset($_SESSION['reg_lname'])) {
        echo $_SESSION['reg_lname'];
    }
    ?>"
							required>
						<br>
					<?php if(in_array("Your last name must be between 2 and 25 characters<br>", $error_array)) 
					    echo "Your last name must be between 2 and 25 characters<br>"; ?>

						<input type="email" name="reg_email" placeholder="Email"
							value="<?php
    if (isset($_SESSION['reg_email'])) {
        echo $_SESSION['reg_email'];
    }
    ?>"
							required>
						<br>
						<input type="email" name="reg_email2" placeholder="Confirm Email"
							value="<?php
    if (isset($_SESSION['reg_email2'])) {
        echo $_SESSION['reg_email2'];
    }
    ?>"
							required>
						<br>
					<?php
    
    if (in_array("Invalid email format<br>", $error_array))
        echo "Invalid email format<br>";
    else if (in_array("Emails don't match<br>", $error_array))
        echo "Emails don't match<br>";
    ?>


					<input type="password" name="reg_password" placeholder="Password"
							required>
						<br>
						<input type="password" name="reg_password2"
							placeholder="Confirm Password" required>
						<br>
					<?php
    
    if (in_array("Your passwords do not match<br>", $error_array))
        echo "Your passwords do not match<br>";
    else if (in_array("Your password can only contain english characters or numbers<br>", $error_array))
        echo "Your password can only contain english characters or numbers<br>";
    else if (in_array("Your password must be betwen 5 and 30 characters<br>", $error_array))
        echo "Your password must be betwen 5 and 30 characters<br>";
    ?>
						<input type="text" name="reg_ssn" placeholder="SSN"
							value="<?php
    if (isset($_SESSION['reg_ssn'])) {
        echo $_SESSION['reg_ssn'];
    }
    ?>"
							required>
						<br>
						<?php
    if (in_array("Invalid SSN <br>", $error_array))
        echo "Invalid SSN<br>";
    
    ?>
											
						<input type="submit" name="register_button" value="Register">
						<br>
					<?php
    if (in_array("User does not exists in the employee directory", $error_array))
        echo "Contact HR for permissions<br>";
    elseif (in_array("Profile Exists<br>", $error_array))
        echo "Profile exists. Please sign in.<br>";
    elseif (in_array("Failed to create user", $error_array))
        echo "Failed to create profile. Contact DB adminstrator<br>";
    
    elseif (in_array("<span style='color: #14C800;'>You're all set! Go ahead and login!</span><br>", $error_array))
        echo "<span style='color: #14C800;'>You're all set! Go ahead and login!</span><br>";
    ?>
					<a href="#" id="signin" class="signin">Already have an account?
							Sign in here!</a>
					</form>
				</div>


			</div>
		</div>
	</div>

</html>