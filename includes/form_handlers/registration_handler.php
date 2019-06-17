<?php
$fname = ""; //First name
$lname = ""; //Last name
$em = "";
$em2 = "";
$pwd = "";
$pwd2 = "";
$ssn = "";
$date = "";
$error_array = array(); // Holds error messages

if (isset($_POST['register_button'])) {
    
    //First name
    $fname = strip_tags($_POST['reg_fname']); //Remove html tags
    $fname = str_replace(' ', '', $fname); //remove spaces
    $fname = ucfirst(strtolower($fname)); //Uppercase first letter
    $_SESSION['reg_fname'] = $fname; //Stores first name into session variable
    
    //Last name
    $lname = strip_tags($_POST['reg_lname']); //Remove html tags
    $lname = str_replace(' ', '', $lname); //remove spaces
    $lname = ucfirst(strtolower($lname)); //Uppercase first letter
    $_SESSION['reg_lname'] = $lname; //Stores last name into session variable
    
    
    // email
    $em = strip_tags($_POST['reg_email']); // Remove html tags
    $em = str_replace(' ', '', $em); // remove spaces
    $em = strtolower($em);
    $_SESSION['reg_email'] = $em; // Stores email into session variable
                                  
    // email 2
    $em2 = strip_tags($_POST['reg_email2']); // Remove html tags
    $em2 = str_replace(' ', '', $em2); // remove spaces
    $em2 = strtolower($em2);
    $_SESSION['reg_email2'] = $em2; // Stores email2 into session variable
                                    
    // Password
    $pwd = strip_tags($_POST['reg_password']); // Remove html tags
    $pwd2 = strip_tags($_POST['reg_password2']); // Remove html tags
    
    $ssn = strip_tags($_POST['reg_ssn']); // Remove html tags
    $ssn = str_replace(' ', '', $ssn); // remove spaces
    $_SESSION['reg_ssn'] = $ssn; // Stores email into session variable
    
    $profile_id = strstr($em, '@', true);
    debug_to_console($profile_id);
    
    $date = date("Y-m-d"); // Current date
    debug_to_console($date);
    
    if ($em == $em2) {
        // Check if email is in valid format
        if (! filter_var($em, FILTER_VALIDATE_EMAIL)) {
            array_push($error_array, "Invalid email format<br>");
        }
    } else {
        array_push($error_array, "Emails don't match<br>");
    }
    
    if(strlen($fname) > 25 || strlen($fname) < 2) {
        array_push($error_array, "Your first name must be between 2 and 25 characters<br>");
    }
    
    if(strlen($lname) > 25 || strlen($lname) < 2) {
        array_push($error_array,  "Your last name must be between 2 and 25 characters<br>");
    }
    
    if ($pwd != $pwd2) {
        array_push($error_array, "Your passwords do not match<br>");
    } else {
        if (preg_match('/[^A-Za-z0-9]/', $password)) {
            array_push($error_array, "Your password can only contain english characters or numbers<br>");
        }
    }
    
    if (preg_match('/[^0-9]/', $ssn) and (strlen($ssn) == 10)) {
        array_push($error_array, "Invalid SSN <br>");
    }
    
    $query_emp = "select * from employee where email_id = '$em' and ssn = $ssn";
    $is_emp_exists = mysqli_query($con, $query_emp);
    if (mysqli_num_rows($is_emp_exists) != 1) {
        //debug_to_console($is_emp_exists);
        array_push($error_array, "User does not exists in the employee directory");
    }
    debug_to_console($profile_id);
    $profile_check = mysqli_query($con, "SELECT * FROM signin WHERE profile_name='$profile_id'");
    $num_rows = mysqli_num_rows($profile_check);
    
    if ($num_rows > 0) {
        debug_to_console($num_rows);
        array_push($error_array, "Profile Exists<br>");
    }
    
    if (empty($error_array)) {
        $created = FALSE;
        $query = "CALL insert_signin_details('" . $ssn . "','" . $pwd . "','" . $profile_id . "')";
        if (mysqli_query($con, $query)) {
            debug_to_console('successfully inserted into signin');
            $created = TRUE;
        } else {
            array_push($error_array, "Failed to create user");
        }
        
        if ($created) {
            $query = "CALL insert_profile_id('". $profile_id ."','" . $em . "','".$fname. "','". $lname . "','" . $date . "')";
            
            if(mysqli_query($con, $query)){
                array_push($error_array, "<span style='color: #14C800;'>You're all set! Go ahead and login!</span><br>");
          }
        }
            // Clear session variables
            $_SESSION['reg_fname'] = "";
            $_SESSION['reg_lname'] = "";
            $_SESSION['reg_email'] = "";
            $_SESSION['reg_email2'] = "";
            $_SESSION['reg_ssn'] = "";
        }
    
}