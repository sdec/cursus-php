<?php

class Appointments extends CI_Controller {

    public function __construct() {
        parent::__construct();

        $this->load->library('form_validation');

        // Set common form rules
        $this->form_validation->set_message('required', 'Het %s veld is verplicht');
        $this->form_validation->set_message('min_length', 'Het %s veld moet minstens %d karakters lang zijn');
        $this->form_validation->set_message('max_length', 'Het %s veld mag maximum %d karakters lang zijn');
    }

    public function index() {

        if (!$this->session->userdata('user'))
            redirect('profile/login');

        $appointments = $this->AppointmentModel->loadall($this->session->userdata('user')->userid);
        $data['appointments'] = $appointments;

        $this->template->write('title', 'Afsprakenplanner');
        $this->template->write_view('content', 'appointments/view', $data);
        $this->template->render();
    }

    public function create() {

        if (!$this->session->userdata('user'))
            redirect('profile/login');

        if ($this->session->userdata('user')->accesslevel < LECTURER)
            redirect('appointments');

        $rules = array(
            array(
                'field' => 'date',
                'label' => 'datum afspraak',
                'rules' => 'trim|required'
            ),
            array(
                'field' => 'start',
                'label' => 'startuur',
                'rules' => 'trim|required'
            ),
            array(
                'field' => 'end',
                'label' => 'einduur',
                'rules' => 'trim|required'
            ),
            array(
                'field' => 'description',
                'label' => 'beschrijving',
                'rules' => 'trim|required|min_length[4]|max_length[128]'
            ),
            array(
                'field' => 'location',
                'label' => 'locatie',
                'rules' => 'trim|required|min_length[4]|max_length[32]'
            )
        );
        $this->form_validation->set_rules($rules);

        if ($this->form_validation->run() == TRUE) {

            $date = $this->form_validation->set_value('date');
            $start = $this->form_validation->set_value('start');
            $end = $this->form_validation->set_value('end');
            $description = $this->form_validation->set_value('description');
            $location = $this->form_validation->set_value('location');

            $start_timestamp = $date . ' ' . $start;
            $end_timestamp = $date . ' ' . $end;

            if ($this->AppointmentModel->create($start_timestamp, $end_timestamp, $description, $location) == TRUE) {

                $data['date'] = $date;
                $data['start'] = $start;
                $data['end'] = $end;
                $data['description'] = $description;
                $data['location'] = $location;

                $this->template->write('title', 'Afspraak aangemaakt');
                $this->template->write_view('content', 'appointments/create_success', $data);
                $this->template->render();
                return;
            } else {
                $this->template->write('message', 'Er ging iets fout tijdens het aanmaken van uw afspraak!');
            }
        }

        $this->template->write('title', 'Afspraak maken');
        $this->template->write_view('content', 'appointments/create');
        $this->template->render();
    }

    public function detail($appointmentid) {

        if (!$this->session->userdata('user'))
            redirect('profile/login');

        $appointment = $this->AppointmentModel->load($appointmentid);

        if ($appointment == FALSE)
            redirect('appointments');

        $appointment->date = date('d M Y', strtotime($appointment->start_timestamp));
        $appointment->start = date('H:i', strtotime($appointment->start_timestamp));
        $appointment->end = date('H:i', strtotime($appointment->end_timestamp));

        $currentTime = time();
        $appointment->started = strtotime($appointment->start_timestamp) <= $currentTime;
        $appointment->ended = strtotime($appointment->end_timestamp) <= $currentTime;
        $appointment->chronological = TRUE;
        
        $slots = $this->AppointmentModel->slots($appointmentid);

        $subscribtion['subscribed'] = FALSE;
        $subscribtion['lastSubscribed'] = -1;
        
        if ($slots) {
            foreach ($slots as $slot) {
                if ($slot->subscriberid == $this->session->userdata('user')->userid) {
                    $subscribtion['subscribed'] = TRUE;
                    $subscribtion['lecturerid'] = $slot->lecturerid;
                    $subscribtion['lecturer'] = $slot->lecturer;
                    $subscribtion['subscribestart'] = $slot->start;
                    $subscribtion['subscribeend'] = $slot->end;
                    $subscribtion['subscribeslotid'] = $slot->appointmentslotid;
                    break;
                }
                
                if($slot->subscribeid) {
                    $subscribtion['lastSubscribed'] = $slot->subscribeid;
                }
            }
        }

        $data['appointment'] = $appointment;
        $data['slots'] = $slots;
        $data['subscribtion'] = $subscribtion;

        $this->template->write('title', 'Afspraak bekijken');
        $this->template->write_view('content', 'appointments/detail', $data);
        $this->template->render();
    }

