<?php

require_once('../functions.php');

//get all of the expenses as and associative array
$uuid = $_POST['uuid'];
$rows = getExpenses($uuid);

//show each li with proper values

//start list
$header = "<ol id='list'>";

$list = '';
//loop
foreach ($rows as $key => $value){
    //id
    $id = $value['expenseID'];
    //name
    $name = $value['name'];
    //type
    $type = $value['type'];
    //value
    $val = $value['value'];

    $list .= "<li class='ex' id='item$id'><p>$name  
                <button type='button' class='btn btn-primary' data-toggle='modal' data-target='#viewExpense'>
                    Edit
                </button>
                <button class='del btn btn-danger' id='$id'>X</button></p>
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