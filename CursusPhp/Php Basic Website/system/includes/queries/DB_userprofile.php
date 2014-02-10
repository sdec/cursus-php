<?php
include_once(includes_url() . 'database.php');

function encryptPassword($password) {
    // We first uppercase the password to eliminate case
    // We then hash the password using Whirlpool (outputs 128 character hash)
    return hash('whirlpool', strtoupper($password));
}

function login($username, $password){ //I.E. : "r0426942", "paswoord"
    $link = DB_Link();
    $username = sql_sanitize($username);
    $password = sql_sanitize($password);
    $pwd = encryptPassword($password);
    $query = "SELECT * FROM users WHERE username = '$username' AND password = '$pwd'";
    $result = mysqli_query($link, $query);
    if ($result) {
        /* fetch associative array */
        $row = mysqli_fetch_row($result);
        $result = mysqli_query($link, $query);
        $user = $result->fetch_array(MYSQLI_ASSOC);
        unset($user['password']);
        
        /* free result set */
        mysqli_free_result($result);
        return $user;
    }
}

function createUser($username, $firstname, $lastname, $password, $email){
    $link = DB_Link();
    
    $arr = sql_sanitize(array($username, $firstname, $lastname, $password, $email));
    $username = $arr[0]; $firstname = $arr[1]; $lastname = $arr[2]; $password = $arr[3]; $email = $arr[4];
    $password = encryptPassword($password);
    
    $query = "INSERT INTO users(username, firstname, lastname, password, email) VALUES
                                 ('$username', '$firstname', '$lastname', '$password', '$email')";
    mysqli_query($link, $query);
    printf ("New Record has id %d.\n", mysqli_insert_id($link));
    
    $query = "SELECT * FROM users WHERE username = '$username'";
    $result = mysqli_query($link, $query);
    $user = $result->fetch_array(MYSQLI_ASSOC);
    unset($user['password']);
    return $user;
}
?>
