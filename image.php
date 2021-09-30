<?php if (substr($_GET['url'],-4) == '.pdf') {
    header("Content-type: application/pdf"); 
    readfile($_GET['url']);
}elseif(substr($_GET['url'],-4) == '.mp4'){
header('Content-Type: video/mp4');
echo file_get_contents($_GET['url']);
}else{
    header('Content-Type: image'); 
    echo file_get_contents($_GET['url']);
}
?>