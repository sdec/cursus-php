<?php
define('BASE_URL', '../');
require_once BASE_URL . 'includes/config/routes.php';
require_once config_url() . 'sessions.php';
require_once config_url() . 'database.php';
require_once models_url() . 'UserModel.php';

if (!loggedin())
    redirect('profile/login.php');

if (userdata('accesslevel') < ADMIN)
    redirect('admin/users.php');

if(!isset($_GET['username']))
    redirect('admin/users.php');

$user = loadUser($_GET['username']);
if ($user == FALSE)
    redirect('admin/users.php');

if ($user['accesslevel'] >= userdata('accesslevel'))
    redirect('profile/view.php?username=' . $user['username']);

// Store my old session
$_SESSION['act'] = $_SESSION['user'];

// Set the new session
set_userdata($user);

redirect('');