<?php

define('BASE_URL', '../');
require_once BASE_URL . 'includes/helpers/routes_helper.php';
require_once helpers_url() . 'sessions_helper.php';

if(!loggedin())
    redirect('index.php');

unset_userdata('user');
redirect('profile/logout_success.php');