<?php

class AppointmentModel extends CI_Model {
    
    public function __construct() {}
    
    public function loadall() {
        
        $sql = '
            SELECT 
                appointmentid,
                DATE_FORMAT(start_timestamp, \'%d-%m\') date, 
                DATE_FORMAT(start_timestamp, \'%H:%i\') start,
                DATE_FORMAT(end_timestamp, \'%H:%i\') end,
                description, 
                location
            FROM appointments
        ';
        
        $query = $this->db->query($sql);
        return $query->num_rows() > 0 ? $query->result() : FALSE;
    }
    
    public function create($start_timestamp, $end_timestamp, $description, $location) {
        $data = array(
            'start_timestamp' => $start_timestamp,
            'end_timestamp' => $end_timestamp,
            'description' => $description,
            'location' => $location
        );
        $this->db->insert('appointments', $data);
        return $this->db->affected_rows() > 0;
    }
    
    public function load($appointmentid) {
        $sql = '
            SELECT 
                appointmentid,
                DATE_FORMAT(start_timestamp, \'%d-%m\') date, 
                DATE_FORMAT(start_timestamp, \'%H:%i\') start,
                DATE_FORMAT(end_timestamp, \'%H:%i\') end,
                description, 
                location
            FROM appointments
            WHERE appointmentid = ?
        ';
        
        $query = $this->db->query($sql, array($appointmentid));
        return $query->num_rows() > 0 ? $query->result()[0] : FALSE;
    }
    
    public function lecturers($appointmentid) {
        $sql = '
            SELECT appointmentlecturers.lecturerid lecturerid, firstname, lastname,
                DATE_FORMAT(appointmentlecturers.start_timestamp, \'%H:%i\') start,
                DATE_FORMAT(appointmentlecturers.end_timestamp, \'%H:%i\') end,
                DATE_FORMAT(appointmentlecturers.interval_timestamp, \'%H:%i\') `interval`
            FROM appointmentlecturers
                JOIN appointments USING(appointmentid)
                JOIN users ON appointmentlecturers.lecturerid = users.userid
            WHERE appointmentid = ?;
        ';
        
        $query = $this->db->query($sql, array($appointmentid));
        return $query->num_rows() > 0 ? $query->result() : FALSE;
    }
    
    public function delete($appointmentid) {
        $data = array('appointmentid' => $appointmentid);
        $this->db->delete('appointments', $data);
        return $this->db->affected_rows() > 0;
    }
    
}