<?php

define('STUDENT', 0);
define('LECTURER', 1);
define('ADVISOR', 2);
define('ADMIN', 3);

class UserModel extends CI_Model {

    private $accessLevels = array(
        'Student',
        'Lector',
        'Studieadviseur',
        'Beheerder'
    );

    // We need an empty construct, this way CI can autoload this class
    public function __construct() {}

    private function encryptPassword($password) {
        // We first uppercase the password to eliminate case
        // We then hash the password using Whirlpool (outputs 128 character hash)
        return hash('whirlpool', strtoupper($password));
    }

    public function isCorrectCredentials($username, $password) {

        $hashedPassword = $this->encryptPassword($password);

        // We count how many rows match this username AND password
        $conditions = array('username' => $username, 'password' => $hashedPassword);
        $query = $this->db->get_where('users', $conditions);
        return $query->num_rows() > 0;
    }

    public function register($username, $firstname, $lastname, $password, $email) {

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

    public function load($username) {
        $this->db->where(array('username' => $username));
        $query = $this->db->get('users');
        return $query->num_rows() > 0 ? $query->result()[0] : FALSE;
    }

    public function accessLevelName($accessLevel) {
        return isset($this->accessLevels[$accessLevel]) ? $this->accessLevels[$accessLevel] : $this->accessLevels[0];
    }

}