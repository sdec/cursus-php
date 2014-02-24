<?php define('BASE_URL', '../');
require_once BASE_URL . 'includes/helpers/routes_helper.php';
require_once helpers_url() . 'sessions_helper.php';
require_once config_url() . 'database.php';
require_once helpers_url() . 'database_helper.php';
require_once models_url() . 'AppointmentModel.php';
require_once models_url() . 'UserModel.php';

if (!loggedin())
    redirect('profile/login.php');

if(!isset($_GET['appointmentid']))
    redirect('');

?>
<!DOCTYPE html>
<html>
    <head>
        <title>Uitgeschreven voor afspraak</title>
        <?php include_once partials_url() . 'header.php' ?>
    </head>
    <body>
        <?php include_once partials_url() . 'navigation.php' ?>
        <div class="container">
            <h1>Uitgeschreven voor afspraak</h1>
            <p>U bent nu uitgeschreven voor de afspraak.</p>
            <p><a href="<?= base_url() ?>appointments/detail.php?appointmentid=<?= $_GET['appointmentid']; ?>" class="btn btn-default">Terug</a></p>
            <?php include_once partials_url() . 'message.php' ?>
        </div>
        <?php include_once partials_url() . 'scripts.php' ?>
    </body>
</html>