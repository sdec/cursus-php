<?php
include_once(includes_url() . 'database.php');

function createAppointment($start_timestamp, $end_timestamp, $description, $location, $chronological) {
    $arr = sql_sanitize(array($start_timestamp, $end_timestamp, $description, $location, $chronological));
    $start_timestamp = $arr[0]; $end_timestamp = $arr[1]; $description = $arr[2]; $location = $arr[3]; $chronological = $arr[4];
    
    $query = "INSERT INTO appointments(start_timestamp, end_timestamp, description, location, chronological) VALUES
             ('$start_timestamp', '$end_timestamp', '$description', '$location', '$chronological')";
    $link = DB_Link();
    mysqli_query($link, $query);
    
    //printf ("New appointment has id %d.\n", mysqli_insert_id($link));
    return mysqli_insert_id($link);
}

function loadAllAppointments() {
    $appointments = array();

    $query = "SELECT 
                  ap.appointmentid                                AS  appointmentid,
                  DATE_FORMAT(ap.start_timestamp, '%d-%m')      AS  date, 
                  DATE_FORMAT(ap.start_timestamp, '%H:%i')      AS  start,
                  DATE_FORMAT(ap.end_timestamp, '%H:%i')        AS  end,
                  ap.description                                  AS  description, 
                  ap.location                                     AS  location
              FROM appointments ap

              GROUP BY ap.appointmentid
              ORDER BY ap.start_timestamp DESC, ap.end_timestamp DESC";
    $link = DB_Link();
    $stmt = mysqli_prepare($link, $query);
    if($stmt){
        $result = mysqli_query($link, $query);
        while($row = $result->fetch_array(MYSQLI_ASSOC)){
            $appointments[] = $row;
        }
    }
    return (count($appointments) > 0) ? $appointments : FALSE;
}

function searchAppointments($searchArg) {
    $searchArg = sql_sanitize($searchArg);
$sql = "SELECT 
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
            ap.start_timestamp LIKE \'%'.$searchArg.'%\'
            OR ap.end_timestamp LIKE \'%'.$searchArg.'%\'
            OR description LIKE \'%'.$searchArg.'%\'
            OR location LIKE \'%'.$searchArg.'%\'
            OR lu.username LIKE \'%'.$searchArg.'%\'
            OR su.username LIKE \'%'.$searchArg.'%\'
            OR CONCAT(lu.firstname, \' \', lu.lastname) LIKE \'%'.$searchArg.'%\'
            OR CONCAT(su.firstname, \' \', su.lastname) LIKE \'%'.$searchArg.'%\'

        GROUP BY ap.appointmentid
        ORDER BY ap.start_timestamp DESC, ap.end_timestamp DESC";
    $link = DB_Link();
    $stmt = mysqli_prepare($link, $query);
    if($stmt){
        $result = mysqli_query($link, $query);
        while($row = $result->fetch_array(MYSQLI_ASSOC)){
            $appointments[] = $row;
        }
    }
    return (count($appointments) > 0) ? $appointments : FALSE;
}
/*function userExists($username, $encryptedPwd = 0){
    $link = DB_Link();
    $query = "SELECT * FROM users WHERE username = '$username' AND password = '$encryptedPwd'";
    if($encryptedPwd == 0){//Indien we enkel willen checken of een gebruikersnaam al bestaat
        $query = "SELECT * FROM users WHERE username = '$username'";
    }
    return mysqli_query($link, $query)->fetch_array(MYSQLI_ASSOC);
}

function login($username, $password){ //I.E. : "r0426942", "paswoord"
    $link = DB_Link();
    $username = sql_sanitize($username);
    $password = sql_sanitize($password);
    $pwd = encryptPassword($password);
    $user = userExists($username);
    if ($user) {
        unset($user['password']);
        // free result set
        //mysqli_free_result($result);
        return $user;
    } else {
        return 0;
    }
}*/
?>
