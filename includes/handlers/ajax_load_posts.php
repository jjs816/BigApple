<?php
include "../../config/db_config.php";
include ("../class/User.php");
include ("../class/Post.php");

$limit = 8; // Number of posts to be loaded per call
$posts = new Post($con, $_REQUEST['userLoggedIn']);
$posts->loadPostsFriends($_REQUEST, $limit);
?>
