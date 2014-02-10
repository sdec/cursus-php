<?php
if(!isset($_SESSION)) session_start();

function encryptPassword($password) {
    // We first uppercase the password to eliminate case
    // We then hash the password using Whirlpool (outputs 128 character hash)
    return hash('whirlpool', strtoupper($password));
}

//Database functions
function dbConnect(){
    $mysqli = new mysqli("localhost", "admin", "", "test");//mysqlhost, username & password
    /* check connection */
    if (mysqli_connect_errno()) {
        printf("Connect failed: %s\n", mysqli_connect_error());
        exit();
    }
    return $mysqli;
}

function login($username, $password){ //I.E. : "r0426942", "paswoord"
    $pwd = encryptPassword($password);
    $link = dbConnect();
    
    $query = "SELECT * FROM users WHERE username = '$username' AND password = '$pwd'";
    $result = mysqli_query($link, $query);
    if ($result) {
        echo("result found");
        /* fetch associative array */
        $row = mysqli_fetch_row($result);
        /*while ($row = mysqli_fetch_row($result)) {
            printf ("%s (%s)\n", $row[0], $row[1]);
            $temp = $row;
        }
        
        print_r($temp);*/
        $user = array('userid' => $row[0],
                      'username' => $row[1],
                      'firstname' => $row[2],
                      'lastname' => $row[3],
                      'email' => $row[5],
                      'accesslevel' => $row[6],
                      'role' => "admin");
        /* free result set */
        mysqli_free_result($result);
        return $user;
    }
    
    mysqli_close($link);
}

function createUser($username, $firstname, $lastname, $password, $email){
    $link = dbConnect();
    $password = encryptPassword($password);
    $query = "INSERT INTO users(username, firstname, lastname, password, email) VALUES
                                 ('$username', '$firstname', '$lastname', '$password', '$email')";
    mysqli_query($link, $query);

    printf ("New Record has id %d.\n", mysqli_insert_id($link));
    /* close connection */
    mysqli_close($link);
    
    return $user = array('username' => $username,
                         'firstname' => $firstname,
                         'lastname' => $lastname,
                         'email' => $email,
                         'accesslevel' => 0,
                         'role' => "admin");
}

?>