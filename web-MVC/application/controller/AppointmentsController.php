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
}
?>
