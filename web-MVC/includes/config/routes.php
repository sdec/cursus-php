<?php

/** Path functions * */
function base_url($uri = '') {
    return str_replace('index.php', '', '../..'.$_SERVER['SCRIPT_NAME']) . $uri;
}

function getCurrentPath()
{
    $rawpath =  substr($_SERVER['REQUEST_URI'], strlen(dirname($_SERVER['SCRIPT_NAME'])) + 1);
    $trimmedpath = trim($rawpath, '/');

    // if no scriptfile in de request_uri, we assume index.php is called
    $path = ($trimmedpath) ? $trimmedpath : 'index.php';

    return $path;
}

function assets_url() {
    return base_url() . 'afsprakenplanner/view/assets/';
}

function partials_url() {
    return base_url() . 'afsprakenplanner/view/partials/';
}

function config_url() {
    return base_url() . 'includes/config/';
}

function helpers_url() {
    return base_url() . 'includes/helpers/';
}

function models_url() {
    return base_url() . 'afsprakenplanner/model/';
}

function views_url(){
    return base_url() . 'afsprakenplanner/view/';
}

function redirect($page) {
    header('Location: ' . base_url() . $page);
    die;
}
