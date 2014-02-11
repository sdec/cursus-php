<?php

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