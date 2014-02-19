<?php

$errors = array();
$values = array();

function form_error($field, $before = '', $after = '') {
    global $errors;
    return $before . (isset($errors[$field]) ? $errors[$field] : '') . $after;
}

function set_error($field, $message) {
    global $errors;
    $errors[$field] = $message;
}

function hasErrors() {
    global $errors;
    return count($errors) > 0;
}

function set_value($field, $value = '') {
    global $values;
    if(!strlen($value))
        return isset($values[$field]) ? $values[$field] : '';
        
    $values[$field] = $value;
}

function message($text, $class = 'success') {
    if(!isset($_SESSION['message'])) {
        $_SESSION['message'] = array();
    }
    $message = array(
        'text' => $text,
        'class' => $class
    );
    array_push($_SESSION['message'], $message);
}

function isMinLength($field, $length) {
    global $values;
    if(!isset($values[$field]))
        return FALSE;
    
    return strlen($values[$field]) >= $length;
}

function isMaxLength($field, $length) {
    global $values;
    if(!isset($values[$field]))
        return FALSE;
    
    return strlen($values[$field]) <= $length;
}

function isAlphaNumeric($field) {
    global $values;
    if(!isset($values[$field]))
        return FALSE;
    
    return !preg_match('/[^a-z0-9]/i', $values[$field]);
}

function isValidEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}