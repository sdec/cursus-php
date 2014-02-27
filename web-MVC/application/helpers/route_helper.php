<?php

function base_url() {
    return BASE_URL;
}

function assets_url() {
    return base_url() . 'assets/';
}

function partials_url() {
    return APPLICATION_PATH . 'view/partials/';
}

function config_url() {
    return APPLICATION_PATH . 'config/';
}

function helpers_url() {
    return APPLICATION_PATH . 'helpers/';
}

function models_url() {
    return APPLICATION_PATH . 'model/';
}

function views_url(){
    return APPLICATION_PATH . 'view/';
}

function redirect($location)
{
    header('location: ' . BASE_URL . $location);
    exit;
}