<?php

define('BASE_URL', './');
require_once BASE_URL . 'includes/config/routes.php';
require_once config_url()   . 'sessions.php';

if(!loggedin())
    redirect('profile/login.php');

?>
<!DOCTYPE html>
<html>
    <head>
        <title>Afspraken - Afspraken planner</title>
        <?php include_once partials_url() . 'header.php' ?>
    </head>
    <body>
        <?php include_once partials_url() . 'navigation.php' ?>
        <div class="container">
            
            <?php include_once partials_url() . 'message.php' ?>
        </div>
        <?php include_once partials_url() . 'scripts.php' ?>
    </body>
</html>