<?php
// Turn on error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Require autoload
require_once "vendor/autoload.php";
require  'model/functions.php';
//start the session
session_start();

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
$f3->route('GET|POST /', function($f3) {

    //login
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $login = validLogin($_POST['email'], $_POST['password']);
        if($login != false){
            $_SESSION['uuid'] = $login;
            $_SESSION['results'] = new Results(new Manual(400), array());
            $f3->reroute('/pay');
        }
    }

    // Display a view
    $view = new Template();
    echo $view->render('views/landing.html');
});

$f3->route('GET|POST /registration', function($f3) {

    // initialize values from form
    $fname = $lname = $email = $password = $confirmation = '';

    // add to f3 hive
    $f3->set('fname', $fname);
    $f3->set('lname', $lname);
    $f3->set('email', $email);
    $f3->set('password', $password);
    $f3->set('confirmation', $confirmation);

    if($_SERVER['REQUEST_METHOD'] == "POST") {
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
        $valid = false;
        $payOBJ = null;
        print_r($_POST);
        //determine the type of pay that we received
        switch ($_POST['type']){
            //if hourly
            case 'hor' :
                //remove undesired characters
                $wage = preg_replace("/[^0-9.]/", "", $_POST['wage']);
                $hours = preg_replace("/[^0-9.]/", "", $_POST['hours']);
                $tax = preg_replace("/[^0-9.]/", "", $_POST['tax']);
                $total = $wage * $hours;
                //check validity
                if(!validNumber($wage) || !validNumber($hours) || !validNumber($tax)){
                    $valid = false;
                }
                else{
                    //create the object
                    $payOBJ = new Hourly($hours, $wage, $tax);
                    $_SESSION['payType'] = 'hourly';
                    $_SESSION['hours'] = $hours;
                    $_SESSION['wage'] = $wage;
                    $_SESSION['total'] = $total;
                    $_SESSION['postTax'] = $total-($total * $tax);
                    $valid = true;
                }
                break;
            //if monthly
            case 'mon':
                $pay = preg_replace("/[^0-9.]/", "", $_POST['pay']);
                $tax = preg_replace("/[^0-9.]/", "", $_POST['tax']);

                if(!validNumber($pay) || !validNumber($tax)){
                    $valid = false;
                }
                else{
                    $payOBJ = new Salary($pay, $tax);
                    $_SESSION['payType'] = 'salary';
                    $_SESSION['total'] = $pay;
                    $_SESSION['postTax'] = $pay-($pay*$tax);
                    $valid = true;
                }
                break;
            //if manual
            case 'man':
                $pay = preg_replace("/[^0-9.]/", "", $_POST['pay']);
                if(!validNumber($pay)){
                    $valid = false;
                }
                else{
                    $payOBJ = new Manual($pay);
                    $_SESSION['payType'] = 'manual';
                    $_SESSION['total'] = $pay;
                    $valid = true;
                }
                break;
            default:
                //bad data
                $valid = false;
                //redirect
                $f3->reroute('/');
        }

        if($valid){
            $results = $_SESSION['results'];
            $results->setPay($payOBJ);

            //reroute
            $f3->reroute('/expenses');
        }
    }
    // Display a view
    $view = new Template();
    echo $view->render('views/PayTemplate.html');
});

$f3->route('GET|POST /expenses', function($f3){

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $f3->reroute('/results');
    }

    // Display a view
    $view = new Template();
    echo $view->render('views/ExpensesTemplate.html');
});

$f3->route('GET|POST /results', function($f3){
    //grab and store the expenses
    $expenses = array();
    $uuid = $_SESSION['uuid'];
    $rows = getExpenses($uuid);
    //loop
    foreach ($rows as $key => $value){
        //name
        $name = $value['name'];
        //type
        $type = $value['type'];
        //value
        $val = $value['value'];

        array_push($expenses, new Expense($name, $type, $val));
    }

    //add the expenses to the Results object
    $results = $_SESSION['results'];
    $results->setExpenses($expenses);
    // Display a view
    $view = new Template();
    echo $view->render('views/ResultsTemplate.html');
    session_destroy();
});

$f3->run();
