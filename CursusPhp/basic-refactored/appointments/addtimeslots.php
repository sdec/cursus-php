<?php 
define('BASE_URL', '../');
require_once BASE_URL . 'includes/config/routes.php';
require_once config_url() . 'sessions.php';
require_once config_url() . 'database.php';
require_once models_url() . 'UserModel.php';
require_once models_url() . 'AppointmentModel.php';
require_once helpers_url()  . 'form_helper.php';

if (!loggedin())
    redirect('profile/login.php');

if (userdata('accesslevel') < LECTURER)
    redirect('appointments/view.php');

$lecturers = lecturers();
$appointment = loadAppointment($_GET['appointmentid']);
if($appointment == FALSE){
    message("Onze excuses, er is *iets* mis gegaan met het tijdsloten toevoegen aan afspraak met id ".$_GET['appointmentid']."!", "danger");
    redirect('');
}

if(isset($_POST['submit'])) {
    if(isset($_POST['start']) && isset($_POST['end']) && isset($_POST['interval'])) {
        $lecturerid = $_POST['lecturerid'];
        set_value('start', $_POST['start']);
        set_value('end', $_POST['end']);
        set_value('interval', $_POST['interval']);

        $start_timestamp = date('Y-m-d', strtotime($appointment['start_timestamp'])) . ' ' . set_value('start');
        $end_timestamp = date('Y-m-d', strtotime($appointment['start_timestamp'])) . ' ' . set_value('end');
        $interval_timestamp = date('Y-m-d', strtotime($appointment['start_timestamp'])) . ' ' . set_value('interval');
        
        $start_end = strtotime($start_timestamp) + (strtotime(date('Y-m-d H:i:s', strtotime($interval_timestamp))) - strtotime(date('Y-m-d', strtotime($interval_timestamp))));
        // First slot must not exceed the end of the appointment for this lecturer
        if ($start_end <= strtotime($end_timestamp)) {

            // Starting hour must not lie before the starting point of the appointment
            if (strtotime($start_timestamp) >= strtotime($appointment['start_timestamp'])) {

                // Ending hour must not lie before the starting point of the appointment
                if (strtotime($end_timestamp) <= strtotime($appointment['end_timestamp'])) {

                    if (addTimeSlotsAppointment($_GET['appointmentid'], $lecturerid, $start_timestamp, $end_timestamp, $interval_timestamp) == TRUE) {
                        redirect('appointments/addtimeslots_success.php?appointmentid='.$appointment['appointmentid']);
                    } else {
                        message('Er ging iets fout tijdens het aanmaken van uw afspraak!', 'danger');
                    }
                } else {
                    message('Het einduur van de afspraken moet gelijk aan of vroeger zijn dan '
                            . date('H:i', strtotime($appointment['end_timestamp'])), 'danger');
                }
            } else {
                message('Het startuur van de afspraken moet gelijk aan of later zijn dan '
                        . date('H:i', strtotime($appointment['start_timestamp'])), 'danger');
            }
        } else {
            message('Het einde van uw eerste slot mag het einduur niet overschrijden', 'danger');
        }
    }
} else {
    // Set default form values
    set_value('start', date('H:i', strtotime($appointment['start_timestamp'])));
    set_value('end', date('H:i', strtotime($appointment['end_timestamp'])));
    set_value('interval', '00:15');
}

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
            <h1>Tijdsloten toevoegen</h1>
            <div class="well">
                <form method="POST" action="<?= base_url() ?>appointments/addtimeslots.php?appointmentid=<?= $appointment['appointmentid']; ?>" role="form" class="form-horizontal">
                    <div class="form-group">
                        <label for="lecturerid" class="col-lg-2 control-label">Organisator</label>
                        <div class="col-lg-4">
                            <select class="form-control" id="lecturerid" name="lecturerid" required>
                                <?php foreach($lecturers as $lecturer) { ?>
                                    <option value="<?= $lecturer['userid']; ?>">
                                        <?= $lecturer['firstname']; ?> <?= $lecturer['lastname']; ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="start" class="col-lg-2 control-label">Startuur</label>
                        <div class="col-lg-4">
                            <input type="time" class="form-control" id="start" name="start" 
                                   placeholder="Startuur tijdsloten" maxlength="5" value="<?= set_value('start'); ?>" required>
                        </div>
                        <div class="col-lg-6">
                            <?= form_error('start', '<span class="text-danger">', '</span>'); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="end" class="col-lg-2 control-label">Einduur</label>
                        <div class="col-lg-4">
                            <input type="time" class="form-control" id="end" name="end" 
                                   placeholder="Einduur tijdsloten" maxlength="5" value="<?= set_value('end'); ?>" required>
                        </div>
                        <div class="col-lg-6">
                            <?= form_error('end', '<span class="text-danger">', '</span>'); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="interval" class="col-lg-2 control-label">Lengte tijdsloten</label>
                        <div class="col-lg-4">
                            <input type="time" class="form-control" id="interval" name="interval" 
                                   placeholder="Lengte tijdsloten (bv 15 minuten)" maxlength="5" value="<?= set_value('interval'); ?>" required>
                        </div>
                        <div class="col-lg-6">
                            <?= form_error('interval', '<span class="text-danger">', '</span>'); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-lg-10 col-lg-offset-2">
                            <button type="submit" name="submit" class="btn btn-primary">Voeg tijdsloten toe</button> 
                            <a href="<?= base_url() ?>appointments/detail.php?appointmentid=<?= $appointment['appointmentid']; ?>" class="btn btn-default">Annuleer</a>
                        </div>
                    </div>
                </form>
            </div>
            <?php include_once partials_url() . 'message.php' ?>
        </div>
        <?php include_once partials_url() . 'scripts.php' ?>
    </body>
</html>