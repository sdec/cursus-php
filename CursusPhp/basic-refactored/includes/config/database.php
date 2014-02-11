<?php

define('SQL_USER', 'root');
define('SQL_HOST', 'localhost:81');
define('SQL_PASS', '');
define('SQL_DB', 'cursusphp');


// Database functions
$link = null;
function DB_Connect(){
    global $link;
    $link = new mysqli(SQL_HOST, SQL_USER, SQL_PASS, SQL_DB)
        or die('Database connection failed.');
}

function DB_Close() {
    global $link;
    mysqli_close($link);
}

function DB_Link() {
    global $link;
    return $link;
}

function sanitize($input) {
    global $link;
    if(is_array($input)) {
        $arr = array();
        foreach($input as $element){
            $arr[] = mysqli_real_escape_string($link, $element);
        }
        return $arr;
    }
    return mysqli_real_escape_string($link, $input);
}