<?php

class Appointments extends CI_Controller {
    
    public function index() {
        
        if(!$this->session->userdata('user'))
            redirect('profile/login');
        
        $this->template->write('title', 'Afsprakenplanner');
        $this->template->write_view('content', 'appointments/view');
        $this->template->render();
    }
    
}