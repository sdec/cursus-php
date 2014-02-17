<?php define('BASE_URL', '../');
require_once BASE_URL . 'includes/config/routes.php';
require_once config_url() . 'sessions.php';
require_once config_url() . 'database.php';
require_once models_url() . 'AppointmentModel.php';
require_once models_url() . 'UserModel.php';
require_once helpers_url() . 'form_helper.php';

if(!isset($_GET['appointmentid']))
    redirect('');

if (!loggedin())
    redirect('profile/login.php');

if (userdata('accesslevel') < LECTURER)
    redirect('');
    

$appointment = deleteAppointment($_GET['appointmentid']);
if($appointment == FALSE){
    message("Onze excuses, er is *iets* mis gegaan met het deleten van afspraak met id ".$_GET['appointmentid']."!", "danger");
} else {
    message("Uw afspraak werd succesvol geannuleerd!");
}
redirect('');

?>