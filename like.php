<html>
<head>
	<title></title>
	<link rel="stylesheet" type="text/css" href="assets/css/style.css">
</head>
<body>

	<style type="text/css">
	* {
		font-family: Arial, Helvetica, Sans-serif;
	}
	body {
		background-color: #fff;
	}

	form {
		position: absolute;
		top: 0;
	}

	</style>



<?php
include "config/db_config.php";
include("includes/class/User.php");
include("includes/class/Post.php");

if (isset($_SESSION['profile_name'])) {
    $userLoggedIn = $_SESSION['profile_name'];
    $user_details_query = mysqli_query($con, "SELECT * FROM registered_employee WHERE profile_name='$userLoggedIn'");
    $user = mysqli_fetch_array($user_details_query);
}
else {
    header("Location: register.php");
}


//Get id of post
if(isset($_GET['post_id'])) {
    $post_id = $_GET['post_id'];
}

//Like button
if(isset($_POST['like_button'])) {
    $check_liked = mysqli_query($con, "SELECT * FROM likes WHERE  post_id='$post_id' and viewer_name='$userLoggedIn' ");
    $num_rows = mysqli_num_rows($check_liked);
    $row = mysqli_fetch_array($check_liked);
    echo ("<script>console.log(In likes" . $num_rows . ")</script>");
    if( $num_rows > 0)  {
        $like_id = $row['like_id'];
        $query = mysqli_query($con, "UPDATE likes SET deleted='no' WHERE like_id='$like_id'");
    } else {
        
        echo ("<script>console.log(inserting in like" . $like_id . ");</script>");
        $count_query = mysqli_query($con, "select count(*)  as curr_tot from likes");
        $row = mysqli_fetch_array($count_query);
        
        $like_id = 'like_'.++$row['curr_tot'];
        $date = date("Y-m-d"); // Current date
        $insert_likes = mysqli_query($con, "INSERT INTO likes VALUES('$like_id','$post_id',null,null,null,'$userLoggedIn','$date','no')");
    }
    
}


//Unlike button
//Like button
if(isset($_POST['unlike_button'])) {
    $check_liked = mysqli_query($con, "SELECT * FROM likes WHERE  post_id='$post_id' and viewer_name='$userLoggedIn'");
    $num_rows = mysqli_num_rows($check_liked);
    $row = mysqli_fetch_array($check_liked);
    echo ("<script>console.log(In unlikes" . $num_rows . ");</script>");
    if( $num_rows > 0) {
        $like_id = $row['like_id'];
        $query = mysqli_query($con, "UPDATE likes SET deleted='yes' WHERE like_id='$like_id'");
        echo ("<script>console.log(setting unlike" . $like_id . ");</script>");
    } else {
        echo ("<script>console.log(inserting in unlike" . $like_id . ");</script>");
        $count_query = mysqli_query($con, "select count(*)  as curr_tot from likes");
        $row = mysqli_fetch_array($count_query);
        
        $like_id = 'like_'.++$row['curr_tot'];
        $date = date("Y-m-d"); // Current date
        $insert_likes = mysqli_query($con, "INSERT INTO likes VALUES('$like_id','$post_id',null,null,null,'$userLoggedIn','$date','yes')");
    }
    
}

$get_likes = mysqli_query($con, "SELECT count(distinct like_id) as tot_likes FROM likes WHERE post_id='$post_id' and deleted='no'");
$row = mysqli_fetch_array($get_likes);
$total_likes = $row['tot_likes'];
#$user_liked = $row['added_by'];


$get_unlikes = mysqli_query($con, "SELECT count(distinct like_id) as tot_unlikes FROM likes WHERE post_id='$post_id' and deleted='yes'");
$row = mysqli_fetch_array($get_unlikes);
$total_unlikes = $row['tot_unlikes'];




//Check for previous likes
$like_query = mysqli_query($con, "SELECT * FROM likes WHERE  post_id='$post_id' and viewer_name='$userLoggedIn'");
$num_rows = mysqli_num_rows($like_query);
$check_query = mysqli_fetch_array($like_query);
echo ("<script>console.log(total likes" . $total_likes . ")</script>");
echo ("<script>console.log(total unlikes" . $total_unlikes . ")</script>");

    echo '<table><tr><td><div><form action="like.php?post_id=' . $post_id . '" method="POST">
				<input type="submit" class="comment_unlike" name="unlike_button" value="Unlike">
				<div class="like_value">
					' . $total_unlikes . '
				</div>
			</form></div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
		';
    
    echo '<td><div><form action="like.php?post_id=' . $post_id . '" method="POST">
				<input type="submit" class="comment_like" name="like_button" value="Like">
				<div class="like_value">
				' . $total_likes . '
				</div>
			</form></div></td></tr></table>
		';

    
    
    

?>
