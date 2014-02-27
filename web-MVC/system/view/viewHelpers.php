<?php

function baseUrl($uri = '')
{
    return str_replace('index.php', '', $_SERVER['SCRIPT_NAME']) . $uri;
}

function getCurrentPath()
{
    $path =  substr($_SERVER['REQUEST_URI'], strlen(dirname($_SERVER['SCRIPT_NAME'])) + 1);
    $path = trim($path, '/');

    // if no scriptfile in de request_uri, we assume index.php is called
    $path = ($path) ? $path : 'index.php';

    return $path;
}
