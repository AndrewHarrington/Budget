$("#expense-list").load("model/ajax-expenses.php", {uuid: $("#uuid").val()});