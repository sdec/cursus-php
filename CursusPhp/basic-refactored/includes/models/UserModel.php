<?php
define('STUDENT', 0);
define('LECTURER', 1);
define('ADVISOR', 2);
define('ADMIN', 3);

$accessLevels = array(
    'Student',
    'Lector',
    'Studieadviseur',
    'Beheerder'
);

function encryptPassword($password) {
    // We first uppercase the password to eliminate case
    // We then hash the password using Whirlpool (outputs 128 character hash)
    return hash('whirlpool', strtoupper($password));
}

function isCorrectCredentialsUser($username, $password) {

    $hashedPassword = encryptPassword($password);

    $sql = '
        SELECT *
        FROM users
        WHERE username = \''.  sanitize($username).'\' AND password = \''.  $hashedPassword .'\'
    ';
    $result = mysqli_query(DB_Link(), $sql);
    return mysqli_num_rows($result) > 0;
}

function registerUser($username, $firstname, $lastname, $password, $email) {

    $hashedPassword = encryptPassword($password);

    $sql = '
        INSERT INTO users (username, firstname, lastname, password, email) 
        VALUES (\''.  sanitize($username).'\', \''.  sanitize($firstname).'\', \''.  sanitize($lastname).'\', 
            \''.  sanitize($hashedPassword).'\', \''.  sanitize($email).'\');
    ';
    mysqli_query(DB_Link(), $sql);
    return mysqli_affected_rows(DB_Link());
}

function loadUser($username) {
    $sql = '
        SELECT *
        FROM users
        WHERE username = \''.  sanitize($username).'\'
    ';
    $result = mysqli_query(DB_Link(), $sql);
    return mysqli_num_rows($result) > 0 ? mysqli_fetch_assoc($result) : FALSE;
}

function usernameExists($username) {
    $sql = '
        SELECT *
        FROM users
        WHERE username LIKE \''.  sanitize($username).'\'
    ';
    $result = mysqli_query(DB_Link(), $sql);
    return mysqli_num_rows($result) > 0;
}

function accessLevelName($accessLevel) {
    global $accessLevels;
    return isset($accessLevels[$accessLevel]) ? $accessLevels[$accessLevel] : $accessLevels[0];
}

function lecturers() {
    $sql = "
        SELECT *
        FROM lecturers
    ";
    $result = mysqli_query(DB_Link(), $sql);
    $lecturers = array();
    while ($lecturer = mysqli_fetch_assoc($result)) {
        array_push($lecturers, $lecturer);
    }
    return (count($lecturers) > 0) ? $lecturers : FALSE;
}

function students() {
    $sql = "
        SELECT *
        FROM students";
    $result = mysqli_query(DB_Link(), $sql);
    $students = array();
    while ($student = mysqli_fetch_assoc($result)) {
        array_push($students, $student);
    }
    return (count($students) > 0) ? $students : FALSE;
}

function searchStudents($search) {
    $search = sanitize($search);

    $sql = "
        SELECT *
        FROM students
        WHERE
            username LIKE '%$search%'
            OR firstname LIKE '%$search%'
            OR lastname LIKE '%$search%'
            OR email LIKE '%$search%'
            OR CONCAT(firstname, ' ', lastname) LIKE '%$search%'

        GROUP BY username";

    $result = mysqli_query(DB_Link(), $sql);
    $students = array();
    while ($student = mysqli_fetch_assoc($result)) {
        array_push($students, $student);
    }
    return (count($students) > 0) ? $students : FALSE;
}

function loadAllUsers() {
    $sql = "
        SELECT *
        FROM users";
    $result = mysqli_query(DB_Link(), $sql);
    $users = array();
    while ($user = mysqli_fetch_assoc($result)) {
        array_push($users, $user);
    }
    return (count($users) > 0) ? $users : FALSE;
}

function searchUsers($search) {
    $search = sanitize($search);

    $sql = "
        SELECT *
        FROM users
        WHERE
            username LIKE '%$search%'
            OR firstname LIKE '%$search%'
            OR lastname LIKE '%$search%'
            OR email LIKE '%$search%'
            OR CONCAT(firstname, ' ', lastname) LIKE '%$search%'

        GROUP BY username";

    $result = mysqli_query(DB_Link(), $sql);
    $users = array();
    while ($user = mysqli_fetch_assoc($result)) {
        array_push($users, $user);
    }
    return (count($users) > 0) ? $users : FALSE;
}

function deleteUser($userid){
    $userid = sanitize($userid);
    $sql = "
        DELETE FROM users
        WHERE userid = '".$userid."';
    ";
    mysqli_query(DB_Link(), $sql);
    return mysqli_affected_rows(DB_Link()) > 0;
}