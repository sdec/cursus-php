<?php

function redirect($page) {
    header('Location: ' . base_url() . $page);
    die;
}