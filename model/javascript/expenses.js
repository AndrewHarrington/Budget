$("#expense-list").load("model/get-expenses.php", {uuid: $("#uuid").val()});
$("#add").on('click', function(){
    //TODO: update the expense list

    //get the new expense list
    $("#expense-list").load("model/get-expenses.php", {uuid: $("#uuid").val()});
});