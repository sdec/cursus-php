<?php

class Home extends CI_Controller {
    
    public function index() {
        
        if(!$this->session->userdata('user'))
            redirect('profile/login');
        
        $this->template->write('title', 'Home');
        $this->template->write_view('content', 'home');
        $this->template->render();
    }
    
}