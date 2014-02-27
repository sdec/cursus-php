<?php

class Appointment_Mapper{
    private $_db;
    
    public function __construct(){
        $this->_db = Db::getInstance();
    }
    
    function loadAllAppointments($userid = null) {
        $sql = "
            SELECT 
                ap.appointmentid                                AS  appointmentid,
                DATE_FORMAT(ap.start_timestamp, '%d-%m')        AS  date, 
                DATE_FORMAT(ap.start_timestamp, '%H:%i')        AS  start,
                DATE_FORMAT(ap.end_timestamp, '%H:%i')          AS  end,
                ap.description                                  AS  description, 
                ap.location                                     AS  location
            FROM appointments ap
        ";
        if ($userid) {
            $sql .= "
                LEFT JOIN appointmentslots USING(appointmentid)
                LEFT JOIN appointmentsubscribers USING(appointmentslotid)
                WHERE userid = :userid
            ";
        }
        $sql .= "
            GROUP BY ap.appointmentid
            ORDER BY ap.start_timestamp DESC, ap.end_timestamp DESC
        ";
        $arguments = array(
            ':userid' => $userid,
        );
        $result = $this->_db->execute($sql, $arguments);
        $appointments = $result->fetchAll(PDO::FETCH_ASSOC);
        return (count($appointments) > 0) ? $appointments : FALSE;
    }

    function searchAppointments($search) {
        $search = '%'.$search.'%';  //add substring query signs
        $sql = "
            SELECT 
                ap.appointmentid                                    AS  appointmentid,
                DATE_FORMAT(ap.start_timestamp, '%d-%m')          AS  date, 
                DATE_FORMAT(ap.start_timestamp, '%H:%i')          AS  start,
                DATE_FORMAT(ap.end_timestamp, '%H:%i')            AS  end,
                ap.description                                      AS  description, 
                ap.location                                         AS  location
            FROM appointments ap
                LEFT JOIN appointmentslots aps USING(appointmentid)
                LEFT JOIN appointmentsubscribers subs USING(appointmentslotid)
                LEFT JOIN users lu ON lu.userid = aps.lecturerid
                LEFT JOIN users su ON su.userid = subs.userid

            WHERE
                ap.start_timestamp LIKE :search
                OR ap.end_timestamp LIKE :search
                OR description LIKE :search
                OR location LIKE :search
                OR lu.username LIKE :search
                OR su.username LIKE :search
                OR CONCAT(lu.firstname, ' ', lu.lastname) LIKE :search
                OR CONCAT(su.firstname, ' ', su.lastname) LIKE :search

            GROUP BY ap.appointmentid
            ORDER BY ap.start_timestamp DESC, ap.end_timestamp DESC
        ";
        $arguments = array(
            ':search' => $search,
        );
        $result = $this->_db->execute($sql, $arguments);
        $appointments = $result->fetchAll(PDO::FETCH_ASSOC);
        return (count($appointments) > 0) ? $appointments : FALSE;
    }

    function createAppointment($start_timestamp, $end_timestamp, $description, $location, $chronological) {
        $sql = "
            INSERT INTO appointments (start_timestamp, end_timestamp, description, location, chronological) 
            VALUES (:start_timestamp, :end_timestamp, :description, :location, :chronological);
        ";
        $arguments = array(
            ':start_timestamp' => $start_timestamp,
            ':end_timestamp' => $end_timestamp,
            ':description' => $description,
            ':location' => $location,
            ':chronological' => $chronological,
        );
        $result = $this->_db->execute($sql, $arguments);
        return getLastInsertId();
    }

    function editAppointment($appointmentid, $start_timestamp, $end_timestamp, $description, $location, $chronological) {
        $sql = "
            UPDATE appointments 
            SET start_timestamp = :start_timestamp,
                end_timestamp = :end_timestamp, 
                description = :description,
                location = :location,
                chronological = :location
            WHERE appointmentid = :appointmentid;
        ";
        $arguments = array(
            ':appointmentid' => $appointmentid,
            ':start_timestamp' => $start_timestamp,
            ':end_timestamp' => $end_timestamp,
            ':description' => $description,
            ':location' => $location,
            ':chronological' => $chronological,
        );
        $result = $this->_db->execute($sql, $arguments);
        return $result->rowCount() > 0;
    }

