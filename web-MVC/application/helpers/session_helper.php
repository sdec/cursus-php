<?php

if(!isset($_SESSION))
    session_start();

function set_userdata($userdata) {
    $_SESSION['user'] = $userdata;
}

function userdata($field) {
    return isset($_SESSION['user']->$field) ? $_SESSION['user']->$field : '';
}

function unset_userdata() {
    unset($_SESSION['user']);
}

function loggedin() {
    return isset($_SESSION['user']);
}