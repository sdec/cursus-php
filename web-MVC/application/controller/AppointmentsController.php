<?php

class AppointmentsController extends Controller {
    
    private $appointmentmodel;
    private $usermodel;
    
    public function __construct() {
        parent::__construct();
        
        $this->usermodel = new User_Mapper();
        $this->appointmentmodel = new Appointment_Mapper();
    }
    
    public function index(){
        if(!SessionHelper::loggedin())
            RouteHelper::redirect('profile/login');
        
        $search = $this->_input->post('search');
        $appointments = ($search) 
            ? $this->appointmentmodel->searchAppointments($search) 
            : $this->appointmentmodel->loadAllAppointments();

        $this->_template->appointments = $appointments;
        $this->_template->search = $search;
        
        $this->_template->setPageTitle('Afspraken');
        $this->_template->render('appointments/index');
    }
    
    public function detail($appointmentid = -1){
        if (!SessionHelper::loggedin() || $appointmentid == -1)
            RouteHelper::redirect('profile/login');
        $appointment = $this->appointmentmodel->loadAppointment($appointmentid);
        if (!$appointment->appointmentid){
            FormHelper::message("Oops! We hebben een niet-bestaande appointmentid gedetecteerd!", "warning");
            RouteHelper::redirect('');
        }

        $appointment->date = date('d M Y', strtotime($appointment->start_timestamp));
        $appointment->start = date('H:i', strtotime($appointment->start_timestamp));
        $appointment->end = date('H:i', strtotime($appointment->end_timestamp));

        $currentTime = time();
        $appointment->started = strtotime($appointment->start_timestamp) <= $currentTime;
        $appointment->ended = strtotime($appointment->end_timestamp) <= $currentTime;


        $slots = $this->appointmentmodel->slots($appointmentid);
        
        $subscription = new StdClass;
        $subscription->subscribed = FALSE;

        if ($slots) {
            $availableCount = 0;
            foreach($slots as $slot) {
                if ($slot->subscriberid == SessionHelper::userdata('userid')) {
                    $subscription->subscribed = TRUE;
                    $subscription->lecturerid = $slot->lecturerid;
                    $subscription->lecturer = $slot->lecturer;
                    $subscription->subscribestart = $slot->start;
                    $subscription->subscribeend = $slot->end;
                    $subscription->subscribeslotid = $slot->appointmentslotid;
                    break;
                }

                if (!$slot->subscriberid && $availableCount == 0 || !$appointment->chronological) {
                    $slot->available = TRUE;
                    $availableCount++;
                } else {
                    $slot->available = FALSE;
                }
            }
        }
        
        $this->_template->appointment = $appointment;
        $this->_template->slots = $slots;
        $this->_template->subscription = $subscription;
        
        $this->_template->setPageTitle('Afspraak detail');
        $this->_template->render('appointments/detail');
    }
    
    public function subscribe($appointmentid = -1, $slotid = -1){
        if (!SessionHelper::loggedin())
            RouteHelper::redirect('profile/login');

        $appointmentid = isset($appointmentid) ? trim($appointmentid) : -1;
        $appointmentslotid = isset($slotid) ? trim($slotid) : -1;

        if ($appointmentid == -1 || $appointmentslotid == -1)
            RouteHelper::redirect('');

        $appointment = $this->appointmentmodel->loadAppointment($appointmentid);
        if (!$appointment->appointmentid){
            FormHelper::message("Oops! We hebben een niet-bestaande appointmentid gedetecteerd!", "warning");
            $this->detail($appointmentid);
            die();
        }

        if ($this->appointmentmodel->subscribeAppointment($appointmentslotid, SessionHelper::userdata('userid'))) {
            $this->_template->appointmentid = $appointment->appointmentid;
            
            $this->_template->setPageTitle('Ingeschreven');
            $this->_template->render('appointments/subscribe_success');
            
            die();
        } else {
            FormHelper::message("Onze excuses, er is iets misgegaan tijdens het inschrijven voor het inschrijfslot met id $appointmentslotid van de afspraak met id " . $appointment['appointmentid'] . ".", "danger");
        }
        $this->detail($appointmentid);
    }

