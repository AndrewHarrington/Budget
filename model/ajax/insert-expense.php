<?php
//database connection
$user = $_SERVER['USER'];
require_once("/home/$user/budget-db-connect.php");

// Make the connection
try {
    $dbc = new PDO(DSN, DB_USER, DB_PASSWORD);
}catch (PDOException $ex){
    echo "FATAL FLAW FOUND<br>$ex<br>";
    return;
}

$query = 'INSERT INTO expenses("UUID", "name", "type", "amount") VALUES(:uuid, :name, :type, :amount)';

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

$val = $statement->fetchAll(PDO::FETCH_ASSOC);
