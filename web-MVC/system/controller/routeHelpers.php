<?php
function redirect($location)
{
    header('location: ' . baseUrl($location));
    exit;
}