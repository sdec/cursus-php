<?php

define('BASE_URL', '../');
require_once BASE_URL . 'includes/config/routes.php';

require_once config_url() . 'sessions.php';
require_once config_url() . 'database.php';
require_once helpers_url() . 'form_helper.php';

if(isset($_POST['submit'])) {
    
    if(isset($_POST['username']) && isset($_POST['password'])) {
        
        set_value('username', $_POST['username']);
        set_value('password', $_POST['username']);
        
        if(isMinLength('username', 4) == FALSE)
            set_error ('username', 'Het gebuikersnaam veld moet minstens 4 karakters lang zijn');
        
        if(isMinLength('password', 4) == FALSE)
            set_error ('password', 'Het paswoord veld moet minstens 4 karakters lang zijn');
        
        if(isMaxLength('username', 32) == FALSE)
            set_error ('username', 'Het gebuikersnaam veld max maximum 32 karakters lang zijn');
        
        if(isMaxLength('password', 128) == FALSE)
            set_error ('password', 'Het paswoord veld max maximum 128 karakters lang zijn');
        
        if(isAlphaNumeric('username') == FALSE)
            set_error ('username', 'De gebruikersnaam mag enkel alfanumerieke karakters bevatten');
        
        if(hasErrors() == FALSE) {
            
            message('Validatie is goed verlopen!');
            redirect('profile/login_success.php');
        }
    }
}

?>
<!DOCTYPE html>
<html>
    <head>
        <title>Log in - Afspraken planner</title>
        <?php include_once partials_url() . 'header.php' ?>
    </head>
    <body>
        <?php include_once partials_url() . 'navigation.php' ?>
        <div class="container">

            <h1>Log in</h1>
            <div class="well">
                <form method="POST" action="<?= base_url() ?>profile/login.php" role="form" class="form-horizontal">
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
                            <div class="col-lg-10 col-lg-offset-2">
                                <button type="submit" name="submit" class="btn btn-primary">Log in</button> 
                            </div>
                        </div>
                </form>
            </div>
            
            <?php include_once partials_url() . 'message.php' ?>
        </div>
        <?php include_once partials_url() . 'scripts.php' ?>
    </body>
</html>