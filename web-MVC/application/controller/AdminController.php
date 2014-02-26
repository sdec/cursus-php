<?php
require_once helpers_url() . 'form_helper.php';

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
        global $data;
        $data['search'] = isset($_POST['search']) ? $_POST['search'] : '';

        $data['users'] = strlen($data['search']) ? $this->usermodel->searchUsers($data['search']) : $this->usermodel->loadAllUsers();
        $this->render('users');
    }
    
    public function act_as($username = ''){
        if (!loggedin() || userdata('accesslevel') < LECTURER)
            redirect('');
        
        $user = $this->usermodel->loadUser($username);
        if ($user == FALSE)
            redirect('admin/users.php');

        if ($user['accesslevel'] >= userdata('accesslevel'))
            redirect('profile/view/' . $user['username']);

        // Store my old session
        $_SESSION['act'] = $_SESSION['user'];

        // Set the new session
        set_userdata($user);

        redirect('');
    }
    
    public function stopact_as(){
        if (!loggedin() || !isset($_SESSION['act']))
            redirect('');

        $username = $_SESSION['act']['username'];
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
        
    }
}

?>