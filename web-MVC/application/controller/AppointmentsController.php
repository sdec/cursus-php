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
            message("Oops! We have detected an nonexisting appointmentid!", "warning");
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

                if ($appointment['chronological']) {
                    if (!$slots[$i]['subscriberid'] && $availableCount == 0) {
                        $slots[$i]['available'] = TRUE;
                        $availableCount++;
                    } else if (!$slots[$i]['subscriberid'] && $availableCount == 1) {
                        $slot['available'] = FALSE;
                    }
                } else {
                    $slot['available'] = TRUE;
                }
            }
        }
        
        $data['appointment'] = $appointment;
        $data['slots'] = $slots;
        $data['subscription'] = $subscription;
        $this->render('detail');
    }
       
}
?>
