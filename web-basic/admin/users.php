<?php
define('BASE_URL', '../');
require_once BASE_URL . 'includes/helpers/routes_helper.php';
require_once helpers_url() . 'sessions_helper.php';
require_once config_url() . 'database.php';
require_once helpers_url() . 'database_helper.php';
require_once models_url() . 'UserModel.php';

if (!loggedin())
    redirect('profile/login.php');

if (userdata('accesslevel') < LECTURER)
    redirect('');

$search = isset($_GET['search']) ? $_GET['search'] : '';

$users = strlen($search) ? searchUsers($search) : loadAllUsers();

?>
<!DOCTYPE html>
<html>
    <head>
        <title>Gebruikers - Afspraken planner</title>
        <?php include_once partials_url() . 'header.php' ?>
    </head>
    <body>
        <?php include_once partials_url() . 'navigation.php' ?>
        <div class="container">

            <h1>Gebruikers</h1>
            <table class="table table-hover table-striped">
                <thead>
                    <tr>
                        <td></td>
                        <td>Voornaam</td>
                        <td>Familienaam</td>
                        <td>Gebruikersnaam</td>
                        <td>Email</td>
                        <td>Type profiel</td>
                    </tr>
                </thead>
                <tbody>
                    <?php if($users != FALSE) { ?>
                        <?php foreach($users as $user) { ?>
                            <tr>
                                <td><a href="<?= base_url() ?>profile/view.php?username=<?= $user['username'] ?>"><span class="glyphicon glyphicon-eye-open"></span></a></td>
                                <td><?= ucfirst($user['firstname']) ?></td>
                                <td><?= ucfirst($user['lastname']) ?></td>
                                <td><?= $user['username'] ?></td>
                                <td><a href="mailto:<?= $user['email'] ?>"><?= $user['email'] ?></a></td>
                                <td><?= accessLevelName($user['accesslevel']) ?></td>
                            </tr>
                        <?php } ?>
                    <?php } else { ?>
                        <tr><td colspan="6">Er zijn momenteel geen afspraken beschikbaar.</td></tr>
                    <?php } ?>
                </tbody>
            </table>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <form class="form-horizontal" method="get" action="<?= base_url() ?>admin/users.php" role="form">
                        <div class="form-group">
                            <div class="col-sm-8 col-sm-offset-2">
                                <input type="text" class="form-control" id="search" name="search" 
                                       placeholder="Zoek gebruikers op voornaam, familienaam, gebruikersnaam of email" />
                            </div>
                            <div class="col-sm-2">
                                <input type="submit" class="form-control btn btn-primary" value="Zoek" />
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <?php if (strlen($search)) { ?>
                        <hr />
                        <p>Er werden <strong><?= $users == FALSE ? 0 : count((array) $users) ?></strong> gebruikers gevonden die voldoen aan uw zoekterm "<?= $search ?>".</p>
                        <a href="<?= base_url() ?>admin/users.php" class="btn btn-default">Terug</a>
                    <?php } ?>
                </div>
            </div>

            <?php include_once partials_url() . 'message.php' ?>
        </div>
        <?php include_once partials_url() . 'scripts.php' ?>
    </body>
</html>
