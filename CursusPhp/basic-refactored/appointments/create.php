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
        
        if(isMaxLength('location', 32) == FALSE)
            set_error ('location', 'Het locatieveld veld max maximum 32 karakters lang zijn');
        
        if(isMaxLength('description', 128) == FALSE) 
                set_error ('description', 'Het omschrijvingsveld max maximum 128 karakters lang zijn');
        
        if(hasErrors() == FALSE) {
            if($appointmentid = createAppointment(set_value('date').' '.set_value('start'), set_value('date').' '.set_value('end'), set_value('description'), set_value('location'), set_value('chronological'))) {
                redirect('appointments/create_success.php?appointmentid='. $appointmentid);
            } else {
                message('Er ging iets fout tijdens het aanmaken van uw afspraak!', 'danger');
            }
        }
    }
} else {

    // Set default form values
    set_value('date', date('Y-m-d', time()));
    set_value('start', '08:00');
    set_value('end', '16:00');
}
    
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Afspraak maken - Afspraken planner</title>
        <?php include_once partials_url() . 'header.php' ?>
    </head>
    <body>
        <?php include_once partials_url() . 'navigation.php' ?>
        <div class="container">
            <h1>Afspraak maken</h1>

            <div class="well">
                <form method="POST" action="<?= base_url() ?>appointments/create.php" role="form" class="form-horizontal">
                    <div class="form-group">
                        <label for="date" class="col-lg-2 control-label">Datum</label>
                        <div class="col-lg-4">
                            <input type="date" class="form-control" id="date" name="date" 
                                   placeholder="Datum afspraak" maxlength="32" value="<?= set_value('date'); ?>" required>
                        </div>
                        <div class="col-lg-6">
                            <?= form_error('date', '<span class="text-danger">', '</span>'); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="start" class="col-lg-2 control-label">Startuur</label>
                        <div class="col-lg-4">
                            <input type="time" class="form-control" id="start" name="start" 
                                   placeholder="Startuur afspraak" maxlength="32" value="<?= set_value('start'); ?>" required>
                        </div>
                        <div class="col-lg-6">
                            <?= form_error('start', '<span class="text-danger">', '</span>'); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="end" class="col-lg-2 control-label">Einduur</label>
                        <div class="col-lg-4">
                            <input type="time" class="form-control" id="end" name="end" 
                                   placeholder="Einduur afspraak" maxlength="32" value="<?= set_value('end'); ?>" required>
                        </div>
                        <div class="col-lg-6">
                            <?= form_error('end', '<span class="text-danger">', '</span>'); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="description" class="col-lg-2 control-label">Beschrijving</label>
                        <div class="col-lg-4">
                            <textarea class="form-control" id="description" name="description" 
                                      placeholder="Beschrijving afspraak" maxlength="128" required><?= set_value('description'); ?></textarea>
                        </div>
                        <div class="col-lg-6">
                            <?= form_error('description', '<span class="text-danger">', '</span>'); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="location" class="col-lg-2 control-label">Locatie</label>
                        <div class="col-lg-4">
                            <input type="text" class="form-control" id="location" name="location" 
                                   placeholder="Locatie afspraak" maxlength="32" value="<?= set_value('location'); ?>" required />
                        </div>
                        <div class="col-lg-6">
                            <?= form_error('location', '<span class="text-danger">', '</span>'); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-lg-6 col-lg-offset-2">
                            <input type="checkbox" id="chronological" name="chronological" 
                                   value="<?= set_value('chronological'); ?>">
                            Verplicht inschrijvingen in chronologische volgorde
                        </div>
                        <div class="col-lg-6">
                            <?= form_error('chronological', '<span class="text-danger">', '</span>'); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-lg-10 col-lg-offset-2">
                            <button type="submit" name="submit" class="btn btn-primary">Maak afspraak</button> 
                            <a href="<?= base_url() ?>" class="btn btn-default">Annuleer</a>
                        </div>
                    </div>
                </form>
            </div>
            <p>Na het aanmaken van een afspraak kan u één of meerdere organisatoren toevoegen aan deze afspraak.</p>
            <?php include_once partials_url() . 'message.php' ?>
        </div>
        <?php include_once partials_url() . 'scripts.php' ?>
    </body>
</html>