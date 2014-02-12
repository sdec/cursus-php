<?php
define('BASE_URL', '../');
require_once BASE_URL . 'includes/config/routes.php';
require_once config_url() . 'sessions.php';
require_once config_url() . 'database.php';
require_once models_url() . 'UserModel.php';
require_once models_url() . 'AppointmentModel.php';
require_once helpers_url() . 'form_helper.php';

if (!loggedin())
    redirect('profile/login.php');

$appointmentid = isset($_GET['appointmentid']) ? trim($_GET['appointmentid']) : -1;
$appointmentslotid = isset($_GET['appointmentslotid']) ? trim($_GET['appointmentslotid']) : -1;

if($appointmentid == -1 || $appointmentslotid == -1)
    redirect('profile/login.php');

$appointment = loadAppointment($appointmentid);

if (!$appointment['appointmentid'] )
    redirect('');

if (!loggedin())
    redirect(base_url() . 'profile/login');

if(unSubscribeAppointment($appointmentslotid, userdata('userid'))){
    redirect('appointments/unsubscribe_success.php?appointmentid='.$appointment['appointmentid']);
} else {
    message("Onze excuses, er is iets misgegaan met het uitschrijven voor het inschrijfslot met id $appointmentslotid van de afspraak met id ".$appointment['appointmentid'].".", "danger");
    redirect('');
}

?>
