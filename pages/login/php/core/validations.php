<?php

function requiredInput($input){
    if(empty($input)){
        return true;
    }
    return false;
}

function minInput($input,$length){
    if(strlen($input) < $length){
        return true;
    }
    return false;
}


function maxInput($input,$length){
    if(strlen($input) > $length){
        return true;
    }
    return false;
}

function emailInput($email){
    if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
        return true;
    }
    return false;
}

function sameInput($value1,$value2){
    if($value1 != $value2){
        return true;
    }
    return false;
}
function isValidJordanianMobile($phone) {
    
    $pattern = '/^07[7-9]\d{7}$/';
    return preg_match($pattern, $phone);
}
// function isPassword($password) {
    
//     $pattern = '^(?=.[A-Z])(?=.[!@#$%^&(),.?&quot;:{}|<>])[A-Za-z\d!@#$%^&(),.?&quot;:{}|<>]{6,}$';
//     return preg_match($pattern, $password);
// }
function isPassword($password) {
    $pattern = '/^(?=.*[A-Z])(?=.*[!@#$%^&(),.?":{}|<>])[A-Za-z\d!@#$%^&(),.?":{}|<>]{6,}$/';
    return preg_match($pattern, $password);
}
