<?php

/*if(loggedin())
    redirect('index.php');*/

class ProfileController extends Controller{
    
    public function index(){
        if(isset($_POST['submit'])) {
            $this->login();
        }    
        $this->render("login");
    }
    
    public function login(){
        if(isset($_POST['submit'])) {
            if(isset($_POST['username']) && isset($_POST['password'])) {
                set_value('username', $_POST['username']);
                set_value('password', $_POST['password']);

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

                    if(isCorrectCredentialsUser(set_value('username'), set_value('password'))) {
                        set_userdata(loadUser(set_value('username')));
                        redirect('profile/login_success.php');
                    }

                    message('Foutieve gebruikersnaam/paswoord combinatie!', 'danger');
                }
            }
        }    
        $this->render("login");
    }
}

?>
