<?php

define('BASE_URL', '../');
require_once BASE_URL . 'includes/config/routes.php';
require_once config_url() . 'sessions.php';
require_once config_url() . 'database.php';
require_once models_url() . 'UserModel.php';

$user = (isset($_GET['username'])) ? loadUser($_GET['username']) : loadUser(userdata('username'));

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
            
            <?php if ($user->accesslevel < $this->session->userdata('user')->accesslevel) { ?>
                <?php if ($this->session->userdata('user')->accesslevel >= ADVISOR) { ?>
                    <hr />
                    <a href="<?= base_url() ?>admin/act_as/<?= $user->username ?>" class="btn btn-primary">
                        <span class="glyphicon glyphicon-user"></span> 
                        Handel in naam van deze gebruiker
                    </a>
                    <?php if ($this->session->userdata('user')->accesslevel >= ADMIN) { ?>

                        <a href="<?= base_url() ?>admin/edituser/<?= $user->username ?>" class="btn btn-primary">
                            <span class="glyphicon glyphicon-edit"></span> 
                            Wijzig gebruiker
                        </a> 
                        <a href="<?= base_url() ?>admin/deleteuser/<?= $user->username ?>" class="btn btn-danger">
                            <span class="glyphicon glyphicon-remove-sign"></span> 
                            Verwijder gebruiker
                        </a>
                    <?php } ?>
                <?php } ?>
            <?php } ?>
            
            <?php include_once partials_url() . 'message.php' ?>
        </div>
        <?php include_once partials_url() . 'scripts.php' ?>
    </body>
</html>