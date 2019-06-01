<?php
function validRegistration() {
    global $f3;
    $valid = true;

    if(!validName($f3->get('fname'))) {
        $f3->set("errors['fname']", "Please enter a valid first name");
        $valid = false;
    }

    if(!validName($f3->get('lname'))) {
        $f3->set("errors['lname']", "Please enter a valid last name");
        $valid = false;
    }

    if(!validEmail($f3->get('email'))) {
        $f3->set("errors['email']", "Please enter a valid email");
        $valid = false;
    }

    if(strlen($f3->get('password') < 8)) {
        $f3->set("errors['password']", "Please enter a password longer than 8 characters");
        $valid = false;
    }

    if($f3->get('password') != $f3->get('confirmation')) {
        $f3->set("errors['confirmation']", "Confirmation does not match password");
        $valid = false;
    }

    return $valid;
}

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