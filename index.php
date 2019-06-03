<?php
// Turn on error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

session_start();

// Require autoload
require_once "vendor/autoload.php";
require  'model/validation.php';

//universal database connection
$user = $_SERVER['USER'];
require_once("/home/$user/budget-db-connect.php");

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

$f3->route('GET|POST /registration', function($f3) {
    if(!empty($_POST)) {
        // get value from form
        $fname = $_POST['fname'];
        $lname = $_POST['lname'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $confirmation = $_POST['confirmation'];

        // add to f3 hive
        $f3->set('fname', $fname);
        $f3->set('lname', $lname);
        $f3->set('email', $email);
        $f3->set('password', $password);
        $f3->set('confirmation', $confirmation);

        // Validate
        if(validRegistration()) {
            try {
                // Instantiate a database object
                $dbh = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
//                echo 'Connected to database';
            }
            catch(PDOException $e) {
                echo $e->getMessage();
            }
            //Define the query
            $sql = "INSERT INTO users(first_name, last_name, email, pass)
                    VALUE(:first_name, :last_name, :email, :pass)";

            // Prepare the statement
            $statement = $dbh->prepare($sql);

            // Bind the parameter
            $statement->bindParam(':first_name', $fname, PDO::PARAM_STR);
            $statement->bindParam(':last_name', $lname, PDO::PARAM_STR);
            $statement->bindParam(':email', $email, PDO::PARAM_STR);
            $statement->bindParam(':pass', $password, PDO::PARAM_STR);

            // Execute
            $statement->execute();

            //get the new user id
            $identity = "SELECT @@identity";

            $id = $dbh->prepare($identity);

            $id->execute();

            $id = $id->fetch(PDO::FETCH_ASSOC);

            $id = $id['@@identity'];

            $_SESSION['uuid'] = $id;

            $f3->reroute('/pay');
        }
    }

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

$f3->route('GET|POST /expenses', function($f3){

    //TODO: Validation
    //TODO: Inline Errors
    //TODO: Database updates

    // Display a view
    $view = new Template();
    echo $view->render('views/ExpensesTemplate.html');
});

$f3->route('GET|POST /results', function($f3){
    // Display a view
    $view = new Template();
    echo $view->render('views/ResultsTemplate.html');
});

$f3->run();
