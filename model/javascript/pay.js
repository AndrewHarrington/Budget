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
    $("#type").val("hor");
    $("#response").html('<p>' +
        'Hourly Wage: <input type="text" id="wage"><br>' +
        'Hours To Be Paid For: <input type="text" id="hours"><br>' +
        'Percentage Of Pay Taken For Income Tax: <input type="text" id="tax"><br>' +
        '<button type="submit" id="submit">Submit</button> </p>');
    $("#response").show();
    $("#submit").on("click", hourCalc);
}

//when the "monthly" option is selected
function monthly(){
    $("#type").val("mon");
    $("#response").html('<p>' +
        'Monthly Salary: <input type="text" id="pay"><br>' +
        'Percentage Of Pay Taken For Income Tax: <input type="text" id="tax"><br>' +
        '<button type="submit" id="submit">Submit</button> </p>');
    $("#response").show();
    $("#submit").on("click", monthCalc);
}

//when the "manual" option is selected
function manual(){
    $("#type").val("man");
    $("#response").html('<p>' +
        'Cash Recieved: <input type="text" id="pay"><br>' +
        '<button type="submit" id="submit">Submit</button> </p>');
    $("#response").show();
    $("#submit").on("click", manCalc);
}
