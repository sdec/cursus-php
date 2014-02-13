<?php

define('BASE_URL', '../');
require_once BASE_URL . 'includes/config/routes.php';
require_once config_url() . 'sessions.php';
require_once config_url() . 'database.php';
require_once models_url() . 'UserModel.php';

$user = ($_GET['username']) ? loadUser($_GET['username']) : loadUser(userdata('username'));

var_dump($user);

?>
<!DOCTYPE html>
<html>
    <head>
        <title>Profiel bekijken - Afspraken planner</title>
        <?php include_once partials_url() . 'header.php' ?>
    </head>
    <body>
        <?php include_once partials_url() . 'navigation.php' ?>
        <div class="container">

            <h1>Profiel</h1>
            <table class="table table-hover table-striped table-vertical">
                <tr>
                    <td>Gebruikersnaam</td>
                    <td><?= $user['username'];?></td>
                </tr>
                <tr>
                    <td>Voornaam</td>
                    <td><?= $user['firstname'];?></td>
                </tr>
                <tr>
                    <td>Familienaam</td>
                    <td><?= $user['lastname'];?></td>
                </tr>
                <tr>
                    <td>Email adres</td>
                    <td><a href="mailto:<?= $user['email'];?>"><?= $user['email'];?></a></td>
                </tr>
                <tr>
                    <td>Type profiel</td>
                    <td><?= accessLevelName($user['accesslevel']);?></td>
                </tr>
            </table>
            
            <?php include_once partials_url() . 'message.php' ?>
        </div>
        <?php include_once partials_url() . 'scripts.php' ?>
    </body>
</html>