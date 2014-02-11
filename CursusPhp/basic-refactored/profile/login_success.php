<?php

define('BASE_URL', '../');
require_once BASE_URL . 'includes/config/routes.php';
require_once config_url() . 'sessions.php';

?>
<!DOCTYPE html>
<html>
    <head>
        <title>Afsprakenplanner - Afspraken planner</title>
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