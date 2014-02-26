<?php
require_once(systemmodel_url() . 'Db.php');
require_once('User.php');
/*define('STUDENT', 0);
define('LECTURER', 1);
define('ADVISOR', 2);
define('ADMIN', 3);*/

class User_Mapper
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
    
    function sanitize($input) {
        //global $link;
        if (is_array($input)) {
            $arr = array();
            foreach ($input as $element) {
          //      $arr[] = mysqli_real_escape_string($link, $element);
            }
            return $arr;
        }
        return $input;//mysqli_real_escape_string($link, $input);
    }

    function encryptPassword($password) {
        // We first uppercase the password to eliminate case
        // We then hash the password using Whirlpool (outputs 128 character hash)
        return hash('whirlpool', strtoupper($password));
    }

    function isCorrectCredentialsUser($username, $password) {

        $hashedPassword = encryptPassword($password);

        //$sql = "INSERT INTO vehicles (color, brand) VALUES (:color, :brand);";
        //http://stackoverflow.com/questions/767026/how-can-i-properly-use-a-pdo-object-for-a-select-query
        $sql = "
            SELECT *
            FROM users
            WHERE username = :username AND password = :hashedPassword
        ";

        $arguments = array(
            ':username' => $username,
            ':hashedPassword' => $hashedPassword,
        );
        $result = $this->_db->queryOne($sql, 'User', $arguments);
        var_dump($result);
        return ($result) ? true : false;
        
        //$result = mysqli_query(DB_Link(), $sql);
        //return mysqli_num_rows($result) > 0;
    }

    function registerUser($username, $firstname, $lastname, $password, $email) {

        $hashedPassword = encryptPassword($password);

        $sql = "
            INSERT INTO users (username, firstname, lastname, password, email) 
            VALUES ('" . $this->sanitize($username) . "', '" . $this->sanitize($firstname) . "', '" . $this->sanitize($lastname) . "', 
                '" . $this->sanitize($hashedPassword) . "', '" . $this->sanitize($email) . "');
        ";
        mysqli_query(DB_Link(), $sql);
        return mysqli_affected_rows(DB_Link());
    }

    function loadUser($username) {
        $sql = "
            SELECT *
            FROM users
            WHERE username LIKE '" . $this->sanitize($username) . "'
        ";
        $result = mysqli_query(DB_Link(), $sql);
        return mysqli_num_rows($result) > 0 ? mysqli_fetch_assoc($result) : FALSE;
    }

    function usernameExists($username) {
        $sql = "
            SELECT *
            FROM users
            WHERE username LIKE '" . $this->sanitize($username) . "'
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
        $search = $this->sanitize($search);

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
        $userid = $this->sanitize($userid);
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
            SET username = '" . $this->sanitize($username) . "', firstname = '" . $this->sanitize($firstname) . "', 
                lastname = '" . $this->sanitize($lastname) . "', email = '" . $this->sanitize($email) . "', accesslevel = '" . $this->sanitize($accesslevel) . "'
            WHERE userid = '" . $this->sanitize($userid) . "';
        ";
        mysqli_query(DB_Link(), $sql);
        return mysqli_affected_rows(DB_Link()) > 0;
    }

    public function add($object)
    {
        $sql = "INSERT INTO vehicles (color, brand) VALUES (:color, :brand);";

        $arguments = array(
            $object->getUsername(),
            $object->getFirstname()
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