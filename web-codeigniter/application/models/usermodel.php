<?php

define('STUDENT', 0);
define('LECTURER', 1);
define('ADVISOR', 2);
define('ADMIN', 3);

class UserModel extends CI_Model {

    public $accessLevels = array(
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
    
    public function edit($userid, $username, $firstname, $lastname, $email, $accesslevel) {

        $updateData = array(
            'username' => $username,
            'firstname' => $firstname,
            'lastname' => $lastname,
            'email' => $email,
            'accesslevel' => $accesslevel
        );
        $this->db->where(array('userid' => $userid));
        $this->db->update('users', $updateData);
        
        return $this->db->affected_rows() > 0;
    }
    
    public function delete($userid) {
        $data = array('userid' => $userid);
        $this->db->delete('users', $data);
        return $this->db->affected_rows() > 0;
    }

    public function load($username) {
        $this->db->where(array('username' => $username));
        $query = $this->db->get('users');
        $result = $query->result();
        return $query->num_rows() > 0 ? $result[0] : FALSE;
    }
    
    public function loadall() {
        $query = $this->db->get('users');
        return $query->num_rows() > 0 ? $query->result() : FALSE;
    }
    
    public function search($query) {
        
        $this->db->like('firstname', $query);
        $this->db->or_like('lastname', $query);
        $this->db->or_like('username', $query);
        $this->db->or_like('email', $query);
        $query = $this->db->get('users');
        return $query->num_rows() > 0 ? $query->result() : FALSE;
    }

    public function accessLevelName($accessLevel) {
        return isset($this->accessLevels[$accessLevel]) ? $this->accessLevels[$accessLevel] : $this->accessLevels[0];
    }

    public function lecturers() {
        $query = $this->db->get('lecturers');
        return $query->num_rows() > 0 ? $query->result() : FALSE;
    }
    
}