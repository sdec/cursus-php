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
        if(!loggedIn())
            redirect('profile/login');
        
        $search = isset($_POST['search']) ? $_POST['search'] : '';
        $appointments = strlen($search) 
            ? $this->appointmentmodel->searchAppointments($search) 
            : $this->appointmentmodel->loadAllAppointments();

        $this->_template->appointments = $appointments;
        $this->_template->search = $search;
        
        $this->_template->setPageTitle('Afspraken');
        $this->_template->render('appointments/index');
    }
    
    public function detail($appointmentid = -1){
        if (!loggedin() || $appointmentid == -1)
            redirect('');
        $appointment = $this->appointmentmodel->loadAppointment($appointmentid);
        if (!$appointment['appointmentid']){
            message("Oops! We hebben een niet-bestaande appointmentid gedetecteerd!", "warning");
            redirect('');
        }

        $appointment['date'] = date('d M Y', strtotime($appointment['start_timestamp']));
        $appointment['start'] = date('H:i', strtotime($appointment['start_timestamp']));
        $appointment['end'] = date('H:i', strtotime($appointment['end_timestamp']));

        $currentTime = time();
        $appointment['started'] = strtotime($appointment['start_timestamp']) <= $currentTime;
        $appointment['ended'] = strtotime($appointment['end_timestamp']) <= $currentTime;


        $slots = $this->appointmentmodel->slots($appointmentid);

        $subscription['subscribed'] = FALSE;

        if ($slots) {
            $availableCount = 0;
            for($i = 0; $i < count($slots); $i++) {
                if ($slots[$i]['subscriberid'] == userdata('userid')) {
                    $subscription['subscribed'] = TRUE;
                    $subscription['lecturerid'] = $slots[$i]['lecturerid'];
                    $subscription['lecturer'] = $slots[$i]['lecturer'];
                    $subscription['subscribestart'] = $slots[$i]['start'];
                    $subscription['subscribeend'] = $slots[$i]['end'];
                    $subscription['subscribeslotid'] = $slots[$i]['appointmentslotid'];
                    break;
                }

                if (!$slots[$i]['subscriberid'] && $availableCount == 0 || !$appointment['chronological']) {
                    $slots[$i]['available'] = TRUE;
                    $availableCount++;
                } else {
                    $slots[$i]['available'] = FALSE;
                }
            }
        }
        
        $this->_template->data['appointment'] = $appointment;
        $this->_template->data['slots'] = $slots;
        $this->_template->data['subscription'] = $subscription;
        
        $this->_template->setPageTitle('Afspraak detail');
        $this->_template->render('appointments/detail');
    }
    
    public function subscribe($appointmentid = -1, $slotid = -1){
        if (!loggedin())
            redirect('');

        $appointmentid = isset($appointmentid) ? trim($appointmentid) : -1;
        $appointmentslotid = isset($slotid) ? trim($slotid) : -1;

        if ($appointmentid == -1 || $appointmentslotid == -1)
            redirect('');

        $appointment = $this->appointmentmodel->loadAppointment($appointmentid);
        if (!$appointment['appointmentid']){
            message("Oops! We hebben een niet-bestaande appointmentid gedetecteerd!", "warning");
            $this->detail($appointmentid);
            die();
        }

        if ($this->appointmentmodel->subscribeAppointment($appointmentslotid, userdata('userid'))) {
            $this->_template->appointmentid = $appointment['appointmentid'];
            
            $this->_template->setPageTitle('Ingeschreven');
            $this->_template->render('appointments/subscribe_success');
            
            die;
        } else {
            message("Onze excuses, er is iets misgegaan tijdens het inschrijven voor het inschrijfslot met id $appointmentslotid van de afspraak met id " . $appointment['appointmentid'] . ".", "danger");
        }
        $this->detail($appointmentid);
    }

    public function unsubscribe($appointmentid = -1, $slotid = -1){
        if (!loggedin())
            redirect('');

        $appointmentid = isset($appointmentid) ? trim($appointmentid) : -1;
        $appointmentslotid = isset($slotid) ? trim($slotid) : -1;

        if($appointmentid == -1 || $appointmentslotid == -1)
            redirect('');

        $appointment = $this->appointmentmodel->loadAppointment($appointmentid);
        if (!$appointment['appointmentid']){
            message("Oops! We hebben een niet-bestaande appointmentid gedetecteerd!", "warning");
            $this->detail($appointmentid);
            die();
        }

        if($this->appointmentmodel->unSubscribeAppointment($appointmentslotid, userdata('userid'))){
            $this->_template->appointmentid = $appointment['appointmentid'];
            
            $this->_template->setPageTitle('Uitgeschreven');
            $this->_template->render('appointments/unsubscribe_success');
            
            die;
        } else {
            message("Onze excuses, er is iets misgegaan tijdens het inschrijven voor het inschrijfslot met id $appointmentslotid van de afspraak met id " . $appointment['appointmentid'] . ".", "danger");
        }
        $this->detail($appointmentid);
    }
    
    public function create(){
        if (!loggedin() || userdata('accesslevel') < LECTURER)
            redirect('');

        if(isset($_POST['submit'])) {
            if(isset($_POST['date']) && isset($_POST['start']) && isset($_POST['end']) && isset($_POST['description']) && isset($_POST['location'])) {

                set_value('date', $_POST['date']);
                set_value('start', $_POST['start']);
                set_value('end', $_POST['end']);
                set_value('description', $_POST['description']);
                set_value('location', $_POST['location']);
                set_value('chronological', isset($_POST['chronological']));

                if(isMinLength('description', 4) == FALSE)
                    set_error ('description', 'Het omschrijvingsveld moet minstens 4 karakters lang zijn');

                if(isMinLength('location', 3) == FALSE)
                    set_error ('location', 'Het locatieveld moet minstens 3 karakters lang zijn');

                if(isMaxLength('location', 32) == FALSE)
                    set_error ('location', 'Het locatieveld veld max maximum 32 karakters lang zijn');

                if(isMaxLength('description', 128) == FALSE) 
                        set_error ('description', 'Het omschrijvingsveld max maximum 128 karakters lang zijn');

                if(hasErrors() == FALSE) {
                    if($appointmentid = $this->appointmentmodel->createAppointment(set_value('date').' '.set_value('start'), set_value('date').' '.set_value('end'), set_value('description'), set_value('location'), set_value('chronological'))) {
                        $appointment = $this->appointmentmodel->loadAppointment($appointmentid);
                        $appointment['date'] = date('d M Y', strtotime($appointment['start_timestamp']));
                        $appointment['start'] = date('H:i', strtotime($appointment['start_timestamp']));
                        $appointment['end'] = date('H:i', strtotime($appointment['end_timestamp']));
                        $this->_template->data['appointment'] = $appointment;
                        
                        $this->_template->setPageTitle('Afspraak aanmaken');
                        $this->_template->render('appointments/create_success');
                        
                        die;
                    } else {
                        message('Er ging iets fout tijdens het aanmaken van uw afspraak!', 'danger');
                    }
                }
            }
        } else {
            // Set default form values
            set_value('date', date('Y-m-d', time()));
            set_value('start', '08:00');
            set_value('end', '16:00');
        }
        
        $this->_template->setPageTitle('Afspraak aanmaken');
        $this->_template->render('appointments/create');
    }
    
    public function delete($appointmentid = -1){
        if(!loggedin() || userdata('accesslevel') < LECTURER || $appointmentid == -1)
            redirect('');

        $appointment = $this->appointmentmodel->deleteAppointment($appointmentid);
        if($appointment == FALSE){
            message("Onze excuses, er is *iets* mis gegaan met het deleten van afspraak met id $appointmentid!", "danger");
            $this->detail($appointment);
            die();
        } else {
            message("Uw afspraak werd succesvol geannuleerd!");
        }
        redirect('');
    }

    public function edit($appointmentid = -1){
        if(!loggedin() || userdata('accesslevel') < LECTURER || $appointmentid == -1)
            redirect('');

        $appointment = $this->appointmentmodel->loadAppointment($appointmentid);
        if (!$appointment['appointmentid']){
            message("Oops! We hebben een niet-bestaande appointmentid gedetecteerd!", "warning");
            $this->detail($appointmentid);
            die();
        }

        $slots = $this->appointmentmodel->slots($appointment['appointmentid']);

        if(isset($_POST['submit'])) {
            if(isset($_POST['date']) && isset($_POST['start']) && isset($_POST['end']) && isset($_POST['description']) && isset($_POST['location'])) {

                set_value('date', $_POST['date']);
                set_value('start', $_POST['start']);
                set_value('end', $_POST['end']);
                set_value('description', $_POST['description']);
                set_value('location', $_POST['location']);
                set_value('chronological', isset($_POST['chronological']));

                if(isMinLength('description', 4) == FALSE)
                    set_error ('description', 'Het omschrijvingsveld moet minstens 4 karakters lang zijn');

                if(isMinLength('location', 3) == FALSE)
                    set_error ('location', 'Het locatieveld moet minstens 3 karakters lang zijn');

                if(isMaxLength('description', 128) == FALSE) 
                    set_error ('description', 'Het omschrijvingsveld max maximum 128 karakters lang zijn');

                if(isMaxLength('location', 32) == FALSE)
                    set_error ('location', 'Het locatieveld veld max maximum 32 karakters lang zijn');

                if(hasErrors() == FALSE) {
                    $this->appointmentmodel->editAppointment($appointment['appointmentid'], 
                        set_value('date').' '.set_value('start'), 
                        set_value('date').' '.set_value('end'), 
                        set_value('description'), set_value('location'), set_value('chronological'));
                    $appointment = $this->appointmentmodel->loadAppointment($appointment['appointmentid']);
                    $appointment['date'] = date('Y-m-d', strtotime($appointment['start_timestamp']));
                    $appointment['start'] = date('H:i', strtotime($appointment['start_timestamp']));
                    $appointment['end'] = date('H:i', strtotime($appointment['end_timestamp']));
                    $this->_template->data['appointment'] = $appointment;
                    
                    $this->_template->setPageTitle('Afspraak wijzigen');
                    $this->_template->render('appointments/edit_success');
                    
                    die;
                }
            }
        } else {

            // Set default form values from database
            $appointment['date'] = date('Y-m-d', strtotime($appointment['start_timestamp']));
            $appointment['start'] = date('H:i', strtotime($appointment['start_timestamp']));
            $appointment['end'] = date('H:i', strtotime($appointment['end_timestamp']));

            set_value('date', $appointment['date']);
            set_value('start', $appointment['start']);
            set_value('end', $appointment['end']);
            set_value('description', $appointment['description']);
            set_value('location', $appointment['location']);
            set_value('chronological', $appointment['chronological']);
        }
        
        $this->_template->data['slots'] = $slots;
        $this->_template->data['appointment'] = $appointment;
        
        $this->_template->setPageTitle('Afspraak wijzigen');
        $this->_template->render('appointments/edit');
                    
        die;
    }
    
    public function addtimeslots($appointmentid = -1){
        if(!loggedin() || userdata('accesslevel') < LECTURER || $appointmentid == -1)
            redirect('');

        $lecturers = $this->usermodel->lecturers();
        $appointment = $this->appointmentmodel->loadAppointment($appointmentid);
        if (!$appointment['appointmentid']){
            message("Oops! We hebben een niet-bestaande appointmentid gedetecteerd!", "warning");
            $this->detail($appointmentid);
            die();
        }

        if(isset($_POST['submit'])) {
            if(isset($_POST['start']) && isset($_POST['end']) && isset($_POST['interval'])) {
                $lecturerid = $_POST['lecturerid'];
                set_value('start', $_POST['start']);
                set_value('end', $_POST['end']);
                set_value('interval', $_POST['interval']);

                $start_timestamp = date('Y-m-d', strtotime($appointment['start_timestamp'])) . ' ' . set_value('start');
                $end_timestamp = date('Y-m-d', strtotime($appointment['start_timestamp'])) . ' ' . set_value('end');
                $interval_timestamp = date('Y-m-d', strtotime($appointment['start_timestamp'])) . ' ' . set_value('interval');

                $start_end = strtotime($start_timestamp) + (strtotime(date('Y-m-d H:i:s', strtotime($interval_timestamp))) - strtotime(date('Y-m-d', strtotime($interval_timestamp))));
                // First slot must not exceed the end of the appointment for this lecturer
                if ($start_end <= strtotime($end_timestamp)) {

                    // Starting hour must not lie before the starting point of the appointment
                    if (strtotime($start_timestamp) >= strtotime($appointment['start_timestamp'])) {

                        // Ending hour must not lie before the starting point of the appointment
                        if (strtotime($end_timestamp) <= strtotime($appointment['end_timestamp'])) {

                            if ($this->appointmentmodel->addTimeSlotsAppointment($appointmentid, $lecturerid, $start_timestamp, $end_timestamp, $interval_timestamp) == TRUE) {
                                $this->_template->data['appointmentid'] = $appointmentid;
                                
                                $this->_template->setPageTitle('Tijdsloten toevoegen');
                                $this->_template->render('appointments/addtimeslots_success');
                                
                                die;
                            } else {
                                message('Er ging iets fout tijdens het aanmaken van uw afspraak!', 'danger');
                            }
                        } else {
                            message('Het einduur van de afspraken moet gelijk aan of vroeger zijn dan '
                                    . date('H:i', strtotime($appointment['end_timestamp'])), 'danger');
                        }
                    } else {
                        message('Het startuur van de afspraken moet gelijk aan of later zijn dan '
                                . date('H:i', strtotime($appointment['start_timestamp'])), 'danger');
                    }
                } else {
                    message('Het einde van uw eerste slot mag het einduur niet overschrijden', 'danger');
                }
            }
        } else {
            // Set default form values
            set_value('start', date('H:i', strtotime($appointment['start_timestamp'])));
            set_value('end', date('H:i', strtotime($appointment['end_timestamp'])));
            set_value('interval', '00:15');
        }
        
        $this->_template->data['lecturers'] = $lecturers;
        $this->_template->data['appointment'] = $appointment;
        
        $this->_template->setPageTitle('Tijdsloten toevoegen');
        $this->_template->render('appointments/addtimeslots');
    }
    
    public function deletetimeslot($appointmentid = -1, $appointmentSlotid = -1){
        if(!loggedin() || userdata('accesslevel') < LECTURER || $appointmentid == -1 || $appointmentSlotid == -1)
            redirect('');
        $appointment = $this->appointmentmodel->loadAppointment($appointmentid);
        if (!$appointment['appointmentid']){
            message("Oops! We hebben een niet-bestaande appointmentid gedetecteerd!", "warning");
            $this->detail($appointmentid);
            die();
        }

        if($this->appointmentmodel->deleteTimeSlotAppointment($appointmentSlotid))
            message("Het tijdsslot werd successvol gedelete!", "success");
        $this->edit($appointmentid);
    }
}
?>
