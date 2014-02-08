<?php

class AppointmentModel extends CI_Model {

    public function __construct() {
        
    }

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

    public function load($appointmentid, $userid = 0) {
        $sql = '
            SELECT 
                appointmentid,
                DATE_FORMAT(appointments.start_timestamp, \'%d-%m\') date, 
                DATE_FORMAT(appointments.start_timestamp, \'%H:%i\') start,
                DATE_FORMAT(appointments.end_timestamp, \'%H:%i\') end,
                description, 
                location,
                COUNT(DISTINCT slots.lecturerid) AS lecturercount,
		IF((
                    SELECT IF(userid IS NULL, FALSE, TRUE)
                    FROM appointmentsubscribers
                    WHERE userid = subs.userid
		) IS NULL, FALSE, TRUE) subscribed,
		(
                    SELECT CONCAT(firstname, \' \', lastname) 
                    FROM users 
                    WHERE userid = subs.userid
		) lecturer,
		(
                    SELECT DATE_FORMAT(start_timestamp, \'%H:%i\')
                    FROM appointmentslots
                    WHERE appointmentslotid = slots.appointmentslotid
		) subscribestart,
		(
                    SELECT DATE_FORMAT(end_timestamp, \'%H:%i\')
                    FROM appointmentslots
                    WHERE appointmentslotid = slots.appointmentslotid
		) subscribeend
            FROM appointments
                LEFT JOIN appointmentslots slots USING(appointmentid)
		LEFT JOIN appointmentsubscribers subs
                    ON subs.appointmentslotid = slots.appointmentslotid
                    AND subs.userid = ?
            WHERE appointmentid = ?
        ';

        $query = $this->db->query($sql, array($userid, $appointmentid));
        return $query->num_rows() > 0 ? $query->result()[0] : FALSE;
    }

    public function slots($appointmentid) {
        $sql = '
            SELECT appointmentslotid, appointmentslots.lecturerid lecturerid, lecturer.firstname, lecturer.lastname,
                DATE_FORMAT(appointmentslots.start_timestamp, \'%H:%i\') start,
                DATE_FORMAT(appointmentslots.end_timestamp, \'%H:%i\') end,
                DATE_FORMAT(appointmentslots.interval_timestamp, \'%H:%i\') `interval`,
                IF(subscribers.userid IS NULL, TRUE, FALSE) available,
                IFNULL(subscribers.userid, 0) subscriberid,
		CONCAT(susers.firstname, \' \', susers.lastname) subscriber
            FROM appointmentslots
                JOIN appointments USING(appointmentid)
                JOIN users lecturer ON appointmentslots.lecturerid = lecturer.userid
                LEFT JOIN appointmentsubscribers subscribers USING(appointmentslotid)
		LEFT JOIN users susers ON susers.userid = subscribers.userid
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

    public function subscribe($appointmentslotid) {
        $data = array(
            'appointmentslotid' => $appointmentslotid,
            'userid' => $this->session->userdata('user')->userid
        );
        $this->db->insert('appointmentsubscribers', $data);
        return $this->db->affected_rows() > 0;
    }

}