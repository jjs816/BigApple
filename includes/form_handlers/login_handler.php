
<?php
include 'config/db_config.php';
include 'debugger.php';

$error_array = array(); // Holds error messages
if (isset($_POST['login_button'])) {
    
    $id = $_POST['login_id'];
    $password = $_POST['login_password'];
    
    $login_query = "select * from signin where profile_name = '$id' and password = '$password' ";
    
    $check_login_query = mysqli_query($con, $login_query);
   
    $is_account_exists = mysqli_num_rows($check_login_query);
    
    if( $is_account_exists == 1) {
        $row = mysqli_fetch_array($check_login_query);
        $profile = $row['profile_name'];

        $_SESSION['profile_name'] = $profile;
        header("Location: home.php");
        exit();
    }
    else {
        
        array_push($error_array,"Unable to login");
        debug_to_console($error_array);
    }
}

?>
