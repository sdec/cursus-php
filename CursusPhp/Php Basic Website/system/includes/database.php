<?php
$link = 0;

function DB_Connect(){
    global $link;
    $link = new mysqli("localhost", "admin", "", "test");//mysqlhost, username & password
    /* check connection */
    if (mysqli_connect_errno()) {
        printf("Connect failed: %s\n", mysqli_connect_error()); 
        exit();
    }
}

function DB_Close() {
    global $link;
    mysqli_close($link);
}

function DB_Link() {
    global $link;
    return $link;
}

function sql_sanitize($input){
    global $link;
    if(is_array($input)){
        $arr = array();
        foreach($input as $element){
            $arr[] = mysqli_real_escape_string($link, $element);
        }
        return $arr;
    }
    return mysqli_real_escape_string($link, $input);
}