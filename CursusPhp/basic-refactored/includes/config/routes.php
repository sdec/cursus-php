<?php

/** Path functions * */
function base_url() {
    return BASE_URL;
}

function assets_url() {
    return base_url() . 'assets/';
}

function partials_url() {
    return base_url() . 'includes/partials/';
}

function config_url() {
    return base_url() . 'includes/config/';
}

function helpers_url() {
    return base_url() . 'includes/helpers/';
}

function models_url() {
    return base_url() . 'includes/models/';
}

function redirect($page) {
    header('Location: ' . base_url() . $page);
    die;
}
