<?php
require '../../config/db_config.php';


if(isset($_GET['post_id']))
    $post_id = $_GET['post_id'];
    echo("<script>console.log(Inside the delete method".$post_id.");</script>");
    
    if(isset($_POST['result'])) {
        if($_POST['result'] == 'true')
            $query = mysqli_query($con, "UPDATE wall SET deleted='yes' WHERE post_id='$post_id'");
            
    }
    
?>