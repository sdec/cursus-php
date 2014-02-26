<?php

function DB_Link() {
    //global $link;
    return Db::getInstance(); //$link;
}

/*function sanitize($input) {
    global $link;
    if (is_array($input)) {
        $arr = array();
        foreach ($input as $element) {
            $arr[] = mysqli_real_escape_string($link, $element);
        }
        return $arr;
    }
    return mysqli_real_escape_string($link, $input);
}*/