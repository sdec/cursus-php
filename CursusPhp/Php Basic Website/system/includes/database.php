<?php

$link = 0;

function DB_Connect() {
    global $link;
    $link = mysqli_connect('localhost', 'root', '', 'cursusphp');
}

function DB_Close() {
    global $link;
    mysqli_close($link);
}

function DB_Link() {
    global $link;
    return $link;
}