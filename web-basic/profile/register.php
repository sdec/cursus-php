<?php

define('BASE_URL', '../');
require_once BASE_URL . 'includes/config/routes.php';
require_once config_url()   . 'sessions.php';

if(loggedin())
    redirect('index.php');
require_once config_url()   . 'database.php';
require_once models_url()   . 'UserModel.php';
require_once helpers_url()  . 'form_helper.php';

if(isset($_POST['submit'])) {
    if(isset($_POST['username']) && isset($_POST['password'])) {
        
        set_value('username', $_POST['username']);
        set_value('firstname', $_POST['firstname']);
        set_value('lastname', $_POST['lastname']);
        set_value('password', $_POST['password']);
        set_value('passwordConfirm', $_POST['passwordConfirm']);
        set_value('email', $_POST['email']);
        
        if(isMinLength('username', 4) == FALSE)
            set_error ('username', 'Het gebuikersnaam veld moet minstens 4 karakters lang zijn');
        
        if(isMinLength('firstname', 2) == FALSE)
            set_error ('firstname', 'Het voornaam veld moet minstens 2 karakters lang zijn');
        
        if(isMinLength('lastname', 2) == FALSE)
            set_error ('lastname', 'Het familienaam veld moet minstens 2 karakters lang zijn');
        
        if(isMinLength('password', 4) == FALSE)
            set_error ('password', 'Het paswoord veld moet minstens 4 karakters lang zijn');

        if(isMaxLength('username', 32) == FALSE)
            set_error ('username', 'Het gebuikersnaam veld max maximum 32 karakters lang zijn');
        
        if(isMaxLength('firstname', 32) == FALSE)
            set_error ('firstname', 'Het voornaam veld max maximum 32 karakters lang zijn');
        
        if(isMaxLength('lastname', 32) == FALSE)
            set_error ('lastname', 'Het familienaam veld max maximum 32 karakters lang zijn');
        
        if(isMaxLength('password', 128) == FALSE)
            set_error ('password', 'Het paswoord veld max maximum 128 karakters lang zijn');
        
        if(isAlphaNumeric('username') == FALSE)
            set_error ('username', 'De gebruikersnaam mag enkel alfanumerieke karakters bevatten');
        
        if(isAlphaNumeric('firstname') == FALSE)
            set_error ('firstname', 'De voornaam mag enkel alfanumerieke karakters bevatten');
        
        if(isAlphaNumeric('lastname') == FALSE)
            set_error ('lastname', 'De familienaam mag enkel alfanumerieke karakters bevatten');
        
        if(set_value('password') !== set_value('passwordConfirm'))
            set_error ('passwordConfirm', 'Het paswoord & paswoord confirmatie veld moeten hetzelfde zijn');
        
        if(isValidEmail(set_value('email')) == FALSE)
            set_error ('email', 'Het email veld moet een geldig email adres zijn');
            
        
        if(hasErrors() == FALSE) {
            
            if(usernameExists(set_value('username')) == FALSE) {
                registerUser(set_value('username'), set_value('firstname'), set_value('lastname'), set_value('password'), set_value('email'));
                redirect('profile/register_success.php');
                return;
            }
            message('Deze gebruikersnaam bestaat al', 'danger');
        }
    }
}

?>
<!DOCTYPE html>
<html>
    <head>
        <title>Registreren - Afspraken planner</title>
        <?php include_once partials_url() . 'header.php' ?>
    </head>
    <body>
        <?php include_once partials_url() . 'navigation.php' ?>
        <div class="container">

            <h1>Registreren</h1>
            <div class="well">
                <form method="POST" action="<?= base_url() ?>profile/register.php" role="form" class="form-horizontal">
                    <fieldset>
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
                            <label for="password" class="col-lg-2 control-label">Paswoord</label>
                            <div class="col-lg-4">
                                <input type="password" class="form-control" id="password" name="password" 
                                       placeholder="Paswoord" maxlength="128" value="<?= set_value('password'); ?>" required>
                            </div>
                            <div class="col-lg-6">
                                <?= form_error('password', '<span class="text-danger">', '</span>'); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="passwordConfirm" class="col-lg-2 control-label">Herhaal paswoord</label>
                            <div class="col-lg-4">
                                <input type="password" class="form-control" id="passwordConfirm" name="passwordConfirm" 
                                       placeholder="Herhaal paswoord" maxlength="128" value="<?= set_value('passwordConfirm'); ?>" required>
                            </div>
                            <div class="col-lg-6">
                                <?= form_error('passwordConfirm', '<span class="text-danger">', '</span>'); ?>
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
                            <div class="col-lg-10 col-lg-offset-2">
                                <button type="submit" name="submit" class="btn btn-primary">Registreren</button> 
                            </div>
                        </div>
                    </fieldset>
                </form>
            </div>
            
            <?php include_once partials_url() . 'message.php' ?>
        </div>
        <?php include_once partials_url() . 'scripts.php' ?>
    </body>
</html>