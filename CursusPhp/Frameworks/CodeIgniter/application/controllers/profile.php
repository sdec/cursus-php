<?php

class Profile extends CI_Controller {

    public function __construct() {
        parent::__construct();

        $this->load->library('form_validation');

        // Set common form rules
        $this->form_validation->set_message('required', 'Het %s veld is verplicht');
        $this->form_validation->set_message('min_length', 'Het %s veld moet minstens %d karakters lang zijn');
        $this->form_validation->set_message('max_length', 'Het %s veld mag maximum %d karakters lang zijn');
        $this->form_validation->set_message('alpha_numeric', 'Enkel alpha-numerieke karakters zijn toegelaten');
    }

    public function index() {
        $this->login();
    }

    public function login() {

        // Check if user is already logged in
        if ($this->session->userdata('user'))
            redirect('');

        // Specify rules for login form elements
        $rules = array(
            array(
                'field' => 'username',
                'label' => 'gebruikersnaam',
                'rules' => 'trim|required|min_length[4]|max_length[32]|alpha_numeric'
            ),
            array(
                'field' => 'password',
                'label' => 'paswoord',
                'rules' => 'trim|required|min_length[4]|max_length[128]'
            )
        );
        $this->form_validation->set_rules($rules);

        if ($this->form_validation->run() == TRUE) {

            $username = $this->form_validation->set_value('username');
            $password = $this->form_validation->set_value('password');

            if ($this->UserModel->isCorrectCredentials($username, $password) == TRUE) {

                // Load the user into memory
                $this->session->set_userdata('user', $this->UserModel->load($username));

                $this->template->write('title', 'Log in compleet');
                $this->template->write_view('content', 'profile/login_success');
                $this->template->render();
                return;
            } else {
                $this->template->write('message', 'Foutieve gebruikersnaam/paswoord combinatie!');
            }
        }

        $this->template->write('title', 'Log in');
        $this->template->write_view('content', 'profile/login');
        $this->template->render();
    }

    public function register() {

        // Check if user is already logged in
        if ($this->session->userdata('user'))
            redirect('');

        // Specify rules for register form elements
        $rules = array(
            array(
                'field' => 'username',
                'label' => 'gebruikersnaam',
                'rules' => 'is_unique[users.username]|trim|required|min_length[4]|max_length[32]|alpha_numeric'
            ),
            array(
                'field' => 'firstname',
                'label' => 'voornaam',
                'rules' => 'trim|required|min_length[2]|max_length[32]|alpha_numeric'
            ),
            array(
                'field' => 'lastname',
                'label' => 'familienaam',
                'rules' => 'trim|required|min_length[2]|max_length[32]|alpha_numeric'
            ),
            array(
                'field' => 'password',
                'label' => 'paswoord',
                'rules' => 'trim|required|min_length[4]|max_length[128]'
            ),
            array(
                'field' => 'passwordConfirm',
                'label' => 'herhaal paswoord',
                'rules' => 'matches[password]'
            ),
            array(
                'field' => 'email',
                'label' => 'email',
                'rules' => 'valid_email'
            )
        );
        $this->form_validation->set_rules($rules);
        $this->form_validation->set_message('is_unique', 'Deze %s bestaat bestaat al');
        $this->form_validation->set_message('matches', 'Het %s en %s veld moeten hetzelfde zijn');


        if ($this->form_validation->run() == TRUE) {

            $username = $this->form_validation->set_value('username');
            $firstname = $this->form_validation->set_value('firstname');
            $lastname = $this->form_validation->set_value('lastname');
            $password = $this->form_validation->set_value('password');
            $email = $this->form_validation->set_value('email');

            if ($this->UserModel->register($username, $firstname, $lastname, $password, $email) == TRUE) {

                // Load the user into memory
                $this->session->set_userdata('user', $this->UserModel->load($username));

                $this->template->write('title', 'Registratie compleet');
                $this->template->write_view('content', 'profile/register_success');
                $this->template->render();
                return;
            } else {
                $this->template->write('message', 'Er deed zich een fout voor tijdens de registratie!');
            }
        }

        $this->template->write('title', 'Registreren');
        $this->template->write_view('content', 'profile/register');
        $this->template->render();
    }

    public function logout() {

        // Check if user is already logged out
        if (!$this->session->userdata('user'))
            redirect('profile/login');

        // Unset user session data
        $this->session->unset_userdata('user');
        
        // Should the user be acting as someone else, also end that session
        $this->session->unset_userdata('act');
        
        $this->template->write('title', 'Log out');
        $this->template->write_view('content', 'profile/logout_success');
        $this->template->render();
    }

    public function view($username = null) {
        
        if (!$this->session->userdata('user'))
            redirect(base_url() . 'profile/login');

        $user = null;
        if($username) {
            if ($this->session->userdata('user')->accesslevel < LECTURER)
                redirect(base_url() . 'profile/view');
            
            $user = $this->UserModel->load($username);
            
            if($user == FALSE)
                redirect(base_url() . 'profile/view');
            
        } else {
            $user = $this->session->userdata('user');
        }
        
        $data['user'] = $user;
        
        $this->template->write('title', 'Mijn profiel');
        $this->template->write_view('content', 'profile/view', $data);
        $this->template->render();
        
    }
    
    public function appointments($username = '') {
        
        if (!$this->session->userdata('user'))
            redirect('profile/login');
        
        $user = null;
        if(strlen($username)) {
            $user = $this->UserModel->load($username);
        } else {
            $user = $this->session->userdata('user');
        }
        
        if($user == FALSE)
            redirect('');
        
        $search = isset($_GET['search']) ? $_GET['search'] : '';
        $appointments = strlen($search) 
                            ? $this->AppointmentModel->search($search) 
                            : $this->AppointmentModel->loadall($user->userid);
        
        $data['appointments'] = $appointments;
        $data['search'] = $search;
        
        $this->template->write('title', 'Mijn afspraken');
        $this->template->write_view('content', 'profile/appointments', $data);
        $this->template->render();
        
    }
    
}