<?php

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

$query = 'INSERT INTO expenses(uuid, name, type, value) VALUES (:uuid, :name, :type, :amount)';

$uuid = $_POST['uuid'];
$name = $_POST['name'];
$type = $_POST['type'];
$amount = $_POST['amount'];

$statement = $dbc->prepare($query);

$statement->bindParam(':uuid', $uuid, PDO::PARAM_STR);
$statement->bindParam(':name', $name, PDO::PARAM_STR);
$statement->bindParam(':type', $type, PDO::PARAM_STR);
$statement->bindParam(':amount', $amount, PDO::PARAM_STR);

$statement->execute();

$statement->fetch();

