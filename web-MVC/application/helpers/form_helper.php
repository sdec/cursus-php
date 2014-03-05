<?php
class FormHelper{
    private $errors = array();
    private $values = array();

    public function form_error($field, $before = '', $after = '') {
        return $before . (isset($this->errors[$field]) ? $this->errors[$field] : '') . $after;
    }

    public function set_error($field, $message) {
        $this->errors[$field] = $message;
    }

    public function hasErrors() {
        return count($this->errors) > 0;
    }

    public function set_value($field, $value = '') {
        if(!strlen($value))
            return isset($this->values[$field]) ? $this->values[$field] : '';

        $this->values[$field] = $value;
    }

    public static function message($text, $class = 'success') {
        if(!isset($_SESSION['message'])) {
            $_SESSION['message'] = array();
        }
        $message = array(
            'text' => $text,
            'class' => $class
        );
        array_push($_SESSION['message'], $message);
    }

    public function isMinLength($field, $length) {
        if(!isset($this->values[$field]))
            return FALSE;

        return strlen($this->values[$field]) >= $length;
    }

    public function isMaxLength($field, $length) {
        if(!isset($this->values[$field]))
            return FALSE;

        return strlen($this->values[$field]) <= $length;
    }

    public function isAlphaNumeric($field) {
        if(!isset($this->values[$field]))
            return FALSE;

        return !preg_match('/[^a-z0-9]/i', $this->values[$field]);
    }

    public function isValidEmail($email) {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }

}