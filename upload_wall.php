<?php
# BigApple
require 'config/db_config.php';
include ("includes/class/User.php");
include  ("includes/class/Post.php");


if (isset($_SESSION['profile_name'])) {
    $userLoggedIn = $_SESSION['profile_name'];
    $user_details_query = mysqli_query($con, "SELECT * FROM registered_employee WHERE profile_name='$userLoggedIn'");
    $user = mysqli_fetch_array($user_details_query);
    $name= $user['first_name'];
}
else {
    header("Location: home.php");
}

if(isset($_POST["submit_pic"])) {
    
    echo ("<script>console.log(In wall" . $img_title . ")</script>");
    $img_title = strip_tags($_POST['image_title']);
    echo ("<script>console.log(In upload images" . $img_title . ")</script>");
    
    
    $file = rand(1000,100000)."-".$_FILES['fileToUpload']['name'];
    $file_loc = $_FILES['fileToUpload']['tmp_name'];
    //$file_size = $_FILES['file']['size'];
    //$file_type = $_FILES['file']['type'];
    $folder="Upload/";
    
    
    
    $date=date("Y-m-d H:i:s");
    
    move_uploaded_file($file_loc,$folder.$file);
    $src=$folder.$file;
    $img="<img src=\'".$src."\'width=300</img>";
    
    // Current date and time
    $date_added = date("Y-m-d H:i:s");
    
    
    // Inserting into wall
    $count_query = mysqli_query($con, "select count(*)  as curr_tot from wall");   
    $row = mysqli_fetch_array($count_query);   
    $post_id = 'post_' . ++ $row['curr_tot'];
    
    $query = mysqli_query($con, "INSERT INTO post VALUES('$post_id', '$date_added','','Multimedia','P')");

    $add_post_to_wall = mysqli_query($con, "INSERT INTO wall VALUES('$post_id','$userLoggedIn','no','P')");
    
    
    
    // Inserting into multimedia_content table
    $count_multimedia_row = mysqli_query($con, "select count(*)  as curr_tot from multimedia_content");
    $row = mysqli_fetch_array($count_multimedia_row);
    $multimedia_id = 'mul_' . ++ $row['curr_tot'];
    
    $add_multimedia_sql=mysqli_query($con,"INSERT INTO multimedia_content VALUES('$multimedia_id','$post_id','$img_title','jpg','$img','P','no')");
    
    header("Location: home.php");
    
}

?>