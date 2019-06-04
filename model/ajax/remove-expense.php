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

$query = 'DELETE FROM expenses WHERE expenseID = :id';

$id = $_POST['id'];

$statement = $dbc->prepare($query);

$statement->bindParam(':id', $id, PDO::PARAM_STR);

$statement->execute();