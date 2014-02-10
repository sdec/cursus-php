<?php
if(!isset($_SESSION)) session_start();
include_once(includes_url() . 'form_helper.php');

function redirect($page){
    header("Location: " . base_url() . $page);//, 303); //301 "Moved permanently", 302 (default) "Found", 303 "Moved temporarily"
    die(); //Force ending transmission of the potentially unauthorized webpage server-side
}

function encryptPassword($password) {
    // We first uppercase the password to eliminate case
    // We then hash the password using Whirlpool (outputs 128 character hash)
    return hash('whirlpool', strtoupper($password));
}

//Database functions
function dbConnect(){ //TODO : bovenaan inladen, disconnect in footer
    $mysqli = new mysqli("localhost", "admin", "", "test");//mysqlhost, username & password
    /* check connection */
    if (mysqli_connect_errno()) {
        printf("Connect failed: %s\n", mysqli_connect_error());
        exit();
    }
    return $mysqli;
}

$MySQLDB= dbConnect();

function sql_sanitize($input){
    return mysqli_real_escape_string(MySQLDB, $input);
}

function login($username, $password){ //I.E. : "r0426942", "paswoord"
    $pwd = encryptPassword($password);
    //$link = dbConnect();
    
    $query = "SELECT * FROM users WHERE username = '$username' AND password = '$pwd'";
    $result = mysqli_query(MySQLDB, $query);
    if ($result) {
        /* fetch associative array */
        $row = mysqli_fetch_row($result);
        /*while ($row = mysqli_fetch_row($result)) {
            printf ("%s (%s)\n", $row[0], $row[1]);
            $temp = $row;
        }
        
        print_r($temp);*/   //Fetcharray functie : mysqli (bind associatieve array op kolomnaam)
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
    
    mysqli_close(MySQLDB);
}

function createUser($username, $firstname, $lastname, $password, $email){
    //$link = dbConnect();
    $password = encryptPassword($password);
    $query = "INSERT INTO users(username, firstname, lastname, password, email) VALUES
                                 ('$username', '$firstname', '$lastname', '$password', '$email')";
    mysqli_query(MySQLDB, $query);
    printf ("New Record has id %d.\n", mysqli_insert_id(MySQLDB)); //TODO : mysql_fetch_array($result);
    
    $query = "SELECT * FROM users WHERE username = '$username'";
    $result = mysqli_query(MySQLDB, $query);
    $user = $result->fetch_array(MYSQLI_ASSOC);
    unset($user['password']);
    
    /* close connection */
    //mysqli_close(MySQLDB);
    
    return $user;
    
    /*return $user = array('username' => $username,
                         'firstname' => $firstname,
                         'lastname' => $lastname,
                         'email' => $email,
                         'accesslevel' => 0,
                         'role' => "admin");*/
}

?>