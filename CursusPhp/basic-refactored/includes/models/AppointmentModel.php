<?php

function loadAllAppointments() {
    $sql = '
        SELECT 
            ap.appointmentid                                AS  appointmentid,
            DATE_FORMAT(ap.start_timestamp, \'%d-%m\')      AS  date, 
            DATE_FORMAT(ap.start_timestamp, \'%H:%i\')      AS  start,
            DATE_FORMAT(ap.end_timestamp, \'%H:%i\')        AS  end,
            ap.description                                  AS  description, 
            ap.location                                     AS  location
        FROM appointments ap

        GROUP BY ap.appointmentid
        ORDER BY ap.start_timestamp DESC, ap.end_timestamp DESC
    ';
    
    $result = mysqli_query(DB_Link(), $sql);
    $appointments = array();
    while ($appointment = mysqli_fetch_assoc($result)) {
        array_push($appointments, $appointment);
    }
    return (count($appointments) > 0) ? $appointments : FALSE;
}

function searchAppointments($search) {

    $search = sanitize($search);

    $sql = 'SELECT 
            ap.appointmentid                                    AS  appointmentid,
            DATE_FORMAT(ap.start_timestamp, \'%d-%m\')          AS  date, 
            DATE_FORMAT(ap.start_timestamp, \'%H:%i\')          AS  start,
            DATE_FORMAT(ap.end_timestamp, \'%H:%i\')            AS  end,
            ap.description                                      AS  description, 
            ap.location                                         AS  location
        FROM appointments ap
            LEFT JOIN appointmentslots aps USING(appointmentid)
            LEFT JOIN appointmentsubscribers subs USING(appointmentslotid)
            LEFT JOIN users lu ON lu.userid = aps.lecturerid
            LEFT JOIN users su ON su.userid = subs.userid

        WHERE
            ap.start_timestamp LIKE \'%'.$search . '%\'
            OR ap.end_timestamp LIKE \'%'.$search.'%\'
            OR description LIKE \'%'.$search.'%\'
            OR location LIKE \'%'.$search.'%\'
            OR lu.username LIKE \'%'.$search.'%\'
            OR su.username LIKE \'%'.$search.'%\'
            OR CONCAT(lu.firstname, \' \', lu.lastname) LIKE \'%'.$search.'%\'
            OR CONCAT(su.firstname, \' \', su.lastname) LIKE \'%'.$search.'%\'

        GROUP BY ap.appointmentid
        ORDER BY ap.start_timestamp DESC, ap.end_timestamp DESC
    ';

    $result = mysqli_query(DB_Link(), $sql);
    $appointments = array();
    while ($appointment = mysqli_fetch_assoc($result)) {
        array_push($appointments, $appointment);
    }
    return (count($appointments) > 0) ? $appointments : FALSE;
}

function createAppointment($start_timestamp, $end_timestamp, $description, $location, $chronological) {
    $arr = sanitize(array($start_timestamp, $end_timestamp, $description, $location, $chronological));
    $start_timestamp = $arr[0];
    $end_timestamp = $arr[1];
    $description = $arr[2];
    $location = $arr[3];
    $chronological = $arr[4];

    $query = "INSERT INTO appointments(start_timestamp, end_timestamp, description, location, chronological) VALUES
             ('$start_timestamp', '$end_timestamp', '$description', '$location', '$chronological')";
    $link = DB_Link();
    mysqli_query($link, $query);

    return mysqli_insert_id($link);
}

function editAppointment($appointmentid, $start_timestamp, $end_timestamp, $description, $location, $chronological) {
    $data = array(
        'start_timestamp' => $start_timestamp,
        'end_timestamp' => $end_timestamp,
        'description' => $description,
        'location' => $location,
        'chronological' => $chronological
    );
    $this->db->where('appointmentid', $appointmentid);
    $this->db->update('appointments', $data);
    return $this->db->affected_rows() > 0;
}

function loadAppointment($appointmentid) {
    $sql = '
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
                
            WHERE appointmentid = \'' . sanitize($appointmentid) . '\'
            ORDER BY start_timestamp DESC, end_timestamp DESC
        ';

    $result = mysqli_query(DB_Link(), $sql);
    return mysqli_num_rows($result) > 0 ? mysqli_fetch_assoc($result) : FALSE;
}

function slots($appointmentid) {
    $sql = '
            SELECT 
                aps.appointmentslotid                       AS appointmentslotid,
                aps.lecturerid                              AS lecturerid,
                CONCAT(lu.firstname, \' \', lu.lastname)    AS lecturer,
                DATE_FORMAT(aps.start_timestamp, \'%H:%i\') AS start,
                DATE_FORMAT(aps.end_timestamp, \'%H:%i\')   AS end,
                subs.userid                                 AS subscriberid,
                CONCAT(su.firstname, \' \', su.lastname)    AS subscriber

            FROM appointmentslots aps
                    LEFT JOIN users lu ON aps.lecturerid = lu.userid
                    LEFT JOIN appointmentsubscribers subs ON aps.appointmentslotid = subs.appointmentslotid
                    LEFT JOIN users su ON subs.userid = su.userid
                    
            WHERE appointmentid = \'' . sanitize($appointmentid) . '\'
            ORDER BY start_timestamp ASC, end_timestamp ASC, lecturer DESC
        ';

    $result = mysqli_query(DB_Link(), $sql);
    $slots = array();
    while ($slot = mysqli_fetch_assoc($result)) {
        array_push($slots, $slot);
    }
    return count($slots) > 0 ? $slots : FALSE;
}

function deleteAppointment($appointmentid) {
    $appointmentid = sanitize($appointmentid);
    $query = "
            DELETE FROM appointments
            WHERE appointmentid = '$appointmentid'";
    $link = DB_Link();
    mysqli_query($link, $query);
    return mysqli_affected_rows($link) > 0;
}

function subscribeAppointment($appointmentslotid, $userid) {
    $data = array(
        'appointmentslotid' => $appointmentslotid,
        'userid' => $userid
    );
    $this->db->insert('appointmentsubscribers', $data);
    return $this->db->affected_rows() > 0;
}

function unSubscribeAppointment($appointmentslotid, $userid) {
    $data = array(
        'appointmentslotid' => $appointmentslotid,
        'userid' => $userid
    );
    $this->db->delete('appointmentsubscribers', $data);
    return $this->db->affected_rows() > 0;
}

function addTimeSlotsAppointment($appointmentid, $lecturerid, $start_timestamp, $end_timestamp, $interval_timestamp) {

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

function deleteTimeSlotAppointment($appointmentslotid) {
    $this->db->delete('appointmentslots', array('appointmentslotid' => $appointmentslotid));
    return $this->db->affected_rows() > 0;
}
