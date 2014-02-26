<?php
    require_once models_url()   . 'UserMapper.php';
    require_once helpers_url()  . 'form_helper.php';

class ProfileController extends Controller{
    private $usermodel;
    
    public function __construct() {
        $this->usermodel = new User_Mapper();
    }
    
    public function index(){
        if(isset($_POST['submit']))
            $this->login();
        
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

                    if($this->usermodel->isCorrectCredentialsUser(set_value('username'), set_value('password'))) {
                        set_userdata($this->usermodel->loadUser(set_value('username')));
                        $this->render('login_success');
                        die();
                    }

                    message('Foutieve gebruikersnaam/paswoord combinatie!', 'danger');
                }
            }
        }    
        $this->render("login");
    }
    
    public function register(){
        if(loggedin()) //User already logged in, no need to register
            redirect('index.php');

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

                    if($this->usermodel->usernameExists(set_value('username')) == FALSE) {
                        registerUser(set_value('username'), set_value('firstname'), set_value('lastname'), set_value('password'), set_value('email'));
                        $this->render("register_success");
                    }
                    message('Deze gebruikersnaam bestaat al', 'danger');
                }
            }
        }
        $this->render("register");
    }
    
    public function logout(){
        if(!loggedin()) //Can't logout if you're not logged in
            redirect('index.php');

        unset_userdata('user');
        $this->render('logout_success');
    }
}

?>
