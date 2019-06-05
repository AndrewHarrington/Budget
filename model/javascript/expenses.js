//on page load
loadExpenses();

//click events
$("#add").on('click', function(){
    //TODO: update the expense list
    var uuid = $("#uuid").val();
    var name = $("#name").val();
    var type = $("input[name='type']:checked").val();
    var amount = $("#amount").val();

    $.post("/model/ajax/insert-expense.php", {uuid: uuid, name: name, type: type, amount: amount}, function (results){
        $("#test").html(results);
    });
    loadExpenses();
});

$("#finished").on('click', function(){
    window.location.assign('/328/budget/results');
});

//functions
function viewItem(element) {
    //TODO: Make this function display the data of the contained item and allow for editing
}

function delItem(button){

    var id = button.id;

    $.post("model/ajax/remove-expense.php", {id: id});

    loadExpenses();
}

function loadExpenses(){
    var uuid = $("#uuid").val();
    $.post("model/ajax/get-expenses.php", {uuid: uuid}, function(result){
        $("#expense-list").html(result);
        setViewClickEvents();
        setDeleteClickEvenets();
    });
}

function setViewClickEvents(){
    //set click events for the list item and the delete button
    var items = document.getElementsByClassName("ex");
    for(var i in items){
        items[i].onclick = function(){
            viewItem(this);
        };
    }
}

function setDeleteClickEvenets() {
    //set click events for the list item and the delete button
    var items = document.getElementsByClassName("del");
    for(var i in items){
        items[i].onclick = function(){
            delItem(this);
        };
    }
}