<?php define('BASE_URL', '../');
require_once BASE_URL . 'includes/config/routes.php';
require_once config_url() . 'sessions.php';
require_once config_url() . 'database.php';
require_once models_url() . 'AppointmentModel.php';
require_once models_url() . 'UserModel.php';

if(!isset($_GET['appointmentid']))
    redirect('');

if (!loggedin())
    redirect('profile/login.php');

if (userdata('accesslevel') < LECTURER)
    redirect('appointments/view.php');
    

$appointment = loadAppointment($_GET['appointmentid']);
if($appointment == FALSE)
    redirect('');

$appointment['date'] = date('d M Y', strtotime($appointment['start_timestamp']));
$appointment['start'] = date('H:i', strtotime($appointment['start_timestamp']));
$appointment['end'] = date('H:i', strtotime($appointment['end_timestamp']));

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
            <h1>Afspraak aangemaakt</h1>
            <p>Een afspraak met de volgende details werd aangemaakt.</p>

            <table class="table table-hover table-striped table-vertical">
                <tr>
                    <td>Startdatum</td>
                    <td><?= $appointment['date'] ?></td>
                </tr>
                <tr>
                    <td>Startuur</td>
                    <td><?= $appointment['start'] ?></td>
                </tr>
                <tr>
                    <td>Einduur</td>
                    <td><?= $appointment['end'] ?></td>
                </tr>
                <tr>
                    <td>Beschrijving</td>
                    <td><?= $appointment['description'] ?></td>
                </tr>
                <tr>
                    <td>Locatie</td>
                    <td><?= $appointment['location'] ?></td>
                </tr>
                <tr>
                    <td>Chronologie</td>
                    <td>
                        <?php if($appointment['chronological']) { ?>
                            Inschrijvingen verlopen verplicht in chronologische volgorde.
                        <?php } else { ?>
                            Inschrijvingen kunnen op elk tijdstip.
                        <?php } ?>
                    </td>
                </tr>
            </table>

            <div class="alert alert-info">
                <p>
                    Er werden nog geen organisatoren toegewezen aan deze afspraak (m.a.w. er is nog niemand waarbij studenten een afspraak kunnen maken). 
                    Open de detailweergave van een afspraak en klik op "Voeg organisator toe" om iemand toe te voegen aan deze afspraak.
                </p>
            </div>

            <p><a href="<?= base_url() ?>" class="btn btn-default">Terug</a></p>
            <?php include_once partials_url() . 'message.php' ?>
        </div>
        <?php include_once partials_url() . 'scripts.php' ?>
    </body>
</html>