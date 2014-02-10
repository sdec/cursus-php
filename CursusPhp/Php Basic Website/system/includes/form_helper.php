<?php
//Validation
function checkPostLength($postkey, $errormessage, $minChars=2, $maxChars=32, $required=true){
    if(isset($_POST[$postkey])){
        $message = array(
            "status" => "",
            "message" => ""
        );
       if(strlen($_POST[$postkey]) >= $minChars && strlen($_POST[$postkey]) <= $maxChars){
           } else {
               $message["message"] = $errormessage;
               $message["status"] = "has-error";
           }
        } else {
        if($required){
            $message["message"] = "Gelieve hier iets in te vullen!";
            $message["status"] = "has-error";
        }
    }
    return $message;
}
?>
