<?php
require '../../config/db_config.php';
include("../class/User.php");
include("../class/Post.php");
#BigApple


if(isset($_POST['post_body'])) {
    
    $post = new Post($con, $_POST['user_from']);
    $post->submitPost($_POST['post_body'], $_POST['user_to'], $_POST['privacy']);
}



?>