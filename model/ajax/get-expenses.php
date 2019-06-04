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

$query = 'SELECT name, type, value FROM expenses WHERE UUID = :uuid';

$uuid = $_POST['uuid'];

$statement = $dbc->prepare($query);

$statement->bindParam(':uuid', $uuid, PDO::PARAM_STR);

$statement->execute();

$rows = $statement->fetchAll(PDO::FETCH_ASSOC);

//show each li with proper values

//start list
$header = "<ol id='list'>";

$list = '';
//loop
foreach ($rows as $key => $value){
    //name
    $name = $value['name'];
    //type
    $type = $value['type'];
    //value
    $val = $value['value'];
    $list .= "<li class='ex'><p>$name  <button class='del'>X</button></p>
            <input type='hidden' value='$type' id='type'>
            <input type='hidden' value='$val' id='value'>
            </li>";
}

//end list
$footer = "</ol>";

$final = $header;
$final .= $list;
$final .= $footer;

echo $final;