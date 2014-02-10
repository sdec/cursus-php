<?php
//Role constants
define('STUDENT', 0);
define('LECTURER', 1);
define('ADVISOR', 2);
define('ADMIN', 3);
function getRole($index){
    //Sadly arrays cannot be constants in Php,
    //as we won't be using classes yet this is our (messy) work-around
    $ROLES = array('Student' => STUDENT,
                   'Lector' => LECTURER,
                   'Studieadviseur' => ADVISOR,
                   'Administrator' => ADMIN);
    foreach($ROLES as $role => $roleIndex){
        if($index == $roleIndex){
            return $role;
        }
    }
}

?>