    public function unsubscribe($appointmentid = -1, $slotid = -1){
        if (!SessionHelper::loggedin())
            RouteHelper::redirect('profile/login');

        $appointmentid = isset($appointmentid) ? trim($appointmentid) : -1;
        $appointmentslotid = isset($slotid) ? trim($slotid) : -1;

        if($appointmentid == -1 || $appointmentslotid == -1)
            RouteHelper::redirect('');

        $appointment = $this->appointmentmodel->loadAppointment($appointmentid);
        if (!$appointment->appointmentid){
            FormHelper::message("Oops! We hebben een niet-bestaande appointmentid gedetecteerd!", "warning");
            $this->detail($appointmentid);
            die();
        }

        if($this->appointmentmodel->unSubscribeAppointment($appointmentslotid, SessionHelper::userdata('userid'))){
            $this->_template->appointmentid = $appointment->appointmentid;
            
            $this->_template->setPageTitle('Uitgeschreven');
            $this->_template->render('appointments/unsubscribe_success');
            
            die();
        } else {
            FormHelper::message("Onze excuses, er is iets misgegaan tijdens het inschrijven voor het inschrijfslot met id $appointmentslotid van de afspraak met id " . $appointment['appointmentid'] . ".", "danger");
        }
        $this->detail($appointmentid);
    }
    
    public function create(){
        if (!SessionHelper::loggedin() || SessionHelper::userdata('accesslevel') < LECTURER)
            RouteHelper::redirect('profile/login');

        if($this->_input->post('submit') == '') {
            if($this->_input->post('date') && $this->_input->post('start') && $this->_input->post('end') && $this->_input->post('description') && $this->_input->post('location')) {

                $this->_template->_form->set_value('date', $this->_input->post('date'));
                $this->_template->_form->set_value('start', $this->_input->post('start'));
                $this->_template->_form->set_value('end', $this->_input->post('end'));
                $this->_template->_form->set_value('description', $this->_input->post('description'));
                $this->_template->_form->set_value('location', $this->_input->post('location'));
                $this->_template->_form->set_value('chronological', $this->_input->post('chronological'));

                if($this->_template->_form->isMinLength('description', 4) == FALSE)
                    set_error ('description', 'Het omschrijvingsveld moet minstens 4 karakters lang zijn');

                if($this->_template->_form->isMinLength('location', 3) == FALSE)
                    set_error ('location', 'Het locatieveld moet minstens 3 karakters lang zijn');

                if($this->_template->_form->isMaxLength('location', 32) == FALSE)
                    set_error ('location', 'Het locatieveld veld max maximum 32 karakters lang zijn');

                if($this->_template->_form->isMaxLength('description', 128) == FALSE) 
                        set_error ('description', 'Het omschrijvingsveld max maximum 128 karakters lang zijn');

                if($this->_template->_form->hasErrors() == FALSE) {
                    if($appointmentid = $this->appointmentmodel->createAppointment($this->_template->_form->set_value('date').' '.$this->_template->_form->set_value('start'), $this->_template->_form->set_value('date').' '.$this->_template->_form->set_value('end'), $this->_template->_form->set_value('description'), $this->_template->_form->set_value('location'), $this->_template->_form->set_value('chronological'))) {
                        $appointment = $this->appointmentmodel->loadAppointment($appointmentid);
                        $appointment->date = date('d M Y', strtotime($appointment->start_timestamp));
                        $appointment->start = date('H:i', strtotime($appointment->start_timestamp));
                        $appointment->end = date('H:i', strtotime($appointment->end_timestamp));
                        $this->_template->appointment = $appointment;
                        
                        $this->_template->setPageTitle('Afspraak aanmaken');
                        $this->_template->render('appointments/create_success');
                        
                        die;
                    } else {
                        FormHelper::message('Er ging iets fout tijdens het aanmaken van uw afspraak!', 'danger');
                    }
                }
            }
        } else {
            // Set default form values
            $this->_template->_form->set_value('date', date('Y-m-d', time()));
            $this->_template->_form->set_value('start', '08:00');
            $this->_template->_form->set_value('end', '16:00');
        }
        
        $this->_template->setPageTitle('Afspraak aanmaken');
        $this->_template->render('appointments/create');
    }
    
