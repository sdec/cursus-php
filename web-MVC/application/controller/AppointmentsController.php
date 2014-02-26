<?php
require_once helpers_url() . 'form_helper.php';
require_once models_url() . 'AppointmentMapper.php';

class AppointmentsController extends Controller{
    private $appointmentmodel;
    
    public function __construct() {
        parent::__construct('appointments');
        $this->appointmentmodel = new Appointment_Mapper();
    }
    
    public function index(){
        if(!loggedIn())
            redirect('');
        $search = isset($_POST['search']) ? $_POST['search'] : '';
        $appointments = strlen($search) 
            ? $this->appointmentmodel->searchAppointments($search) 
            : $this->appointmentmodel->loadAllAppointments();

        global $data;
        $data['appointments'] = $appointments;
        $data['search'] = $search;
        
        $this->render("index");
    }
    
    public function detail($appointmentid = -1){
        if (!loggedin() || $appointmentid == -1)
            redirect('');
        global $data;
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
        
        $data['appointment'] = $appointment;
        $data['slots'] = $slots;
        $data['subscription'] = $subscription;
        $this->render('detail');
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
            global $appointmentid;
            $appointmentid = $appointment['appointmentid'];
            $this->render('subscribe_success');
            die();
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
            global $appointmentid;
            $appointmentid = $appointment['appointmentid'];
            $this->render('unsubscribe_success');
            die();
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
                        global $data;
                        $data['appointment'] = $appointment;
                        $this->render('create_success');
                        die();
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
        $this->render('create');
    }
    
    public function delete($appointmentid = null){
        if(!loggedin() || userdata('accesslevel') < LECTURER || !isset($appointmentid))
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
}
?>