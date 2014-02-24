<?php
require_once('Db.php');
require_once('Vehicle.php');
define('STUDENT', 0);
define('LECTURER', 1);
define('ADVISOR', 2);
define('ADMIN', 3);

class Vehicle_Mapper
{
    private $_db;
    public static $accessLevels = array(
        'Student',
        'Lector',
        'Studieadviseur',
        'Beheerder'
    );
    
    public function __construct(){
        $this->_db = Db::getInstance();
    }

    function encryptPassword($password) {
        // We first uppercase the password to eliminate case
        // We then hash the password using Whirlpool (outputs 128 character hash)
        return hash('whirlpool', strtoupper($password));
    }

    function isCorrectCredentialsUser($username, $password) {

        $hashedPassword = encryptPassword($password);

        $sql = "
            SELECT *
            FROM users
            WHERE username = '" . sanitize($username) . "' AND password = '" . $hashedPassword . "'
        ";
        $result = mysqli_query(DB_Link(), $sql);
        return mysqli_num_rows($result) > 0;
    }

    function registerUser($username, $firstname, $lastname, $password, $email) {

        $hashedPassword = encryptPassword($password);

        $sql = "
            INSERT INTO users (username, firstname, lastname, password, email) 
            VALUES ('" . sanitize($username) . "', '" . sanitize($firstname) . "', '" . sanitize($lastname) . "', 
                '" . sanitize($hashedPassword) . "', '" . sanitize($email) . "');
        ";
        mysqli_query(DB_Link(), $sql);
        return mysqli_affected_rows(DB_Link());
    }

    function loadUser($username) {
        $sql = "
            SELECT *
            FROM users
            WHERE username LIKE '" . sanitize($username) . "'
        ";
        $result = mysqli_query(DB_Link(), $sql);
        return mysqli_num_rows($result) > 0 ? mysqli_fetch_assoc($result) : FALSE;
    }

    function usernameExists($username) {
        $sql = "
            SELECT *
            FROM users
            WHERE username LIKE '" . sanitize($username) . "'
        ";
        $result = mysqli_query(DB_Link(), $sql);
        return mysqli_num_rows($result) > 0;
    }

    function accessLevelName($accessLevel) {
        //$this.accessLevels;
        return isset($this->accessLevels[$accessLevel]) ? $this->accessLevels[$accessLevel] : $this->accessLevels[0];
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

    function loadAllUsers() {
        $sql = "
            SELECT *
            FROM users
        ";
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

    function deleteUser($userid) {
        $userid = sanitize($userid);
        $sql = "
            DELETE FROM users
            WHERE userid = '" . $userid . "';
        ";
        mysqli_query(DB_Link(), $sql);
        return mysqli_affected_rows(DB_Link()) > 0;
    }

    function editUser($userid, $username, $firstname, $lastname, $email, $accesslevel) {
        $sql = "
            UPDATE users
            SET username = '" . sanitize($username) . "', firstname = '" . sanitize($firstname) . "', 
                lastname = '" . sanitize($lastname) . "', email = '" . sanitize($email) . "', accesslevel = '" . sanitize($accesslevel) . "'
            WHERE userid = '" . sanitize($userid) . "';
        ";
        mysqli_query(DB_Link(), $sql);
        return mysqli_affected_rows(DB_Link()) > 0;
    }

    public function add($object)
    {
        $sql = "INSERT INTO vehicles (color, brand) VALUES (:color, :brand);";

        $arguments = array(
            $object->getColor(),
            $object->getBrand()
        );

        return $this->_db->execute($sql, $arguments);
    }

    public function getAll()
    {
        $sql = "SELECT * FROM vehicles";

        $data = $this->_db->query($sql);

        $objects = array();
        foreach ($data as $row) {
            $object = new Vehicle($row['color'], $row['brand']);
            $objects[] = $object;
        }
        return $objects;
    }
}