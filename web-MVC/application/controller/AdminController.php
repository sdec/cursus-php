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
        if (!loggedin() || userdata('accesslevel') < LECTURER)
            redirect('');
        $this->_template->search = isset($_POST['search']) ? $_POST['search'] : '';

        $users = strlen($this->_template->search) ? $this->usermodel->searchUsers($this->_template->search) : $this->usermodel->loadAllUsers();
        for($i = 0 ; $i < count($users); $i++){
            $users[$i]->accesslevelname = $this->usermodel->accessLevelName($users[$i]->accesslevel);
        }
        $this->_template->users = $users;
        $this->_template->setPageTitle('Gebruikers');
        $this->_template->render('admin/users');
    }
    
    public function act_as($username = ''){
        if (!loggedin() || userdata('accesslevel') < LECTURER)
            redirect('');
        
        $user = $this->usermodel->loadUser($username);
        if ($user == FALSE)
            redirect('admin/users.php');

        if ($user->accesslevel >= userdata('accesslevel'))
            redirect('profile/view/' . $user->username);

        // Store my old session
        $_SESSION['act'] = $_SESSION['user'];

        // Set the new session
        set_userdata($user);

        redirect('');
    }
    
    public function stopact_as(){
        if (!loggedin() || !isset($_SESSION['act']))
            redirect('');

        $username = $_SESSION['act']->username;
        unset_userdata();
        unset($_SESSION['act']);

        set_userdata($this->usermodel->loadUser($username));
        redirect('');
    }
    
    public function deleteuser($userid = -1){
        if (!loggedin() || $userid == -1)
            redirect('');
        
        if (userdata('accesslevel') < ADMIN){
            message("Enkel admins mogen gebruikers deleten!", "info");
            redirect('');
        }
        
        $user = $this->usermodel->deleteUser($userid);
        if($user == FALSE){
            message("Onze excuses, er is *iets* mis gegaan met het deleten van user met id ".$userid."!", "danger");
        } else {
            message("De user werd succesvol gedelete!");
        }
        $this->users();
    }
    
    public function edituser($username = ''){
        if (!loggedin())
            redirect('');

        if (userdata('accesslevel') < ADMIN){
            message("Enkel admins mogen gebruikers rechten toekennen!", "info");
            redirect('admin/users');
        }

        if($username == '')
            redirect('admin/users');

        $user = $this->usermodel->loadUser($username);
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
                    if($this->usermodel->usernameExists(set_value('username')) == FALSE || $user->username == set_value('username')) {
                        $this->usermodel->editUser($user->userid, 
                                set_value('username'), 
                                set_value('firstname'),
                                set_value('lastname'),
                                set_value('email'),
                                set_value('accesslevel'));
                        redirect('profile/view/'. set_value('username'));
                    }
                }
            }
        } else {
            // Set default form values from database
            set_value('username', $user->username);
            set_value('firstname', $user->firstname);
            set_value('lastname', $user->lastname);
            set_value('email', $user->email);
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