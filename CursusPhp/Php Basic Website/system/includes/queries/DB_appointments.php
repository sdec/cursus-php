<?php
include_once(includes_url() . 'database.php');

function create($start_timestamp, $end_timestamp, $description, $location, $chronological) {
    $arr = sql_sanitize(array($start_timestamp, $end_timestamp, $description, $location, $chronological));
    $start_timestamp = $arr[0]; $end_timestamp = $arr[1]; $description = $arr[2]; $location = $arr[3]; $chronological = $arr[4];
    $query = "INSERT INTO appointments(start_timestamp, end_timestamp, description, location, chronological) VALUES
             ('$start_timestamp', '$end_timestamp', '$description', '$location', '$chronological')";
    $link = DB_Link();
    mysqli_query($link, $query);
    printf ("New appointment has id %d.\n", mysqli_insert_id($link));
    return mysqli_insert_id($link);
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
}

function createUser($username, $firstname, $lastname, $password, $email){
    $link = DB_Link();
    
    $arr = sql_sanitize(array($username, $firstname, $lastname, $password, $email));
    $username = $arr[0]; $firstname = $arr[1]; $lastname = $arr[2]; $password = $arr[3]; $email = $arr[4];
    $password = encryptPassword($password);
    if(userExists($username)){
        return 0;
        exit();
    }
    $query = "INSERT INTO users(username, firstname, lastname, password, email) VALUES
                                 ('$username', '$firstname', '$lastname', '$password', '$email')";
    mysqli_query($link, $query);
    printf ("New Record has id %d.\n", mysqli_insert_id($link));
    
    $user = userExists($username);
    unset($user['password']);
    return $user;
}*/
?>
