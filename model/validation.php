<?php
// Name validation check for string
function validName($name) {
    return isset($name) && $name != "" && ctype_alpha($name);
}

// Email validation filter valid email
function validEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

function validNumber($num){
    return is_numeric($num);
}