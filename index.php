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
    // Display a view
    $view = new Template();
    echo $view->render('views/landing.html');
});

$f3->route('GET|POST /registration', function() {
    // Display a view
    $view = new Template();
    echo $view->render('views/register.html');
});

$f3->run();