    public function delete($appointmentid = -1){
        if(!SessionHelper::loggedin() || SessionHelper::userdata('accesslevel') < LECTURER || $appointmentid == -1)
            RouteHelper::redirect('profile/login');

        $appointment = $this->appointmentmodel->deleteAppointment($appointmentid);
        if($appointment == FALSE){
            FormHelper::message("Onze excuses, er is *iets* mis gegaan met het deleten van afspraak met id $appointmentid!", "danger");
            $this->detail($appointment);
            die();
        } else {
            FormHelper::message("Uw afspraak werd succesvol geannuleerd!");
        }
        RouteHelper::redirect('');
    }

    public function edit($appointmentid = -1){
        if(!SessionHelper::loggedin() || SessionHelper::userdata('accesslevel') < LECTURER || $appointmentid == -1)
            RouteHelper::redirect('profile/login');

        $appointment = $this->appointmentmodel->loadAppointment($appointmentid);
        if (!$appointment->appointmentid){
            FormHelper::message("Oops! We hebben een niet-bestaande appointmentid gedetecteerd!", "warning");
            $this->detail($appointmentid);
            die();
        }

        $slots = $this->appointmentmodel->slots($appointment->appointmentid);

        if($this->_input->post('submit') == '') {
            if($this->_input->post('date') && $this->_input->post('start') && $this->_input->post('end') && $this->_input->post('description') && $this->_input->post('location')) {

                $this->_template->_form->set_value('date', $this->_input->post('date'));
                $this->_template->_form->set_value('start', $this->_input->post('start'));
                $this->_template->_form->set_value('end', $this->_input->post('end'));
                $this->_template->_form->set_value('description', $this->_input->post('description'));
                $this->_template->_form->set_value('location', $this->_input->post('location'));
                $this->_template->_form->set_value('chronological', $this->_input->post('chronological'));

                if($this->_template->_form->isMinLength('description', 4) == FALSE)
                    set_error ('description', 'Het omschrijvingsveld moet minstens 4 karakters lang zijn');

                if($this->_template->_form->isMinLength('location', 3) == FALSE)
                    set_error ('location', 'Het locatieveld moet minstens 3 karakters lang zijn');

                if($this->_template->_form->isMaxLength('description', 128) == FALSE) 
                    set_error ('description', 'Het omschrijvingsveld max maximum 128 karakters lang zijn');

                if($this->_template->_form->isMaxLength('location', 32) == FALSE)
                    set_error ('location', 'Het locatieveld veld max maximum 32 karakters lang zijn');

                if($this->_template->_form->hasErrors() == FALSE) {
                    $this->appointmentmodel->editAppointment($appointment->appointmentid, 
                        $this->_template->_form->set_value('date').' '.$this->_template->_form->set_value('start'), 
                        $this->_template->_form->set_value('date').' '.$this->_template->_form->set_value('end'), 
                        $this->_template->_form->set_value('description'), $this->_template->_form->set_value('location'), $this->_template->_form->set_value('chronological'));
                    $appointment = $this->appointmentmodel->loadAppointment($appointment->appointmentid);
                    $appointment->date = date('Y-m-d', strtotime($appointment->start_timestamp));
                    $appointment->start = date('H:i', strtotime($appointment->start_timestamp));
                    $appointment->end = date('H:i', strtotime($appointment->end_timestamp));
                    $this->_template->appointment = $appointment;
                    
                    $this->_template->setPageTitle('Afspraak wijzigen');
                    $this->_template->render('appointments/edit_success');
                    
                    die;
                }
            }
        } else {

            // Set default form values from database
            $appointment->date = date('Y-m-d', strtotime($appointment->start_timestamp));
            $appointment->start = date('H:i', strtotime($appointment->start_timestamp));
            $appointment->end = date('H:i', strtotime($appointment->end_timestamp));

            $this->_template->_form->set_value('date', $appointment->date);
            $this->_template->_form->set_value('start', $appointment->start);
            $this->_template->_form->set_value('end', $appointment->end);
            $this->_template->_form->set_value('description', $appointment->description);
            $this->_template->_form->set_value('location', $appointment->location);
            $this->_template->_form->set_value('chronological', $appointment->chronological);
        }
        
        $this->_template->slots = $slots;
        $this->_template->appointment = $appointment;
        
        $this->_template->setPageTitle('Afspraak wijzigen');
        $this->_template->render('appointments/edit');
                    
        die;
    }
    
