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

$query = 'SELECT name, type, value FROM expenses WHERE "UUID" = :uuid';

$uuid = $_POST['uuid'];

$statement = $dbc->prepare($query);

$statement->bindParam(':uuid', $uuid, PDO::PARAM_STR);

$statement->execute();

$val = $statement->fetch(PDO::FETCH_ASSOC);

//show each li with proper values