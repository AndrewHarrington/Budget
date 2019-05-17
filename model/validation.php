<?php
// Name validation check for string
function validName($name) {
    return isset($name) && $name != "" && ctype_alpha($name);
}

// Email validation filter valid email
function validEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

// Password validation
function validPassword($password, $confirmation) {
    if(!empty($password) && ($password == $confirmation)) {
        if(strlen($password) <= 8) {
            return "Your password must contain at least 8 characters!";
        }
        else if(!preg_match("#[0-9]+#",$password)) {
            return "You password must contain at least 1 number!";
        }
        else if(!preg_match("#[A-Z]+#",$password)) {
            return "Your password must contain at least 1 capital letter!";
        }
        else if(!preg_match("#[a-z]+#",$password)) {
            return "Your password must contain at least 1 lowercase letter!";
        }
    }
    else if(!empty($password)) {
        return "Please check your confirmation";
    }
    else {
        return "Please enter your password";
    }
}