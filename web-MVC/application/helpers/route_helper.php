<?php

function getCurrentPath()
{
    $rawpath =  substr($_SERVER['REQUEST_URI'], strlen(dirname($_SERVER['SCRIPT_NAME'])) + 1);
    $trimmedpath = trim($rawpath, '/');

    // if no scriptfile in de request_uri, we assume index.php is called
    $path = ($trimmedpath) ? $trimmedpath : 'index.php';

    return $path;
}

function base_url() {
    return BASE_URL;
}

function external_url() {
    $app_path = '/cursus-php/web-MVC/';
    return 'http://' . $_SERVER['HTTP_HOST'] . $app_path;
}

function assets_url() {
    return external_url() . 'assets/';
}

function partials_url() {
    return base_url() . 'application/view/partials/';
}

function config_url() {
    return base_url() . 'application/config/';
}

function helpers_url() {
    return base_url() . 'application/helpers/';
}

function models_url() {
    return base_url() . 'application/model/';
}

function views_url(){
    return base_url() . 'application/view/';
}

function redirect($page) {
    header('Location: ' . external_url() . $page);
    die;
}
