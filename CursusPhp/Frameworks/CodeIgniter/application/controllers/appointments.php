<?php

class Appointments extends CI_Controller {
    
    public function index() {
        
        if(!$this->session->userdata('user'))
            redirect('profile/login');
        
        $appointments = $this->AppointmentModel->loadall();
        $data['appointments'] = $appointments == FALSE ? array() : $appointments;
        
        $this->template->write('title', 'Afsprakenplanner');
        $this->template->write_view('content', 'appointments/view', $data);
        $this->template->render();
    }
    
}