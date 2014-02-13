<?php

class Admin extends CI_Controller {

    public function __construct() {
        parent::__construct();

        $this->load->library('form_validation');

        $this->form_validation->set_message('required', 'Het %s veld is verplicht');
        $this->form_validation->set_message('min_length', 'Het %s veld moet minstens %d karakters lang zijn');
        $this->form_validation->set_message('max_length', 'Het %s veld mag maximum %d karakters lang zijn');
        $this->form_validation->set_message('alpha_numeric', 'Enkel alpha-numerieke karakters zijn toegelaten');
    }

    public function index() {
        $this->users();
    }

    public function users() {

        if (!$this->session->userdata('user'))
            redirect(base_url() . 'profile/login');

        if ($this->session->userdata('user')->accesslevel < LECTURER)
            redirect(base_url());

        $search = isset($_GET['search']) ? $_GET['search'] : '';

        $users = strlen($search) ? $this->UserModel->search($search) : $this->UserModel->loadall();

        $data['users'] = $users;
        $data['search'] = $search;

        $this->template->write('title', 'Gebruikers');
        $this->template->write_view('content', 'admin/users', $data);
        $this->template->render();
    }

    public function edituser($username) {

        if (!$this->session->userdata('user'))
            redirect(base_url() . 'profile/login');

        if ($this->session->userdata('user')->accesslevel < ADMIN)
            redirect(base_url() . 'admin/users');

        $user = $this->UserModel->load($username);
        if ($user == FALSE)
            redirect(base_url() . 'admin/users');

        if ($user->accesslevel >= $this->session->userdata('user')->accesslevel)
            redirect(base_url() . 'profile/view/' . $user->username);

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
            $email = $this->form_validation->set_value('email');

            $this->UserModel->edit($user->userid, $username, $firstname, $lastname, $email);
            $data['user'] = $this->UserModel->load($username);
            $this->template->write('title', 'Gebruiker gewijzigd');
            $this->template->write_view('content', 'admin/edituser_success', $data);
            $this->template->render();
            return;
        }

        $data['user'] = $user;
        $this->template->write('title', 'Wijzig gebruiker');
        $this->template->write_view('content', 'admin/edituser', $data);
        $this->template->render();
    }
    
    public function deleteuser($username) {
        
        if (!$this->session->userdata('user'))
            redirect(base_url() . 'profile/login');

        if ($this->session->userdata('user')->accesslevel < ADMIN)
            redirect(base_url() . 'admin/users');

        $user = $this->UserModel->load($username);
        if ($user == FALSE)
            redirect(base_url() . 'admin/users');

        if ($user->accesslevel >= $this->session->userdata('user')->accesslevel)
            redirect(base_url() . 'profile/view/' . $user->username);
        
        $this->UserModel->delete($user->userid);
        
        $this->template->write('title', 'Gebruiker verwijderd');
        $this->template->write_view('content', 'admin/delete_success');
        $this->template->render();
        
    }
    
    public function act_as($username) {
        
        if (!$this->session->userdata('user'))
            redirect(base_url() . 'profile/login');

        if ($this->session->userdata('user')->accesslevel < ADMIN)
            redirect(base_url() . 'admin/users');

        $user = $this->UserModel->load($username);
        if ($user == FALSE)
            redirect(base_url() . 'admin/users');

        if ($user->accesslevel >= $this->session->userdata('user')->accesslevel)
            redirect(base_url() . 'profile/view/' . $user->username);
        
        // Retrieve user to act as
        $actuser = $this->UserModel->load($username);
        
        // Store my old session
        $this->session->set_userdata('act', $this->session->userdata('user'));
        
        // Set the new session
        $this->session->set_userdata('user', $actuser);
        redirect(base_url());
    }
    
    public function stopact_as() {
        
        if (!$this->session->userdata('user'))
            redirect(base_url() . 'profile/login');

        if(!$this->session->userdata('act'))
            redirect(base_url());
        
        $username = $this->session->userdata('act')->username;
        $this->session->unset_userdata('user');
        $this->session->unset_userdata('act');
        $this->session->set_userdata('user', $this->UserModel->load($username));
        redirect(base_url());
    }

}
