<?php 
define('BASE_URL', '../');
require_once BASE_URL . 'includes/helpers/routes_helper.php';
require_once helpers_url() . 'sessions_helper.php';
require_once config_url() . 'database.php';
require_once helpers_url() . 'database_helper.php';
require_once models_url() . 'UserModel.php';
require_once models_url() . 'AppointmentModel.php';
require_once helpers_url()  . 'form_helper.php';

if (!loggedin())
    redirect('profile/login.php');

if (userdata('accesslevel') < LECTURER)
    redirect('appointments/view.php');

if(!isset($_GET['appointmentid']))
    redirect('');

$appointment = loadAppointment($_GET['appointmentid']);
if($appointment == FALSE)
    redirect('');

$slots = slots($appointment['appointmentid']);

if(isset($_POST['submit'])) {
    if(isset($_POST['date']) && isset($_POST['start']) && isset($_POST['end']) && isset($_POST['description']) && isset($_POST['location'])) {
        
        set_value('date', $_POST['date']);
        set_value('start', $_POST['start']);
        set_value('end', $_POST['end']);
        set_value('description', $_POST['description']);
        set_value('location', $_POST['location']);
        set_value('chronological', isset($_POST['chronological']));
        
        if(isMinLength('description', 4) == FALSE)
            set_error ('description', 'Het omschrijvingsveld moet minstens 4 karakters lang zijn');
        
        if(isMinLength('location', 3) == FALSE)
            set_error ('location', 'Het locatieveld moet minstens 3 karakters lang zijn');
        
        if(isMaxLength('description', 128) == FALSE) 
                set_error ('description', 'Het omschrijvingsveld max maximum 128 karakters lang zijn');
        
        if(isMaxLength('location', 32) == FALSE)
            set_error ('location', 'Het locatieveld veld max maximum 32 karakters lang zijn');
        
        if(hasErrors() == FALSE) {
            editAppointment($appointment['appointmentid'], 
                    set_value('date').' '.set_value('start'), 
                    set_value('date').' '.set_value('end'), 
                    set_value('description'), set_value('location'), set_value('chronological'));
            
            redirect('appointments/edit_success.php?appointmentid='. $appointment['appointmentid']);
        }
    }
} else {
    
    // Set default form values from database
    $appointment['date'] = date('Y-m-d', strtotime($appointment['start_timestamp']));
    $appointment['start'] = date('H:i', strtotime($appointment['start_timestamp']));
    $appointment['end'] = date('H:i', strtotime($appointment['end_timestamp']));
    
    set_value('date', $appointment['date']);
    set_value('start', $appointment['start']);
    set_value('end', $appointment['end']);
    set_value('description', $appointment['description']);
    set_value('location', $appointment['location']);
    set_value('chronological', $appointment['chronological']);
}
    
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Afspraak wijzigen - Afspraken planner</title>
        <?php include_once partials_url() . 'header.php' ?>
    </head>
    <body>
        <?php include_once partials_url() . 'navigation.php' ?>
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <h3>Wijzig afspraakdetails</h3>
                    <div class="well">
                        <form method="POST" action="<?= base_url() ?>appointments/edit.php?appointmentid=<?= $appointment['appointmentid'] ?>" role="form" class="form-horizontal">
                            <div class="form-group">
                                <label for="date" class="col-lg-2 control-label">Datum</label>
                                <div class="col-lg-10">
                                    <input type="date" class="form-control" id="date" name="date" 
                                           placeholder="Datum afspraak" maxlength="32" value="<?= set_value('date'); ?>" required>
                                </div>
                                <div class="col-lg-6">
                                    <?= form_error('date', '<span class="text-danger">', '</span>'); ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="start" class="col-lg-2 control-label">Startuur</label>
                                <div class="col-lg-10">
                                    <input type="time" class="form-control" id="start" name="start" 
                                           placeholder="Startuur afspraak" maxlength="32" value="<?= set_value('start'); ?>" required>
                                </div>
                                <div class="col-lg-6">
                                    <?= form_error('start', '<span class="text-danger">', '</span>'); ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="end" class="col-lg-2 control-label">Einduur</label>
                                <div class="col-lg-10">
                                    <input type="time" class="form-control" id="end" name="end" 
                                           placeholder="Einduur afspraak" maxlength="32" value="<?= set_value('end'); ?>" required>
                                </div>
                                <div class="col-lg-6">
                                    <?= form_error('end', '<span class="text-danger">', '</span>'); ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="description" class="col-lg-2 control-label">Beschrijving</label>
                                <div class="col-lg-10">
                                    <textarea class="form-control" id="description" name="description" 
                                              placeholder="Beschrijving afspraak" maxlength="128" required><?= set_value('description'); ?></textarea>
                                </div>
                                <div class="col-lg-6">
                                    <?= form_error('description', '<span class="text-danger">', '</span>'); ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="location" class="col-lg-2 control-label">Locatie</label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" id="location" name="location" 
                                           placeholder="Locatie afspraak" maxlength="32" value="<?= set_value('location'); ?>" required />
                                </div>
                                <div class="col-lg-6">
                                    <?= form_error('location', '<span class="text-danger">', '</span>'); ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-lg-10 col-lg-offset-2">
                                    <input type="checkbox" id="chronological" name="chronological" <?= $appointment['chronological'] ? 'checked="checked"' : '' ?>>
                                    Verplicht inschrijvingen in chronologische volgorde
                                </div>
                                <div class="col-lg-6">
                                    <?= form_error('chronological', '<span class="text-danger">', '</span>'); ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-lg-10 col-lg-offset-2">
                                    <button type="submit" name="submit" class="btn btn-primary">Wijzig afspraak</button> 
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-lg-6">
                    <h3>Wijzig tijdsloten</h3>
                    <?php if ($slots) { ?>
                        <table class="table table-hover table-striped">
                            <thead>
                                <tr>
                                    <td><span class="glyphicon glyphicon-user"></span> Organisator</td>
                                    <td><span class="glyphicon glyphicon-time"></span> Start/Einduur</td>
                                    <td>Ingeschreven</td>
                                    <td></td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($slots as $slot) { ?>
                                    <tr>
                                        <td><?= $slot['lecturer'] ?></td>
                                        <td><?= $slot['start'] ?> - <?= $slot['end'] ?></td>
                                        <td><?= $slot['subscriber'] ?></td>
                                        <td>
                                            <a href="<?= base_url() ?>appointments/deletetimeslot.php?appointmentid=<?= $appointment['appointmentid'] ?>&appointmentslotid=<?= $slot['appointmentslotid'] ?>">
                                                <span class="glyphicon glyphicon-remove-sign"></span> Verwijder
                                            </a>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    <?php } else { ?>
                        <p>Er werden nog geen tijdsloten toegewezen aan deze afspraak.</p>
                    <?php } ?>
                </div>
            </div>
            <p><a href="<?= base_url() ?>appointments/detail.php?appointmentid=<?= $appointment['appointmentid'] ?>" class="btn btn-default">Terug</a></p>
            <?php include_once partials_url() . 'message.php' ?>
        </div>
        <?php include_once partials_url() . 'scripts.php' ?>
    </body>
</html>