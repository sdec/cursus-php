<?php
//setup
function initializeMessages($messages){
    $messagesReturn['foo'] = array ("foo" => "bar");
    foreach ($messages as &$message) {
        $messagesReturn[$message] = array(
            "status" => "",
            "message" => ""
        );
    }
    unset($messagesReturn['foo']);
    return $messagesReturn;
}

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