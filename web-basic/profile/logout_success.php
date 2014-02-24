<?php

define('BASE_URL', '../');
require_once BASE_URL . 'includes/helpers/routes_helper.php';
require_once helpers_url() . 'sessions_helper.php';

?>
<!DOCTYPE html>
<html>
    <head>
        <title>Log out - Afspraken planner</title>
        <?php include_once partials_url() . 'header.php' ?>
    </head>
    <body>
        <?php include_once partials_url() . 'navigation.php' ?>
        <div class="container">

            <h1>Log out</h1>
            <p>U bent nu uitgelogd.</p>
            <p><a class="btn btn-primary" href="<?= base_url()?>">Ok</a></p>
            
            <?php include_once partials_url() . 'message.php' ?>
        </div>
        <?php include_once partials_url() . 'scripts.php' ?>
    </body>
</html>