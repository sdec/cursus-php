<?php
class User extends Identifiable
{
    private $_userid;
    private $_username;
    private $_firstname;
    private $_lastname;
    private $_email;
    private $_accesslevel;

    public function __construct($userid = -1, $username = 'usr', $firstname = 'fname', $lastname = 'name', $password = '', $email = 'fname.name@student.khleuven.be', $accesslevel = 1)
    {
        $this->setUserid($userid);
        $this->setUsername($username);
        $this->setFirstname($firstname);
        $this->setLastname($lastname);
        //$this->setHashedpassword($password);
        $this->setEmail($email);
        $this->setAccesslevel($accesslevel);
    }

    public function __toString()
    {
        return 'de ' . accessLevelName($this->_accesslevel) . ' met de gebruikersnaam ' . $this->getUsername() . ' en naam ' . $this->getFirstname() . ' ' . $this->getLastname();
    }

    public function setUsername($username)
    {
        $this->_username = $username;
    }

    public function getUsername()
    {
        return $this->_username;
    }

    public function setFirstname($firstname)
    {
        $this->_firstname = $firstname;
    }

    public function getFirstname()
    {
        return $this->_firstname;
    }
    
    public function setLastname($lastname)
    {
        $this->_lastname = $lastname;
    }

    public function getLastname()
    {
        return $this->_lastname;
    }
    
    public function setAccesslevel($accesslevel)
    {
        $this->_accesslevel = $accesslevel;
    }

    public function getAccesslevel()
    {
        return $this->_accesslevel;
    }
    
    public function setUserid($userid)
    {
        $this->_userid = $userid;
    }

    public function getUserid()
    {
        return $this->_userid;
    }
    
    public function setEmail($email)
    {
        $this->_email = $email;
    }

    public function getEmail()
    {
        return $this->_email;
    }
}

?>