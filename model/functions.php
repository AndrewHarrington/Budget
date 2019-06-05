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

    if(strlen($f3->get('password')) < 8) {
        $f3->set("errors['password']", "Please enter a password longer than 8 characters");
        $valid = false;
    }

    if($f3->get('password') != $f3->get('confirmation')) {
        $f3->set("errors['confirmation']", "Confirmation does not match password");
        $valid = false;
    }
    return $valid;
}

function validExpense(Expense $expense){
    return validName($expense->getName()) && validNum($expense->getAmount());
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

function validLogin($email, $pass){
    $dbc = connectToDatabase();

    $query = 'SELECT UUID FROM users WHERE email = :email AND pass = :pass';

    $statement = $dbc->prepare($query);

    $statement->bindParam(':email', $email, PDO::PARAM_STR);
    $statement->bindParam(':pass', $pass, PDO::PARAM_STR);

    $statement->execute();

    $rows = $statement->fetch(PDO::FETCH_ASSOC);

    if(empty($rows)){
        return false;
    }
    else{
        return $rows['UUID'];
    }
}

function getExpenses($uuid){
    $dbc = connectToDatabase();

    $query = 'SELECT expenseID, name, type, value FROM expenses WHERE UUID = :uuid';

    $statement = $dbc->prepare($query);

    $statement->bindParam(':uuid', $uuid, PDO::PARAM_STR);

    $statement->execute();

    $rows = $statement->fetchAll(PDO::FETCH_ASSOC);

    return $rows;
}

function connectToDatabase(){
    //database connection
    $user = $_SERVER['USER'];
    require_once("/home/$user/budget-db-connect.php");

// Make the connection
    try {
        $dbc = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
    }catch (PDOException $ex){
        echo "FATAL FLAW FOUND<br>$ex<br>";
        return;
    }

    return $dbc;
}