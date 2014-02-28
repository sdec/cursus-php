<?php

class ProfileController extends Controller{
    private $usermodel;
    private $appointmentmodel;
    
    public function __construct() {
        parent::__construct();
        $this->usermodel = new User_Mapper();
        $this->appointmentmodel = new Appointment_Mapper();
    }
    
    public function index(){
        if(isset($_POST['submit']))
            $this->login();
        
        $this->_template->setPageTitle('Log in');
        $this->_template->render('profile/login');
    }
    
    public function login(){
        if(isset($_POST['submit'])) {
            if(isset($_POST['username']) && isset($_POST['password'])) {
                $this->_template->_form->set_value('username', $_POST['username']);
                $this->_template->_form->set_value('password', $_POST['password']);

                if($this->_template->_form->isMinLength('username', 4) == FALSE)
                    set_error ('username', 'Het gebuikersnaam veld moet minstens 4 karakters lang zijn');

                if($this->_template->_form->isMinLength('password', 4) == FALSE)
                    set_error ('password', 'Het paswoord veld moet minstens 4 karakters lang zijn');

                if($this->_template->_form->isMaxLength('username', 32) == FALSE)
                    set_error ('username', 'Het gebuikersnaam veld max maximum 32 karakters lang zijn');

                if($this->_template->_form->isMaxLength('password', 128) == FALSE)
                    set_error ('password', 'Het paswoord veld max maximum 128 karakters lang zijn');

                if($this->_template->_form->isAlphaNumeric('username') == FALSE)
                    set_error ('username', 'De gebruikersnaam mag enkel alfanumerieke karakters bevatten');

                if($this->_template->_form->hasErrors() == FALSE) {

                    if($this->usermodel->isCorrectCredentialsUser($this->_template->_form->set_value('username'), $this->_template->_form->set_value('password'))) {
                        
                        SessionHelper::set_userdata($this->usermodel->loadUser($this->_template->_form->set_value('username')));
                        
                        $this->_template->setPageTitle('Log in');
                        $this->_template->render('profile/login_success');
                        
                        die;
                    }

                    message('Foutieve gebruikersnaam/paswoord combinatie!', 'danger');
                }
            }
        }    
        
        $this->_template->setPageTitle('Log in');
        $this->_template->render('profile/login');
    }
    
    public function register(){
        if(SessionHelper::loggedin()) //User already logged in, no need to register
            RouteHelper::redirect('index.php');

        if(isset($_POST['submit'])) {
            if(isset($_POST['username']) && isset($_POST['password'])) {

                $this->_template->_form->set_value('username', $_POST['username']);
                $this->_template->_form->set_value('firstname', $_POST['firstname']);
                $this->_template->_form->set_value('lastname', $_POST['lastname']);
                $this->_template->_form->set_value('password', $_POST['password']);
                $this->_template->_form->set_value('passwordConfirm', $_POST['passwordConfirm']);
                $this->_template->_form->set_value('email', $_POST['email']);

                if($this->_template->_form->isMinLength('username', 4) == FALSE)
                    set_error ('username', 'Het gebuikersnaam veld moet minstens 4 karakters lang zijn');

                if($this->_template->_form->isMinLength('firstname', 2) == FALSE)
                    set_error ('firstname', 'Het voornaam veld moet minstens 2 karakters lang zijn');

                if($this->_template->_form->isMinLength('lastname', 2) == FALSE)
                    set_error ('lastname', 'Het familienaam veld moet minstens 2 karakters lang zijn');

                if($this->_template->_form->isMinLength('password', 4) == FALSE)
                    set_error ('password', 'Het paswoord veld moet minstens 4 karakters lang zijn');

                if($this->_template->_form->isMaxLength('username', 32) == FALSE)
                    set_error ('username', 'Het gebuikersnaam veld max maximum 32 karakters lang zijn');

                if($this->_template->_form->isMaxLength('firstname', 32) == FALSE)
                    set_error ('firstname', 'Het voornaam veld max maximum 32 karakters lang zijn');

                if($this->_template->_form->isMaxLength('lastname', 32) == FALSE)
                    set_error ('lastname', 'Het familienaam veld max maximum 32 karakters lang zijn');

                if($this->_template->_form->isMaxLength('password', 128) == FALSE)
                    set_error ('password', 'Het paswoord veld max maximum 128 karakters lang zijn');

                if($this->_template->_form->isAlphaNumeric('username') == FALSE)
                    set_error ('username', 'De gebruikersnaam mag enkel alfanumerieke karakters bevatten');

                if($this->_template->_form->isAlphaNumeric('firstname') == FALSE)
                    set_error ('firstname', 'De voornaam mag enkel alfanumerieke karakters bevatten');

                if($this->_template->_form->isAlphaNumeric('lastname') == FALSE)
                    set_error ('lastname', 'De familienaam mag enkel alfanumerieke karakters bevatten');

                if($this->_template->_form->set_value('password') !== $this->_template->_form->set_value('passwordConfirm'))
                    set_error ('passwordConfirm', 'Het paswoord & paswoord confirmatie veld moeten hetzelfde zijn');

                if($this->_template->_form->isValidEmail($this->_template->_form->set_value('email')) == FALSE)
                    set_error ('email', 'Het email veld moet een geldig email adres zijn');


                if($this->_template->_form->hasErrors() == FALSE) {

                    if($this->usermodel->usernameExists($this->_template->_form->set_value('username')) == FALSE) {
                        $this->usermodel->registerUser($this->_template->_form->set_value('username'), $this->_template->_form->set_value('firstname'), $this->_template->_form->set_value('lastname'), $this->_template->_form->set_value('password'), $this->_template->_form->set_value('email'));
                        
                        $this->_template->setPageTitle('Registreren');
                        $this->_template->render('profile/register_success');
                        
                        die;
                    }
                    message('Deze gebruikersnaam bestaat al', 'danger');
                }
            }
        }
        $this->_template->setPageTitle('Registreren');
        $this->_template->render('profile/register');
    }
    
    public function view($username = null){
        $this->_template->user = (isset($username)) ? $this->usermodel->loadUser($username) : $this->usermodel->loadUser(SessionHelper::userdata('username'));
        $this->_template->user->accesslevelname = $this->usermodel->accessLevelName($this->_template->user->accesslevel);
        $this->_template->setPageTitle('Profiel');
        $this->_template->render('profile/view');
    }
    
    public function logout(){
        if(!SessionHelper::loggedin()) //Can't logout if you're not logged in
            RouteHelper::redirect('index.php');

        SessionHelper::unset_userdata('user');
        $this->_template->setPageTitle('uitloggen');
        $this->_template->render('profile/logout_success');
    }
    
    public function appointments($username = '') {
        if (!SessionHelper::loggedin())
            RouteHelper::redirect('profile/login');

        $user = null;
        if(strlen($username)) {
            $user = $this->usermodel->loadUser($username);
        } else {
            $user = $_SESSION['user'];
        }

        if($user == FALSE)
            RouteHelper::redirect('');
        
        $search = isset($_POST['search']) ? $_POST['search'] : '';
        $appointments = strlen($search) 
            ? $this->appointmentmodel->searchAppointments($search) 
            : $this->appointmentmodel->loadAllAppointments($user->userid);
        
        $this->_template->appointments = $appointments;
        $this->_template->search = $search;
        
        $this->_template->setPageTitle('Mijn afspraken');
        $this->_template->render('profile/appointments');

    }
}

?>
