<?php

define('STUDENT', 0);
define('LECTURER', 1);
define('ADVISOR', 2);
define('ADMIN', 3);

class User_Mapper {

    private $_db;

    public $accessLevels = array(
        'Student',
        'Lector',
        'Studieadviseur',
        'Beheerder'
    );
    
    public function __construct() {
        $this->_db = Db::getInstance();
    }

    function encryptPassword($password) {
        // We first uppercase the password to eliminate case
        // We then hash the password using Whirlpool (outputs 128 character hash)
        return hash('whirlpool', strtoupper($password));
    }

    function isCorrectCredentialsUser($username, $password) {
        $hashedPassword = $this->encryptPassword($password);

        //http://stackoverflow.com/questions/767026/how-can-i-properly-use-a-pdo-object-for-a-select-query
        $sql = "
           SELECT *
           FROM users
           WHERE username = :username
           AND password = :hashedPassword
        ";

        $arguments = array(
            ':username' => $username,
            ':hashedPassword' => $hashedPassword,
        );
        $result = $this->_db->execute($sql, $arguments);
        return $result->rowCount() > 0;

        /* $result = $this->_db->queryOne($sql, 'User', $arguments);
          var_dump($result);
          return ($result) ? true : false; */
    }

    function loadUser($username) {
        $sql = "
            SELECT *
            FROM users
            WHERE username LIKE :username
        ";

        $arguments = array(
            ':username' => $username,
        );

        $result = $this->_db->execute($sql, $arguments);
        return $result->rowCount() > 0 ? $result->fetch(PDO::FETCH_ASSOC) : FALSE;
    }

    function registerUser($username, $firstname, $lastname, $password, $email) {
        $hashedPassword = $this->encryptPassword($password);

        $sql = "
            INSERT INTO users (username, firstname, lastname, password, email) 
            VALUES (:username, :firstname, :lastname, :password, :email);
        ";

        $arguments = array(
            ':username' => $username,
            ':firstname' => $firstname,
            ':lastname' => $lastname,
            ':password' => $hashedPassword,
            ':email' => $email,
        );

        $result = $this->_db->execute($sql, $arguments);
        echo(getLastInsertId());
        return $result->rowCount() > 0 ? TRUE : FALSE;
    }

    function usernameExists($username) {
        $sql = "
            SELECT *
            FROM users
            WHERE username LIKE :username
        ";

        $arguments = array(
            ':username' => $username,
        );

        $result = $this->_db->execute($sql, $arguments);
        return $result->rowCount() > 0;
    }

    function lecturers() {
        $sql = "
            SELECT *
            FROM lecturers
        ";
        $result = $this->_db->execute($sql);
        $lecturers = $result->fetchAll(PDO::FETCH_ASSOC);
        /* while ($lecturer = mysqli_fetch_assoc($result)) {
          array_push($lecturers, $lecturer);
          } */
        return (count($lecturers) > 0) ? $lecturers : FALSE;
    }

    function loadAllUsers() {
        $sql = "
            SELECT *
            FROM users
        ";
        $result = $this->_db->execute($sql);
        $users = $result->fetchAll(PDO::FETCH_ASSOC);
        /* while ($user = mysqli_fetch_assoc($result)) {
          array_push($users, $user);
          } */
        return (count($users) > 0) ? $users : FALSE;
    }

    function searchUsers($search) {
        $search = '%' . $search . '%'; //add substring query signs
        $sql = "
            SELECT *
            FROM users
            WHERE
                username LIKE :search
                OR firstname LIKE :search
                OR lastname LIKE :search
                OR email LIKE :search
                OR CONCAT(firstname, ' ', lastname) LIKE :search

            GROUP BY username";

        $arguments = array(
            ':search' => $search,
        );

        $result = $this->_db->execute($sql, $arguments);
        $users = $result->fetchAll(PDO::FETCH_ASSOC);
        /* while ($user = mysqli_fetch_assoc($result)) {
          array_push($users, $user);
          } */
        return (count($users) > 0) ? $users : FALSE;
    }

    function deleteUser($userid) {
        $sql = "
            DELETE FROM users
            WHERE userid = :userid;
        ";
        $arguments = array(
            ':userid' => $userid,
        );
        $result = $this->_db->execute($sql, $arguments);
        return $result->rowCount() > 0;
    }

    function editUser($userid, $username, $firstname, $lastname, $email, $accesslevel) {
        $sql = "
            UPDATE users
            SET username = :username, firstname = :firstname, 
                lastname = :lastname, email = :email, accesslevel = :accesslevel
            WHERE userid = :userid;
        ";
        $arguments = array(
            ':userid' => $userid,
            ':username' => $username,
            ':firstname' => $firstname,
            ':lastname' => $lastname,
            ':email' => $email,
            ':accesslevel' => $accesslevel,
        );
        $result = $this->_db->execute($sql, $arguments);
        return $result->rowCount() > 0;
    }

    /* public function add($object)
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
      } */

    function accessLevelName($accessLevel) {
        return isset($this->accessLevels[$accessLevel]) ? $this->accessLevels[$accessLevel] : $this->accessLevels[0];
    }

}