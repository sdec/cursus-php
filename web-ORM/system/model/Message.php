<?php

class Message {
    private $_status;
    private $_message;

    function __construct($message = '', $status = true)
    {
        $this->_setMessage($message);
        $this->_setStatus($status);
    }

    private function _setMessage($message)
    {
        $this->_message = $message;
    }

    public function getMessage()
    {
        return $this->_message;
    }

    private function _setStatus($status)
    {
        $this->_status = $status;
    }

    public function getStatus()
    {
        return $this->_status;
    }
}