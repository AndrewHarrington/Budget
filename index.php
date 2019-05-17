<?php
// Turn on error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

session_start();

// Require autoload
require_once "vendor/autoload.php";

// Create an instance of the Base class
$f3 = Base::instance();

// Turn on Fat-Free error reporting
set_exception_handler(function($obj) use($f3){
    $f3->error(500,$obj->getmessage(),$obj->gettrace());
});
set_error_handler(function($code,$text) use($f3) {
    if (error_reporting()) {
        $f3->error(500,$text);
    }
});
$f3->set('DEBUG', 3);

// Define a default route
$f3->route('GET /', function() {
    session_destroy();

    // Display a view
    $view = new Template();
    echo $view->render('views/landing.html');
});

$f3->route('GET|POST /registration', function($f3) {
    if($_SERVER['REQUEST_METHOD'] == POST) {
        $valid = true;

        $fname = $_POST['fname'];
        $lname = $_POST['lname'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $confirmation = $_POST['confirmation'];

        // Check first name
        if(validName($fname)) {
            $_SESSION['first'] = $fname;
        }
        else {
            $f3->set("errors['fname']", "Please enter a valid first name");
            $valid = false;
        }

        // Check last name
        if(validName($lname)) {
            $_SESSION['last'] = $lname;
        }
        else {
            $f3->set("errors['lname']", "Please enter a valid last name");
            $valid = false;
        }

        // Check for email
        if(validEmail($email)) {
            $_SESSION['email'] = $email;
        }
        else {
            $f3->set("errors['email']", "Please enter a valid email");
            $valid = false;
        }

        // Check for password
        $errMsg = validPassword($password, $confirmation);

        if(empty($errMsg)) {
            $_SESSION['password'] = $password;
        }
        else {
            $f3->set("errors['email']", $errMsg);
            $valid = false;
        }

        if($valid) {
            echo 'It works';
        }
    }



    // Display a view
    $view = new Template();
    echo $view->render('views/register.html');
});

$f3->run();
