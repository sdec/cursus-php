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

function isCorrectCredentials($username, $password) {

    $hashedPassword = encryptPassword($password);

    // We count how many rows match this username AND password
    $conditions = array('username' => $username, 'password' => $hashedPassword);
    $query = $this->db->get_where('users', $conditions);
    return $query->num_rows() > 0;
}

function register($username, $firstname, $lastname, $password, $email) {

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

function load($username) {
    $this->db->where(array('username' => $username));
    $query = $this->db->get('users');
    return $query->num_rows() > 0 ? $query->result()[0] : FALSE;
}

function accessLevelName($accessLevel) {
    return isset($this->accessLevels[$accessLevel]) ? $this->accessLevels[$accessLevel] : $this->accessLevels[0];
}

function lecturers() {
    $query = $this->db->get('lecturers');
    return $query->num_rows() > 0 ? $query->result() : FALSE;
}