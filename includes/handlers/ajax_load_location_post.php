<?php
require '../../config/db_config.php';
include("../class/User.php");
include("../class/Post.php");

echo ("<script>console.log(In wall" . $_SERVER['REQUEST_METHOD'] . ")</script>");

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $userLoggedIn = $_SESSION['profile_name'];
    echo ("<script>console.log( $userLoggedIn )</script>");
    $posts = new Post($con, $userLoggedIn);
    $posts->submitLocationPost($_REQUEST, $userLoggedIn);
}


?>