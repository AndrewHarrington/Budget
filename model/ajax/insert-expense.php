<?php
require_once ('../../vendor/autoload.php');
require_once('../functions.php');

//get all the data
$uuid = $_POST['uuid'];
$name = $_POST['name'];
$type = $_POST['type'];
$amount = $_POST['amount'];

//create object for ease of tracking
$expense = new Expense($name, $type, $amount);

//validate the expense
if(!validExpense($expense)){
    //if invalid, return
    echo "FAIL";
    return;
}

//database connection
$dbc = connectToDatabase();

echo '<p>connected to db</p>';

$query = 'INSERT INTO expenses(uuid, name, type, value) VALUES (:uuid, :name, :type, :amount)';

$statement = $dbc->prepare($query);

$statement->bindParam(':uuid', $uuid, PDO::PARAM_STR);
$statement->bindParam(':name', $name, PDO::PARAM_STR);
$statement->bindParam(':type', $type, PDO::PARAM_STR);
$statement->bindParam(':amount', $amount, PDO::PARAM_STR);

$statement->execute();

$err = $statement->errorInfo();