<?php

class AppointmentModel extends CI_Model {
    
    public function __construct() {}
    
    public function loadall() {
        
        $sql = '
            SELECT 
                DATE_FORMAT(start_timestamp, \'%w %d-%m\') date, 
                DATE_FORMAT(start_timestamp, \'%H:%i\') start,
                DATE_FORMAT(end_timestamp, \'%H:%i\') end,
                description, 
                location
            FROM appointments
        ';
        
        $query = $this->db->query($sql);
        return $query->num_rows() > 0 ? $query->result() : FALSE;
    }
    
}