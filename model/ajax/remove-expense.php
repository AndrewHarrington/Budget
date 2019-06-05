<?php
require  '../functions.php';

//database connection
$dbc = connectToDatabase();

$query = 'DELETE FROM expenses WHERE expenseID = :id';

$id = $_POST['id'];

$statement = $dbc->prepare($query);

$statement->bindParam(':id', $id, PDO::PARAM_STR);

$statement->execute();