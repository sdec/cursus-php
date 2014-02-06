<?php

define('APP_PATH', '/cursus-php/CursusPhp/Php Basic Website/');

function base_url() {
    return $_SERVER['HTTP_HOST'] . APP_PATH;
}

function assets_url() {
    return base_url() . 'assets/';
}

function partials_url() {
    return base_url() . 'partials/';
}