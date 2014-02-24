<?php

define('BASE_URL', '../');
require_once BASE_URL . 'includes/helpers/routes_helper.php';
require_once helpers_url() . 'sessions_helper.php';

?>
<!DOCTYPE html>
<html>
    <head>
        <title>Log in - Afspraken planner</title>
        <?php include_once partials_url() . 'header.php' ?>
    </head>
    <body>
        <?php include_once partials_url() . 'navigation.php' ?>
        <div class="container">

            <h1>Welkom, <?= userdata('firstname') ?> 
                    <?= userdata('lastname') ?> 
                    (<?= userdata('username') ?>)</h1>
            <p>U bent nu ingelogd.</p>
            <p><a class="btn btn-primary" href="<?= base_url() ?>">Ok</a></p>
            
            <?php include_once partials_url() . 'message.php' ?>
        </div>
        <?php include_once partials_url() . 'scripts.php' ?>
    </body>
</html>