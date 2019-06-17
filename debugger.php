<?php
function debug_to_console($data) {
    if(is_array($data))
    {
        echo("<script>console.log('PHP: ".implode(',', $data)."');</script>");
    } else {
        echo("<script>console.log('PHP: ".$data."');</script>");
    }
}

?>