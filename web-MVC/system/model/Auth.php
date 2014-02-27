<?php

class Auth
{
    private static $instance = null;
    private $_userClass = 'player';
    private $_loader;
    private $_userMapper;
    private $_currentUser;

    public function __construct()
    {
        $this->_loader = Loader::getInstance();
        $this->_userMapper = $this->_loader->getModelMapper($this->_userClass);
        $this->_initCurrentUser();
    }

    public function getCurrentUser()
    {
        return $this->_currentUser;
    }

    public function getUserAccessLevel()
    {

        if ($this->_currentUser) {
            if ($this->_currentUser->isadmin) {
                return 2;
            } else {
                return 1;
            }
        } else {
            return 0;
        }
    }

    public static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function login($email, $password)
    {
        $userForEmail = $this->_userMapper->getPlayerForEmail($email);

        if (!$userForEmail) {
            $message = new Message('Geen gebruiker voor dit e-mail adres gevonden', false);
        } else if ($userForEmail->checkPassword($password)) {
            if ($userForEmail->isblocked) {
                $message = new Message('Je e-mail adres is geblokkeerd door de admin. Je kan niet inloggen.', false);
            } else {
                $_SESSION['user'] = $userForEmail->getId();
                $this->_currentUser = $userForEmail;
                $message = new Message('Succesvol ingelogd');
            }
        } else {
            $message = new Message('Verkeerd wachtwoord', false);
        }

        return $message;
    }

    public function logout()
    {
        $this->_currentUser = false;

        if (isset($_SESSION['user'])) {
            unset($_SESSION['user']);
        }

        return true;
    }

    private function _initCurrentUser()
    {
        if (isset($_SESSION['user'])) {
            $this->_currentUser = $this->_userMapper->get($_SESSION['user']);
        } else {
            $this->_currentUser = false;
        }
    }
}
