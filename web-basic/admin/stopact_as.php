<?php
define('BASE_URL', '../');
require_once BASE_URL . 'includes/helpers/routes_helper.php';
require_once helpers_url() . 'sessions_helper.php';
require_once config_url() . 'database.php';
require_once helpers_url() . 'database_helper.php';
require_once models_url() . 'UserModel.php';

if (!loggedin())
    redirect('profile/login.php');

if (!isset($_SESSION['act']))
    redirect(base_url());

$username = $_SESSION['act']['username'];
unset_userdata();
unset($_SESSION['act']);

set_userdata(loadUser($username));
redirect('');