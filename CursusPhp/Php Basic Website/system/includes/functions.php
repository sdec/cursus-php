<?php
if(!isset($_SESSION)) session_start();
include_once(includes_url() . 'form_helper.php');

function redirect($page){
    header("Location: " . base_url() . $page);//, 303); //301 "Moved permanently", 302 (default) "Found", 303 "Moved temporarily"
    die(); //Force ending transmission of the potentially unauthorized webpage server-side
}

?>