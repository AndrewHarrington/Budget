//on page load
loadExpenses();

//click events
$("#add").on('click', function(){
    //TODO: update the expense list
    var uuid = $("#uuid").val();
    var name = $("#name").val();
    var type = $("input[name='type']:checked").val();
    var amount = $("#amount").val();

    $.post("model/ajax/insert-expense.php", {uuid: uuid, name: name, type: type, amount: amount});

    loadExpenses();
});

//set click events for the list item and the delete button
var items = document.getElementsByClassName("ex");
for(var i in items){
    items[i].onclick = function(){
        viewItem(this);
    };
}

//set click events for the list item and the delete button
var items = document.getElementsByClassName("del");
for(var i in items){
    items[i].onclick = function(){
        delItem(this);
    };
}

//functions
function viewItem(element) {
    //TODO: Make this function display the data of the contained item and allow for editing
}

function delItem(){
    //TODO: Make this function delete the clicked object from the DB
}

function loadExpenses(){
    var uuid = $("#uuid").val();
    $.post("model/ajax/get-expenses.php", {uuid: uuid}, function(result){
        $("#expense-list").html(result);
    });
}