<?php

class RouteHelper{

    public static function base_url() {
        return BASE_URL;
    }

    public static function assets_url() {
        return RouteHelper::base_url() . 'assets/';
    }

    public static function partials_url() {
        return APPLICATION_PATH . 'view/partials/';
    }

    public static function config_url() {
        return APPLICATION_PATH . 'config/';
    }

    public static function helpers_url() {
        return APPLICATION_PATH . 'helpers/';
    }

    public static function models_url() {
        return APPLICATION_PATH . 'model/';
    }

    public static function views_url(){
        return APPLICATION_PATH . 'view/';
    }

    public static function redirect($location)
    {
        header('location: ' . BASE_URL . $location);
        exit;
    }

}