<?php

define('BASE_URL', '../');
require_once BASE_URL . 'includes/config/routes.php';
require_once config_url()   . 'sessions.php';

if(!loggedin())
    redirect('index.php');

unset_userdata('user');
redirect('profile/logout_success.php');