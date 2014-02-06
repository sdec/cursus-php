<?php



function base_url(){
    return $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
}

function local_url(){
    $cutDelim = "cursus-php/CursusPhp/Php Basic Website/";
    return ($variable = substr($_SERVER['SCRIPT_FILENAME'], 0, strpos($_SERVER['SCRIPT_FILENAME'], $cutDelim)) . $cutDelim);
}

function host_url(){
    //$urlPieces = explode('/', $_SERVER['PHP_SELF']);
    //$page = $urlPieces();
    //return str_replace("path_helper.php", "", $_SERVER['PHP_SELF']);
    //return $_SERVER['HTTP_HOST'] . '/cursus-php/CursusPhp/Php Basic Website/';
    
}

function assets_url(){
    return host_url() . 'assets/';
}

function partials_url(){
    return local_url() . 'partials/';
}
?>