    function loadAppointment($appointmentid) {
        $sql = "
            SELECT 
                ap.appointmentid                    AS	appointmentid,
                ap.description                      AS	description,
                ap.location                         AS	location,
                ap.chronological                    AS	chronological,
                ap.start_timestamp                  AS	start_timestamp,
                ap.end_timestamp                    AS	end_timestamp,
                COUNT(DISTINCT aps.lecturerid)      AS	lecturercount

            FROM appointments ap
                LEFT JOIN appointmentslots aps USING(appointmentid)

            WHERE appointmentid = :appointmentid
            ORDER BY start_timestamp DESC, end_timestamp DESC
        ";
        $arguments = array(
            ':appointmentid' => $appointmentid,
        );
        $result = $this->_db->execute($sql, $arguments);
        return $result->rowCount() > 0 ? $result->fetch(PDO::FETCH_ASSOC) : FALSE;
    }

    function slots($appointmentid) {
        $sql = "
            SELECT 
                aps.appointmentslotid                       AS appointmentslotid,
                aps.lecturerid                              AS lecturerid,
                CONCAT(lu.firstname, ' ', lu.lastname)    AS lecturer,
                DATE_FORMAT(aps.start_timestamp, '%H:%i') AS start,
                DATE_FORMAT(aps.end_timestamp, '%H:%i')   AS end,
                subs.userid                                 AS subscriberid,
                CONCAT(su.firstname, ' ', su.lastname)    AS subscriber

            FROM appointmentslots aps
                LEFT JOIN users lu ON aps.lecturerid = lu.userid
                LEFT JOIN appointmentsubscribers subs ON aps.appointmentslotid = subs.appointmentslotid
                LEFT JOIN users su ON subs.userid = su.userid

            WHERE appointmentid = :appointmentid
            ORDER BY start_timestamp ASC, end_timestamp ASC, lecturer DESC
        ";
        $arguments = array(
            ':appointmentid' => $appointmentid,
        );
        $result = $this->_db->execute($sql, $arguments);
        $slots = $result->fetchAll(PDO::FETCH_ASSOC);
        return count($slots) > 0 ? $slots : FALSE;
    }

    function deleteAppointment($appointmentid) {
        $sql = "
            DELETE FROM appointments
            WHERE appointmentid = :appointmentid;
        ";
        $arguments = array(
            ':appointmentid' => $appointmentid,
        );
        $result = $this->_db->execute($sql, $arguments);
        return $result->rowCount() > 0;
    }

    function subscribeAppointment($appointmentslotid, $userid) {
        $sql = "
            INSERT INTO appointmentsubscribers (appointmentslotid, userid)
            VALUES(:appointmentslotid, :userid);
        ";
        $arguments = array(
            ':appointmentslotid' => $appointmentslotid,
            ':userid' => $userid,
        );
        $result = $this->_db->execute($sql, $arguments);
        return $result->rowCount() > 0;
    }

    function unSubscribeAppointment($appointmentslotid, $userid) {
        $sql = "
            DELETE FROM appointmentsubscribers
            WHERE appointmentslotid = :appointmentslotid 
                AND userid = :userid;
        ";
        $arguments = array(
            ':appointmentslotid' => $appointmentslotid,
            ':userid' => $userid,
        );
        $result = $this->_db->execute($sql, $arguments);
        return $result->rowCount() > 0;
    }

    function addTimeSlotsAppointment($appointmentid, $lecturerid, $start_timestamp, $end_timestamp, $interval_timestamp) {
        $sql = "INSERT INTO appointmentslots (appointmentid, lecturerid, start_timestamp, end_timestamp) VALUES ";
        $arguments = array(
            ':appointmentid' => $appointmentid,
            ':lecturerid' => $lecturerid,
            ':start_timestamp' => $start_timestamp,
        );
        $batchData = array();

        $counter = 0;
        while (strtotime($start_timestamp) < strtotime($end_timestamp)) {
            $counter += 1;
            
            $diff = strtotime($start_timestamp) + (strtotime(date('Y-m-d H:i:s', strtotime($interval_timestamp))) - strtotime(date('Y-m-d', strtotime($interval_timestamp))));
            $slotEnd = date('Y-m-d H:i:s', $diff);
            
            array_push($batchData, "(:appointmentid, :lecturerid, :start".$counter.", :slotEnd".$counter.")");
            $arguments[(':slotEnd'.$counter)] = $slotEnd;
            $arguments[(':start'.$counter)] = $start_timestamp;
            
            $start_timestamp = $slotEnd;
        }

        $sql .= implode(',', $batchData) . ';';
        
        $result = $this->_db->execute($sql, $arguments);
        return $result->rowCount() > 0;
    }

    function deleteTimeSlotAppointment($appointmentslotid) {
        $sql = "
            DELETE FROM appointmentslots
            WHERE appointmentslotid = :appointmentslotid;
        ";
        $arguments = array(
            ':appointmentslotid' => $appointmentslotid,
        );
        $result = $this->_db->execute($sql, $arguments);
        return $result->rowCount() > 0;
    }
}