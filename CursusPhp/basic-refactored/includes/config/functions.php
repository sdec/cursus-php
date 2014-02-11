<?php
if(!isset($_SESSION)) session_start();

//Acceptable ids : success, info, warning & danger
function flashmessage($message, $id="success"){
    array_push($_SESSION['flashmessages'], array(
    'id' => $id,
    'message' => $message
));
    //$_SESSION['flashmessages'] = array($id => $message);
}

function redirect($page, $message = null, $id="success"){
    header("Location: " . base_url() . $page);//, 303); //301 "Moved permanently", 302 (default) "Found", 303 "Moved temporarily"
    if($message){flashmessage($message, $id);}
    die(); //Force ending transmission of the potentially unauthorized webpage server-side
}

?>