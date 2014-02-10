<?php

class AppointmentModel extends CI_Model {

    public function loadall() {

        $sql = '
            SELECT 
                appointmentid,
                DATE_FORMAT(ap.start_timestamp, \'%d-%m\') date, 
                DATE_FORMAT(ap.start_timestamp, \'%H:%i\') start,
                DATE_FORMAT(ap.end_timestamp, \'%H:%i\') end,
                description, 
                location
            FROM appointments ap
            ORDER BY ap.start_timestamp DESC, ap.end_timestamp DESC
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
                ap.appointmentid                    AS	appointmentid,
                ap.description                      AS	description,
                ap.location                         AS	location,
                ap.start_timestamp                  AS	start_timestamp,
                ap.end_timestamp                    AS	end_timestamp,
                COUNT(DISTINCT aps.lecturerid)      AS	lecturercount

            FROM appointments ap
                LEFT JOIN appointmentslots aps USING(appointmentid)
                
            WHERE appointmentid = ?
            ORDER BY start_timestamp DESC, end_timestamp DESC
        ';

        $query = $this->db->query($sql, array($appointmentid));
        return $query->num_rows() > 0 ? $query->result()[0] : FALSE;
    }

    public function slots($appointmentid) {
        $sql = '
            SELECT 
                aps.appointmentslotid                       AS appointmentslotid,
                aps.lecturerid                              AS lecturerid,
                CONCAT(lu.firstname, \' \', lu.lastname)    AS lecturer,
                DATE_FORMAT(aps.start_timestamp, \'%H:%i\') AS	start,
                DATE_FORMAT(aps.end_timestamp, \'%H:%i\')   AS	end,
                subs.userid                                 AS subscriberid,
                CONCAT(su.firstname, \' \', su.lastname)    AS subscriber

            FROM appointmentslots aps
                    LEFT JOIN users lu ON aps.lecturerid = lu.userid
                    LEFT JOIN appointmentsubscribers subs ON aps.appointmentslotid = subs.appointmentslotid
                    LEFT JOIN users su ON subs.userid = su.userid
                    
            WHERE appointmentid = ?
            ORDER BY start_timestamp ASC, end_timestamp ASC, lecturer DESC
        ';

        $query = $this->db->query($sql, array($appointmentid));
        return $query->num_rows() > 0 ? $query->result() : FALSE;
    }

    public function delete($appointmentid) {
        $data = array('appointmentid' => $appointmentid);
        $this->db->delete('appointments', $data);
        return $this->db->affected_rows() > 0;
    }

    public function subscribe($appointmentslotid, $userid) {
        $data = array(
            'appointmentslotid' => $appointmentslotid,
            'userid' => $userid
        );
        $this->db->insert('appointmentsubscribers', $data);
        return $this->db->affected_rows() > 0;
    }

    public function unsubscribe($appointmentslotid, $userid) {
        $data = array(
            'appointmentslotid' => $appointmentslotid,
            'userid' => $userid
        );
        $this->db->delete('appointmentsubscribers', $data);
        return $this->db->affected_rows() > 0;
    }

    public function addlecturer($appointmentid, $lecturerid, $start_timestamp, $end_timestamp, $interval_timestamp) {

        $batchData = array();

        while (strtotime($start_timestamp) < strtotime($end_timestamp)) {

            $diff = strtotime($start_timestamp) + (strtotime(date('Y-m-d H:i:s', strtotime($interval_timestamp))) - strtotime(date('Y-m-d', strtotime($interval_timestamp))));
            $slotEnd = date('Y-m-d H:i:s', $diff);

            array_push($batchData, array(
                'appointmentid' => $appointmentid,
                'lecturerid' => $lecturerid,
                'start_timestamp' => $start_timestamp,
                'end_timestamp' => $slotEnd
            ));

            $start_timestamp = $slotEnd;
        }

        $this->db->insert_batch('appointmentslots', $batchData);
        return $this->db->affected_rows() > 0;
    }

}