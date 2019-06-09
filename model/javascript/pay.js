//initialize selectmenu
$("#pay-type").selectmenu({
    change: function( event, data ) {
        //Change the HTML to show the corresponding form
        if(data.item.value == "Hourly"){
            $("#response").html(data.item.value);
            hourly();
        }
        else if(data.item.value == "Salary"){
            $("#response").html(data.item.value);
            monthly();
        }
        else if(data.item.value == "Manual (After Tax)"){
            $("#response").html(data.item.value);
            manual();
        }
    }
});

//when the "hourly" option is selected
function hourly(){
    $("input[id=type]").val('hor');
    $("#response").html('<p>' +
        '<strong>Hourly Wage:</strong> <input class="form-control" type="text" id="wage" name="wage"><br>' +
        '<strong>Hours To Be Paid For:</strong> <input class="form-control" type="text" id="hours" name="hours"><br>' +
        '<strong>Percentage Of Pay Taken For Income Tax:</strong> <input class="form-control" type="text" id="tax" name="tax"><br>' +
        '<button class="btn btn-primary" type="submit" id="submit">Submit</button> </p>');
    $("#response").show();
}

//when the "monthly" option is selected
function monthly(){
    $("input[id=type]").val('mon');
    $("#response").html('<p>' +
        '<strong>Monthly Salary:</strong> <input class="form-control" type="text" id="pay" name="pay"><br>' +
        '<strong>Percentage Of Pay Taken For Income Tax:</strong> <input class="form-control" type="text" id="tax" name="tax"><br>' +
        '<button class="btn btn-primary" type="submit" id="submit">Submit</button> </p>');
    $("#response").show();
}

//when the "manual" option is selected
function manual(){
    $("input[id=type]").val('man');
    $("#response").html('<p>' +
        '<strong>Cash Recieved:</strong> <input class="form-control" type="text" id="pay" name="pay"><br>' +
        '<button class="btn btn-primary" type="submit" id="submit">Submit</button> </p>');
    $("#response").show();
}
