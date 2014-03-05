<?php

if(!isset($_SESSION))
    session_start();

class SessionHelper{
    public static function set_userdata($userdata) {
        $_SESSION['user'] = $userdata;
    }

    public static function userdata($field) {
        return isset($_SESSION['user']->$field) ? $_SESSION['user']->$field : '';
    }

    public static function unset_userdata() {
        unset($_SESSION['user']);
    }

    public static function loggedin() {
        return isset($_SESSION['user']);
    }
}