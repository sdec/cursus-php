<?php

class AdminController extends Controller{
    private $usermodel;
    
    public function __construct() {
        parent::__construct('admin');
        $this->usermodel = new User_Mapper();
    }
    
    public function index(){
        $this->users();
    }
    
    public function users(){
        if (!SessionHelper::loggedin() || SessionHelper::userdata('accesslevel') < LECTURER)
            RouteHelper::redirect('');
        $this->_template->search = $this->_input->post('search') ? $this->_input->post('search') : '';

        $users = strlen($this->_template->search) ? $this->usermodel->searchUsers($this->_template->search) : $this->usermodel->loadAllUsers();
        for($i = 0 ; $i < count($users); $i++){
            $users[$i]->accesslevelname = $this->usermodel->accessLevelName($users[$i]->accesslevel);
        }
        $this->_template->users = $users;
        $this->_template->setPageTitle('Gebruikers');
        $this->_template->render('admin/users');
    }
    
    public function act_as($username = ''){
        if (!SessionHelper::loggedin() || SessionHelper::userdata('accesslevel') < LECTURER)
            RouteHelper::redirect('');
        
        $user = $this->usermodel->loadUser($username);
        if ($user == FALSE)
            RouteHelper::redirect('admin/users.php');

        if ($user->accesslevel >= SessionHelper::userdata('accesslevel'))
            RouteHelper::redirect('profile/view/' . $user->username);

        // Store my old session
        $_SESSION['act'] = $_SESSION['user'];

        // Set the new session
        SessionHelper::set_userdata($user);

        RouteHelper::redirect('');
    }
    
    public function stopact_as(){
        if (!SessionHelper::loggedin() || !isset($_SESSION['act']))
            RouteHelper::redirect('');

        $username = $_SESSION['act']->username;
        SessionHelper::unset_userdata();
        unset($_SESSION['act']);

        SessionHelper::set_userdata($this->usermodel->loadUser($username));
        RouteHelper::redirect('');
    }
    
    public function deleteuser($userid = -1){
        if (!SessionHelper::loggedin() || $userid == -1)
            RouteHelper::redirect('');
        
        if (SessionHelper::userdata('accesslevel') < ADMIN){
            FormHelper::message("Enkel admins mogen gebruikers deleten!", "info");
            RouteHelper::redirect('');
        }
        
        $user = $this->usermodel->deleteUser($userid);
        if($user == FALSE){
            FormHelper::message("Onze excuses, er is *iets* mis gegaan met het deleten van user met id ".$userid."!", "danger");
        } else {
            FormHelper::message("De user werd succesvol gedelete!");
        }
        $this->users();
    }
    
    public function edituser($username = ''){
        if (!SessionHelper::loggedin())
            RouteHelper::redirect('');

        if (SessionHelper::userdata('accesslevel') < ADMIN){
            FormHelper::message("Enkel admins mogen gebruikers rechten toekennen!", "info");
            RouteHelper::redirect('admin/users');
        }

        if($username == '')
            RouteHelper::redirect('admin/users');

        $user = $this->usermodel->loadUser($username);
        if($user == FALSE)
            RouteHelper::redirect('');

        if($this->_input->post('submit') == '') {
            if($this->_input->post('username') && $this->_input->post('firstname') && $this->_input->post('lastname') && $this->_input->post('email')) {

                $this->_template->_form->set_value('username', $this->_input->post('username'));
                $this->_template->_form->set_value('firstname', $this->_input->post('firstname'));
                $this->_template->_form->set_value('lastname', $this->_input->post('lastname'));
                $this->_template->_form->set_value('email', $this->_input->post('email'));
                $this->_template->_form->set_value('accesslevel', $this->_input->post('accesslevel'));

                if($this->_template->_form->isMinLength('username', 4) == FALSE)
                    set_error ('username', 'Het gebuikersnaam veld moet minstens 4 karakters lang zijn');
                if($this->_template->_form->isMaxLength('username', 32) == FALSE)
                    set_error ('username', 'Het gebuikersnaam veld max maximum 32 karakters lang zijn');

                if($this->_template->_form->isMinLength('firstname', 2) == FALSE)
                    set_error ('firstname', 'Het voornaam veld moet minstens 2 karakters lang zijn');
                if($this->_template->_form->isMaxLength('firstname', 32) == FALSE)
                    set_error ('firstname', 'Het voornaam veld max maximum 32 karakters lang zijn');

                if($this->_template->_form->isMinLength('lastname', 2) == FALSE)
                    set_error ('lastname', 'Het familienaam veld moet minstens 2 karakters lang zijn');
                if($this->_template->_form->isMaxLength('lastname', 32) == FALSE)
                    set_error ('lastname', 'Het familienaam veld max maximum 32 karakters lang zijn');

                if($this->_template->_form->isValidEmail($this->_template->_form->set_value('email')) == FALSE)
                    set_error ('email', 'Het email veld moet een geldig email adres zijn');

                if($this->_template->_form->hasErrors() == FALSE) {
                    if($this->usermodel->usernameExists($this->_template->_form->set_value('username')) == FALSE || $user->username == $this->_template->_form->set_value('username')) {
                        $this->usermodel->editUser($user->userid, 
                                $this->_template->_form->set_value('username'), 
                                $this->_template->_form->set_value('firstname'),
                                $this->_template->_form->set_value('lastname'),
                                $this->_template->_form->set_value('email'),
                                $this->_template->_form->set_value('accesslevel'));
                        RouteHelper::redirect('profile/view/'. $this->_template->_form->set_value('username'));
                    }
                }
            }
        } else {
            // Set default form values from database
            $this->_template->_form->set_value('username', $user->username);
            $this->_template->_form->set_value('firstname', $user->firstname);
            $this->_template->_form->set_value('lastname', $user->lastname);
            $this->_template->_form->set_value('email', $user->email);
        }
        $this->_template->user = $user;
        $accessLevels = array();
        for($i = 0; $i < count($this->usermodel->accessLevels); $i++){
            $accessLevels[$i] = $this->usermodel->accessLevelName($i);
        }
        $this->_template->accessLevels = $accessLevels;
        $this->_template->setPageTitle('Wijzig gebruiker');
        $this->_template->render('admin/edituser');
    }
}

?>