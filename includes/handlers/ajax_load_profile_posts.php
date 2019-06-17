<?php
include("../../config/db_config.php");
include("../class/User.php");
include("../class/Post.php");

$limit = 10; //Number of posts to be loaded per call

$posts = new Post($con, $_REQUEST['userLoggedIn']);
echo ("<script>console.log(In ajax function);</script>");
$posts->loadProfilePosts($_REQUEST, $limit);
?>