    public function addtimeslots($appointmentid = -1){
        if(!SessionHelper::loggedin() || SessionHelper::userdata('accesslevel') < LECTURER || $appointmentid == -1)
            RouteHelper::redirect('profile/login');

        $lecturers = $this->usermodel->lecturers();
        $appointment = $this->appointmentmodel->loadAppointment($appointmentid);
        if (!$appointment->appointmentid){
            FormHelper::message("Oops! We hebben een niet-bestaande appointmentid gedetecteerd!", "warning");
            $this->detail($appointmentid);
            die();
        }

        if($this->_input->post('submit') == '') {
            if($this->_input->post('start') && $this->_input->post('end') && $this->_input->post('interval')) {
                $lecturerid = $this->_input->post('lecturerid');
                $this->_template->_form->set_value('start', $this->_input->post('start'));
                $this->_template->_form->set_value('end', $this->_input->post('end'));
                $this->_template->_form->set_value('interval', $this->_input->post('interval'));

                $start_timestamp = date('Y-m-d', strtotime($appointment->start_timestamp)) . ' ' . $this->_template->_form->set_value('start');
                $end_timestamp = date('Y-m-d', strtotime($appointment->start_timestamp)) . ' ' . $this->_template->_form->set_value('end');
                $interval_timestamp = date('Y-m-d', strtotime($appointment->start_timestamp)) . ' ' . $this->_template->_form->set_value('interval');

                $start_end = strtotime($start_timestamp) + (strtotime(date('Y-m-d H:i:s', strtotime($interval_timestamp))) - strtotime(date('Y-m-d', strtotime($interval_timestamp))));
                // First slot must not exceed the end of the appointment for this lecturer
                if ($start_end <= strtotime($end_timestamp)) {

                    // Starting hour must not lie before the starting point of the appointment
                    if (strtotime($start_timestamp) >= strtotime($appointment->start_timestamp)) {

                        // Ending hour must not lie before the starting point of the appointment
                        if (strtotime($end_timestamp) <= strtotime($appointment->end_timestamp)) {

                            if ($this->appointmentmodel->addTimeSlotsAppointment($appointmentid, $lecturerid, $start_timestamp, $end_timestamp, $interval_timestamp) == TRUE) {
                                $this->_template->appointmentid = $appointmentid;
                                
                                $this->_template->setPageTitle('Tijdsloten toevoegen');
                                $this->_template->render('appointments/addtimeslots_success');
                                
                                die;
                            } else {
                                FormHelper::message('Er ging iets fout tijdens het aanmaken van uw afspraak!', 'danger');
                            }
                        } else {
                            FormHelper::message('Het einduur van de afspraken moet gelijk aan of vroeger zijn dan '
                                    . date('H:i', strtotime($appointment->end_timestamp)), 'danger');
                        }
                    } else {
                        FormHelper::message('Het startuur van de afspraken moet gelijk aan of later zijn dan '
                                . date('H:i', strtotime($appointment->start_timestamp)), 'danger');
                    }
                } else {
                    FormHelper::message('Het einde van uw eerste slot mag het einduur niet overschrijden', 'danger');
                }
            }
        } else {
            // Set default form values
            $this->_template->_form->set_value('start', date('H:i', strtotime($appointment->start_timestamp)));
            $this->_template->_form->set_value('end', date('H:i', strtotime($appointment->end_timestamp)));
            $this->_template->_form->set_value('interval', '00:15');
        }
        
        $this->_template->lecturers = $lecturers;
        $this->_template->appointment = $appointment;
        
        $this->_template->setPageTitle('Tijdsloten toevoegen');
        $this->_template->render('appointments/addtimeslots');
    }
    
    public function deletetimeslot($appointmentid = -1, $appointmentSlotid = -1){
        if(!SessionHelper::loggedin() || SessionHelper::userdata('accesslevel') < LECTURER || $appointmentid == -1 || $appointmentSlotid == -1)
            RouteHelper::redirect('profile/login');
        $appointment = $this->appointmentmodel->loadAppointment($appointmentid);
        if (!$appointment->appointmentid){
            FormHelper::message("Oops! We hebben een niet-bestaande appointmentid gedetecteerd!", "warning");
            $this->detail($appointmentid);
            die();
        }

        if($this->appointmentmodel->deleteTimeSlotAppointment($appointmentSlotid))
            FormHelper::message("Het tijdsslot werd successvol gedelete!", "success");
        $this->edit($appointmentid);
    }
}
?>
