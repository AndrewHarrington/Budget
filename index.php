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

$f3->route('GET|POST /pay', function ($f3){

    //TODO: Add inline errors

    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        //validation
        $valid = true;
        $payOBJ = null;

        //determine the type of pay that we received
        switch ($_POST['type']){
            //if hourly
            case 'hor' :
                //remove undesired characters
                $wage = preg_replace("/[^0-9.]/", "", $_POST['wage']);
                $hours = preg_replace("/[^0-9.]/", "", $_POST['hours']);
                $tax = preg_replace("/[^0-9.]/", "", $_POST['tax']);

                //check validity
                if(!validNum($wage) || !validNum($hours) || !validNum($tax)){
                    $valid = false;
                }
                else{
                    //create the object
                    $payOBJ = new Hourly($hours, $wage, $tax);
                }
                break;
            //if monthly
            case 'mon':
                $pay = preg_replace("/[^0-9.]/", "", $_POST['pay']);
                $tax = preg_replace("/[^0-9.]/", "", $_POST['tax']);

                if(!validNum($pay) || !validNum($tax)){
                    $valid = false;
                }
                else{
                    $payOBJ = new Salary($pay, $tax);
                }
                break;
            //if manual
            case 'man':
                $pay = preg_replace("/[^0-9.]/", "", $_POST['pay']);
                if(!validNum($pay)){
                    $valid = false;
                }
                else{
                    $payOBJ = new Manual($pay);
                }
                break;
            default:
                //bad data
                $valid = false;
                //redirect
                $f3->reroute('/pay');
        }

        //storage
        $f3->set('pay', $payOBJ);

        if($valid){
            //reroute
            $f3->reroute('/expenses');
        }
    }
    // Display a view
    $view = new Template();
    echo $view->render('views/PayTemplate.html');
});

$f3->route('GET|POST /expenses', function(){

});

$f3->route('GET|POST /results', function(){

});

$f3->run();
