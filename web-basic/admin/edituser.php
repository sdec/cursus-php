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

if (userdata('accesslevel') < ADMIN){
    message("Enkel admins mogen gebruikers rechten toekennen!", "info");
    redirect('admin/students.php');
}

if(!isset($_GET['username']))
    redirect('admin/students.php');

$user = loadUser($_GET['username']);
if($user == FALSE)
    redirect('');

if(isset($_POST['submit'])) {
    if(isset($_POST['username']) && isset($_POST['firstname']) && isset($_POST['lastname']) && isset($_POST['email'])) {
        
        set_value('username', $_POST['username']);
        set_value('firstname', $_POST['firstname']);
        set_value('lastname', $_POST['lastname']);
        set_value('email', $_POST['email']);
        set_value('accesslevel', $_POST['accesslevel']);
        
        if(isMinLength('username', 4) == FALSE)
            set_error ('username', 'Het gebuikersnaam veld moet minstens 4 karakters lang zijn');
        if(isMaxLength('username', 32) == FALSE)
            set_error ('username', 'Het gebuikersnaam veld max maximum 32 karakters lang zijn');
        
        if(isMinLength('firstname', 2) == FALSE)
            set_error ('firstname', 'Het voornaam veld moet minstens 2 karakters lang zijn');
        if(isMaxLength('firstname', 32) == FALSE)
            set_error ('firstname', 'Het voornaam veld max maximum 32 karakters lang zijn');
        
        if(isMinLength('lastname', 2) == FALSE)
            set_error ('lastname', 'Het familienaam veld moet minstens 2 karakters lang zijn');
        if(isMaxLength('lastname', 32) == FALSE)
            set_error ('lastname', 'Het familienaam veld max maximum 32 karakters lang zijn');
        
        if(isValidEmail(set_value('email')) == FALSE)
            set_error ('email', 'Het email veld moet een geldig email adres zijn');
        
        if(hasErrors() == FALSE) {
            if(usernameExists(set_value('username')) == FALSE || $user['username'] == set_value('username')) {
                editUser($user['userid'], 
                        set_value('username'), 
                        set_value('firstname'),
                        set_value('lastname'),
                        set_value('email'),
                        set_value('accesslevel'));
                redirect('profile/view.php?username='. set_value('username'));
            }
        }
    }
} else {
    // Set default form values from database
    set_value('username', $user['username']);
    set_value('firstname', $user['firstname']);
    set_value('lastname', $user['lastname']);
    set_value('email', $user['email']);
}
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Wijzig gebruiker - Afspraken planner</title>
        <?php include_once partials_url() . 'header.php' ?>
    </head>
    <body>
        <?php include_once partials_url() . 'navigation.php' ?>
        <div class="container">
                    <h3>Wijzig gebruiker</h3>
                    <div class="well">
                    <form method="POST" role="form" class="form-horizontal">
                            <div class="form-group">
                                <label for="username" class="col-lg-2 control-label">Gebruikersnaam</label>
                                <div class="col-lg-4">
                                    <input type="text" class="form-control" id="username" name="username" 
                                           placeholder="Gebruikersnaam" maxlength="32" value="<?= set_value('username'); ?>" required>
                                </div>
                                <div class="col-lg-6">
                                    <?= form_error('username', '<span class="text-danger">', '</span>'); ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="firstname" class="col-lg-2 control-label">Voornaam</label>
                                <div class="col-lg-4">
                                    <input type="text" class="form-control" id="firstname" name="firstname" 
                                           placeholder="Voornaam" maxlength="32" value="<?= set_value('firstname'); ?>" required>
                                </div>
                                <div class="col-lg-6">
                                    <?= form_error('firstname', '<span class="text-danger">', '</span>'); ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="lastname" class="col-lg-2 control-label">Familienaam</label>
                                <div class="col-lg-4">
                                    <input type="text" class="form-control" id="lastname" name="lastname" 
                                           placeholder="Familienaam" maxlength="32" value="<?= set_value('lastname'); ?>" required>
                                </div>
                                <div class="col-lg-6">
                                    <?= form_error('lastname', '<span class="text-danger">', '</span>'); ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="email" class="col-lg-2 control-label">Email adres</label>
                                <div class="col-lg-4">
                                    <input type="email" class="form-control" id="email" name="email" 
                                           placeholder="Email adres" maxlength="128" value="<?= set_value('email'); ?>" required>
                                </div>
                                <div class="col-lg-6">
                                    <?= form_error('email', '<span class="text-danger">', '</span>'); ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="accesslevel" class="col-lg-2 control-label">Profiel type</label>
                                <div class="col-lg-4">
                                    <select class="form-control" id="accesslevel" name="accesslevel" required>
                                        <?php foreach($accessLevels as $accesslevel => $accessLevelname) { ?>
                                            <option value="<?= $accesslevel ?>" <?= $user['accesslevel'] == $accesslevel ? 'selected' : '' ?>>
                                                <?= $accessLevelname ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-lg-10 col-lg-offset-2">
                                    <button type="submit" name="submit" class="btn btn-primary">Wijzig gebruiker</button> 
                                    <a href="<?= base_url() ?>profile/view.php?username=<?= $user['username'] ?>" class="btn btn-default">Annuleer</a>
                                </div>
                            </div>
                    </form>
                </div>
            <?php include_once partials_url() . 'message.php' ?>
        </div>
        <?php include_once partials_url() . 'scripts.php' ?>
    </body>
</html>