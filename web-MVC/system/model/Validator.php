<?php

class Validator
{
    private $_fieldMessages = array();

    public function isRequired($key, $value) {
        return $this->isValidLength($key, $value);
    }

    public function isValidLength($key, $value, $min = 1, $max=100)
    {
        if (strlen($value) < $min || strlen($value) > $max) {
            $this->_fieldMessages[$key] = new Message($key . " moet minstens $min lang zijn en mag niet meer dan $max zijn", false);
            $valid = false;
        }
        else {
            $this->_fieldMessages[$key] = new Message('', true);
            $valid = true;
        }
        return $valid;
    }

    public function isValidEmail($key, $value)
    {
        $email = filter_var($value, FILTER_VALIDATE_EMAIL);
        if (!$email) {
            $this->_fieldMessages[$key] = new Message($key . " is niet geldig", false);
            $valid = false;
        }
        else {
            $this->_fieldMessages[$key] = new Message('', true);
            $valid = true;
        }
        return $valid;
    }

    public function isConfirmed($key, $value, $confirmation)
    {
        if (strcmp($value, $confirmation) != 0) {
            $this->_fieldMessages[$key] = new Message($key . " is niet bevestigd", false);
            $confirmed = false;
        }
        else {
            $this->_fieldMessages[$key] = new Message('', true);
            $confirmed = true;
        }

        return $confirmed;
    }

    public function isValidForm () {
        foreach ($this->_fieldMessages as $field) {
            if (!$field->getStatus()) {
                return false;
            }
        }
        return true;
    }

    public function getFieldMessages()
    {
        return $this->_fieldMessages;
    }

}
