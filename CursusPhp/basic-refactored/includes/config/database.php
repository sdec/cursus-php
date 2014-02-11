<?php

define('SQL_USER', 'root');
define('SQL_HOST', 'localhost');
define('SQL_PASS', '');
define('SQL_DB', 'cursusphp');


// Start database connection
$link = mysqli_connect(SQL_HOST, SQL_USER, SQL_PASS, SQL_DB) or die(mysql_error());

function DB_Link() {
    global $link;
    return $link;
}

function sanitize($input) {
    global $link;
    if (is_array($input)) {
        $arr = array();
        foreach ($input as $element) {
            $arr[] = mysqli_real_escape_string($link, $element);
        }
        return $arr;
    }
    return mysqli_real_escape_string($link, $input);
}