    public function subscribe($appointmentid, $appointmentslotid) {
        if (!$this->session->userdata('user'))
            redirect('profile/login');

        $this->AppointmentModel->subscribe($appointmentslotid, $this->session->userdata('user')->userid);

        $data['appointmentid'] = $appointmentid;
        $this->template->write('title', 'Ingeschreven voor afspraak');
        $this->template->write_view('content', 'appointments/subscribe_success', $data);
        $this->template->render();
    }

    public function unsubscribe($appointmentid, $appointmentslotid) {
        if (!$this->session->userdata('user'))
            redirect('profile/login');

        $this->AppointmentModel->unsubscribe($appointmentslotid, $this->session->userdata('user')->userid);

        $data['appointmentid'] = $appointmentid;
        $this->template->write('title', 'Uitgeschreven voor afspraak');
        $this->template->write_view('content', 'appointments/unsubscribe_success', $data);
        $this->template->render();
    }

    public function delete($appointmentid) {

        if (!$this->session->userdata('user'))
            redirect('profile/login');

        if ($this->session->userdata('user')->accesslevel < LECTURER)
            redirect('appointments');

        $this->AppointmentModel->delete($appointmentid);

        $this->template->write('title', 'Afspraak verwijderd');
        $this->template->write_view('content', 'appointments/delete_success');
        $this->template->render();
    }

    public function addlecturer($appointmentid) {

        if (!$this->session->userdata('user'))
            redirect('profile/login');

        if ($this->session->userdata('user')->accesslevel < LECTURER)
            redirect('appointments');

        $appointment = $this->AppointmentModel->load($appointmentid);
        if ($appointment == FALSE)
            redirect('appointments');
        
        $data['appointment'] = $appointment;
        
        $rules = array(
            array(
                'field' => 'start',
                'label' => 'startuur',
                'rules' => 'trim|required'
            ),
            array(
                'field' => 'end',
                'label' => 'einduur',
                'rules' => 'trim|required'
            ),
            array(
                'field' => 'interval',
                'label' => 'slotlengte',
                'rules' => 'trim|required'
            )
        );
        $this->form_validation->set_rules($rules);

        if ($this->form_validation->run() == TRUE) {

            $lecturerid = $_POST['lecturerid'];
            $start = $this->form_validation->set_value('start');
            $end = $this->form_validation->set_value('end');
            $interval = $this->form_validation->set_value('interval');
            
            $start_timestamp = date('Y-m-d', strtotime($appointment->start_timestamp)) . ' ' . $start;
            $end_timestamp = date('Y-m-d', strtotime($appointment->start_timestamp)) . ' ' . $end;
            $interval_timestamp = date('Y-m-d', strtotime($appointment->start_timestamp)) . ' ' . $interval;
            
            // First slot must not exceed the end of the appointment for this lecturer
            if (strtotime($start_timestamp . ' +' . $interval_timestamp) <= strtotime($end_timestamp)) {

                // Starting hour must not lie before the starting point of the appointment
                if (strtotime($start_timestamp) >= strtotime($appointment->start_timestamp)) {

                    // Ending hour must not lie before the starting point of the appointment
                    if (strtotime($end_timestamp) <= strtotime($appointment->end_timestamp)) {
                        
                        if ($this->AppointmentModel->addlecturer($appointmentid, $lecturerid, $start_timestamp, $end_timestamp, $interval_timestamp) == TRUE) {

                            $this->template->write('title', 'Organisator toegevoegd');
                            $this->template->write_view('content', 'appointments/addlecturer_success', $data);
                            $this->template->render();
                            return;
                        } else {
                            $this->template->write('message', 'Er ging iets fout tijdens het aanmaken van uw afspraak!');
                        }
                    } else {
                        $this->template->write('message', 'Het einduur van de afspraken moet gelijk aan of vroeger zijn dan '
                                . date('H:i', strtotime($appointment->end_timestamp)));
                    }
                } else {
                    $this->template->write('message', 'Het startuur van de afspraken moet gelijk aan of later zijn dan '
                            . date('H:i', strtotime($appointment->start_timestamp)));
                }
            } else {
                $this->template->write('message', 'Het einde van uw eerste slot mag het einduur niet overschrijden');
            }
        }

        $lecturers = $this->UserModel->lecturers();
        $data['lecturers'] = $lecturers;
        
        $this->template->write('title', 'Organisator toevoegen');
        $this->template->write_view('content', 'appointments/addlecturer', $data);
        $this->template->render();
    }

}