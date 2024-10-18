<?php 

function getRequestType(){
    return $_SERVER['REQUEST_METHOD'];
}


function postMethod(){

    if(getRequestType() == "POST"){
        return true;
    }
    return false;
}



function receivedInput($value){
    return trim(htmlentities(htmlspecialchars($value))) ;
}