<?php

function loadAllAppointments() {
    $sql = "
        SELECT 
            ap.appointmentid                                AS  appointmentid,
            DATE_FORMAT(ap.start_timestamp, '%d-%m')        AS  date, 
            DATE_FORMAT(ap.start_timestamp, '%H:%i')        AS  start,
            DATE_FORMAT(ap.end_timestamp, '%H:%i')          AS  end,
            ap.description                                  AS  description, 
            ap.location                                     AS  location
        FROM appointments ap

        GROUP BY ap.appointmentid
        ORDER BY ap.start_timestamp DESC, ap.end_timestamp DESC
    ";

    $result = mysqli_query(DB_Link(), $sql);
    $appointments = array();
    while ($appointment = mysqli_fetch_assoc($result)) {
        array_push($appointments, $appointment);
    }
    return (count($appointments) > 0) ? $appointments : FALSE;
}

function searchAppointments($search) {

    $search = sanitize($search);

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
            ap.start_timestamp LIKE '%" . $search . "%'
            OR ap.end_timestamp LIKE '%" . $search . "%'
            OR description LIKE '%" . $search . "%'
            OR location LIKE '%" . $search . "%'
            OR lu.username LIKE '%" . $search . "%'
            OR su.username LIKE '%" . $search . "%'
            OR CONCAT(lu.firstname, ' ', lu.lastname) LIKE '%" . $search . "%'
            OR CONCAT(su.firstname, ' ', su.lastname) LIKE '%" . $search . "%'

        GROUP BY ap.appointmentid
        ORDER BY ap.start_timestamp DESC, ap.end_timestamp DESC
    ";

    $result = mysqli_query(DB_Link(), $sql);
    $appointments = array();
    while ($appointment = mysqli_fetch_assoc($result)) {
        array_push($appointments, $appointment);
    }
    return (count($appointments) > 0) ? $appointments : FALSE;
}

function createAppointment($start_timestamp, $end_timestamp, $description, $location, $chronological) {
    $sql = "
        INSERT INTO appointments (start_timestamp, end_timestamp, description, location, chronological) 
        VALUES ('" . sanitize($start_timestamp) . "', '" . sanitize($end_timestamp) . "', '" . sanitize($description) . "', 
            '" . sanitize($location) . "', '" . sanitize($chronological) . "');
    ";
    mysqli_query(DB_Link(), $sql);
    return mysqli_insert_id(DB_Link());
}

function editAppointment($appointmentid, $start_timestamp, $end_timestamp, $description, $location, $chronological) {

    $sql = "
        UPDATE appointments 
        SET start_timestamp = '" . sanitize($start_timestamp) . "', end_timestamp = '" . sanitize($end_timestamp) . "', 
            description = '" . sanitize($description) . "', location = '" . sanitize($location) . "', 
                chronological = '" . sanitize($chronological) . "'
        WHERE appointmentid = '" . $appointmentid . "';
    ";

    mysqli_query(DB_Link(), $sql);
    return mysqli_affected_rows(DB_Link()) > 0;
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
    $sql = "
        DELETE FROM appointments
        WHERE appointmentid = '".sanitize($appointmentid)."';
    ";
    mysqli_query(DB_Link(), $sql);
    return mysqli_affected_rows(DB_Link()) > 0;
}

function subscribeAppointment($appointmentslotid, $userid) {
    $sql = "
        INSERT INTO appointmentsubscribers (appointmentslotid, userid)
        VALUES('".sanitize($appointmentslotid)."', '".  sanitize($userid)."');
    ";
    mysqli_query(DB_Link(), $sql);
    return mysqli_affected_rows(DB_Link()) > 0;
}

function unSubscribeAppointment($appointmentslotid, $userid) {
    $sql = "
        DELETE FROM appointmentsubscribers
        WHERE appointmentslotid = '".sanitize($appointmentslotid)."' 
            AND userid = '".  sanitize($userid)."';
    ";
    mysqli_query(DB_Link(), $sql);
    return mysqli_affected_rows(DB_Link()) > 0;
}

function addTimeSlotsAppointment($appointmentid, $lecturerid, $start_timestamp, $end_timestamp, $interval_timestamp) {

    $sql = "INSERT INTO appointmentslots (appointmentid, lecturerid, start_timestamp, end_timestamp) VALUES ";
    $batchData = array();
    
    while (strtotime($start_timestamp) < strtotime($end_timestamp)) {

        $diff = strtotime($start_timestamp) + (strtotime(date('Y-m-d H:i:s', strtotime($interval_timestamp))) - strtotime(date('Y-m-d', strtotime($interval_timestamp))));
        $slotEnd = date('Y-m-d H:i:s', $diff);

        array_push($batchData, "('".$appointmentid."', '".$lecturerid."', '".$start_timestamp."', '".$slotEnd."')");
        
        $start_timestamp = $slotEnd;
    }
    
    $sql .= implode(',', $batchData) . ';';

    mysqli_query(DB_Link(), $sql);
    return mysqli_affected_rows(DB_Link()) > 0;
}

function deleteTimeSlotAppointment($appointmentslotid) {
    $sql = "
        DELETE FROM appointmentslots
        WHERE appointmentslotid = '".sanitize($appointmentslotid)."';
    ";
    mysqli_query(DB_Link(), $sql);
    return mysqli_affected_rows(DB_Link()) > 0;
}
