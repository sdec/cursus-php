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

    $hashedPassword = $this->encryptPassword($password);

    // Insert the new user in the database
    $insertData = array(
        'username' => $username,
        'firstname' => $firstname,
        'lastname' => $lastname,
        'password' => $hashedPassword,
        'email' => $email
    );
    $this->db->insert('users', $insertData);

    // Check if the insert succeeded
    return $this->db->affected_rows() > 0;
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

function accessLevelName($accessLevel) {
    return isset($this->accessLevels[$accessLevel]) ? $this->accessLevels[$accessLevel] : $this->accessLevels[0];
}

function lecturers() {
    $query = $this->db->get('lecturers');
    return $query->num_rows() > 0 ? $query->result() : FALSE;
}