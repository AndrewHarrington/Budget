$("#expense-list").load("model/ajax-expenses.php", {uuid: $("#uuid").val()});
//reload the list when a new expense is added
$("#add").on('click', function(){
    $("#expense-list").load("model/ajax-expenses.php", {uuid: $("#uuid").val()});
});