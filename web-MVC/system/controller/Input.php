<?php

class Input
{
    public function post($key, $default = false)
    {
        if (isset($_POST[$key])) {
            return $this->_sanitize($_POST[$key]);
        } else {
            return $default;
        }
    }

    public function get($key, $default = false)
    {
        if (isset($_GET[$key])) {
            return $this->_sanitize($_GET[$key]);
        } else {
            return $default;
        }
    }

    public function cookie($key, $default = false)
    {
        if (isset($_COOKIE[$key])) {
            return $this->_sanitize($_COOKIE[$key]);
        } else {
            return $default;
        }
    }

    private function _sanitize($input)
    {
        if (is_array($input)) {
            for ($i = 0; $i < count($input); $i++) {
                $this->_sanitize($input[$i]);
            }
        } else {
            $input = trim($input);
            $input = htmlentities($input, ENT_QUOTES, "UTF-8");
        }

        return $input;
    }
}