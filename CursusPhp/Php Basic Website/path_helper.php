<?php
define('APP_PATH', '/cursus-php/CursusPhp/Php Basic Website/');

function base_url() {
    return 'http://' . $_SERVER['HTTP_HOST'] . APP_PATH;
    /*if (isset($_SERVER['HTTP_HOST'])) {
        $base_url = isset($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) !== 'off' ? 'https' : 'http';
        $base_url .= '://' . $_SERVER['HTTP_HOST'];
        $base_url .= str_replace(basename($_SERVER['SCRIPT_NAME']), '', $_SERVER['SCRIPT_NAME']);
    } else {
        $base_url = 'http://localhost/';
    }
    return $base_url;*/
}

function local_url(){
    $cutDelim = "CursusPhp/Php Basic Website/";
    return ($variable = substr($_SERVER['SCRIPT_FILENAME'], 0, strpos($_SERVER['SCRIPT_FILENAME'], $cutDelim)) . $cutDelim);
}

function assets_url() {
    return base_url() . 'assets/';
}

function partials_url() {
    return local_url() . 'partials/';
}

function includes_url() {
    return local_url() . 'system/includes/';
}

//include_once(local_url() . 'system/functions.php');